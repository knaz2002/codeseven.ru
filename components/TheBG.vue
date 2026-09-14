<template>
  <canvas ref="canvas" class="starry-sky-canvas"></canvas>
</template>

<script setup lang="ts">
import { onMounted, onUnmounted, ref } from "vue";

const canvas = ref<HTMLCanvasElement | null>(null);
let ctx: CanvasRenderingContext2D | null = null;
let width = 0;
let height = 0;
let mouseX = 0;
let mouseY = 0;
let rafId: number | null = null;

// ┌───────────────────────────────────────────────────────────────────────┐
// │ ⭐ ОСНОВНЫЕ ПАРАМЕТРЫ ЗВЁЗДНОГО НЕБА                                    │
// └───────────────────────────────────────────────────────────────────────┘

// ОПРЕДЕЛЕНИЕ МОБИЛЬНОГО УСТРОЙСТВА — отложено до onMounted (чтобы не ломать SSR)
let isMobile = false;

// КОЛИЧЕСТВО ЗВЁЗД — будем инициализировать в onMounted
let STAR_COUNT = 26;

// РАЗМЕР ЗВЕЗД (максимальный)
const STAR_SIZE = 5;

// РАДИУС ДВИЖЕНИЯ (амплитуда дрожания)
let JITTER_AMOUNT = 5.8;

// ЧАСТОТА ДВИЖЕНИЯ (скорость дрожания)
let JITTER_FREQUENCY = 0.003;

// СИЛА ПАРАЛЛАКСА
const DEPTH_FACTOR = 0.06;

// ПАРАМЕТРЫ СВЕЧЕНИЯ — оптимизированы под мобильные
let GLOW_BLUR = 2;
let GLOW_ALPHA = 0.65;

// ЦВЕТ ЗВЁЗД — определяется динамически при каждом кадре
const getStarColor = () => {
  return document.body.classList.contains("dark-mode") ? "#fffff0" : "#414A4C";
};

// ┌───────────────────────────────────────┐
// │ СТРУКТУРА ЗВЕЗДЫ                      │
// └───────────────────────────────────────┘
interface Star {
  x: number;
  y: number;
  z: number;
  size: number;

  // Обычные звёзды получают собственные параметры движения,
  // чтобы их траектории и амплитуды не совпадали.
  phaseX: number;
  phaseY: number;
  secondaryPhase: number;
  amplitudeX: number;
  amplitudeY: number;
  frequencyX: number;
  frequencyY: number;
  curveFactor: number;

  // Примерно 10% звёзд являются "странниками".
  // Они перемещаются практически по всей площади экрана.
  isWanderer: boolean;
  wanderPhaseX: number;
  wanderPhaseY: number;
  wanderSpeedX: number;
  wanderSpeedY: number;
}

let stars: Star[] = [];

// ┌───────────────────────────────────────┐
// │ ГЕНЕРАЦИЯ ЗВЁЗД                       │
// └───────────────────────────────────────┘
const initStars = () => {
  stars = [];

  // Ровно около 10% звёзд будут перемещаться
  // почти по всей площади экрана.
  const wandererCount = Math.max(1, Math.round(STAR_COUNT * 0.1));

  // Формируем список индексов и перемешиваем его,
  // чтобы "странниками" при каждом запуске становились разные звёзды.
  const indexes = Array.from({ length: STAR_COUNT }, (_, index) => index);

  for (let i = indexes.length - 1; i > 0; i--) {
    const randomIndex = Math.floor(Math.random() * (i + 1));
    [indexes[i], indexes[randomIndex]] = [indexes[randomIndex], indexes[i]];
  }

  const wandererIndexes = new Set(indexes.slice(0, wandererCount));

  for (let i = 0; i < STAR_COUNT; i++) {
    const depth = Math.random();

    stars.push({
      x: Math.random() * width,
      y: Math.random() * height,
      z: depth,

      // Размер звезды оставляем случайным.
      size: Math.random() * STAR_SIZE,

      phaseX: Math.random() * Math.PI * 2,
      phaseY: Math.random() * Math.PI * 2,
      secondaryPhase: Math.random() * Math.PI * 2,

      // У обычных звёзд амплитуда теперь существенно больше.
      // Диапазоны по X и Y намеренно различаются.
      amplitudeX: 18 + Math.random() * 42,
      amplitudeY: 18 + Math.random() * 42,

      // Собственная скорость каждой звезды.
      frequencyX: 0.00045 + Math.random() * 0.0011,
      frequencyY: 0.00045 + Math.random() * 0.0011,

      // Дополнительное искривление траектории.
      curveFactor: 0.25 + Math.random() * 0.55,

      isWanderer: wandererIndexes.has(i),

      // У каждой крупно перемещающейся звезды
      // совершенно независимые фазы.
      wanderPhaseX: Math.random() * Math.PI * 2,
      wanderPhaseY: Math.random() * Math.PI * 2,

      // Периоды движения отличаются друг от друга.
      // Благодаря этому звёзды не идут одной группой.
      wanderSpeedX: 0.00007 + Math.random() * 0.00011,
      wanderSpeedY: 0.00006 + Math.random() * 0.00013,
    });
  }
};

// ┌───────────────────────────────────────┐
// │ ОТРИСОВКА ОДНОЙ ЗВЕЗДЫ                │
// └───────────────────────────────────────┘
const drawStar = (star: Star, time: number) => {
  if (!ctx) return;

  const depthFactor = star.z;

  // Реакцию на мышь сохраняем как отдельный эффект параллакса.
  const offsetX = mouseX * depthFactor * DEPTH_FACTOR * width;
  const offsetY = mouseY * depthFactor * DEPTH_FACTOR * height;

  let x: number;
  let y: number;

  if (star.isWanderer) {
    /*
     * Около 10% звёзд двигаются практически по всему экрану.
     *
     * По горизонтали они используют до 47% ширины
     * относительно центра, а по вертикали — до 46% высоты.
     *
     * Разные скорости X и Y образуют индивидуальные
     * траектории Лиссажу вместо одинаковых окружностей.
     */
    const horizontalSpan =
      0.45 +
      Math.sin(time * star.wanderSpeedY * 0.19 + star.phaseX) * 0.02;

    const verticalSpan =
      0.44 +
      Math.cos(time * star.wanderSpeedX * 0.17 + star.phaseY) * 0.02;

    x =
      width *
        (
          0.5 +
          Math.sin(
            time * star.wanderSpeedX + star.wanderPhaseX,
          ) *
            horizontalSpan
        ) +
      offsetX * 0.12;

    y =
      height *
        (
          0.5 +
          Math.sin(
            time * star.wanderSpeedY + star.wanderPhaseY,
          ) *
            verticalSpan
        ) +
      offsetY * 0.12;
  } else {
    /*
     * Остальные звёзды двигаются локально,
     * но теперь каждая имеет собственную амплитуду,
     * собственную скорость и дополнительную волну.
     */
    const primaryX =
      Math.sin(
        time * star.frequencyX + star.phaseX,
      ) * star.amplitudeX;

    const primaryY =
      Math.cos(
        time * star.frequencyY + star.phaseY,
      ) * star.amplitudeY;

    const secondaryX =
      Math.sin(
        time * star.frequencyY * 0.53 + star.secondaryPhase,
      ) *
      star.amplitudeY *
      star.curveFactor;

    const secondaryY =
      Math.cos(
        time * star.frequencyX * 0.41 +
          star.secondaryPhase * 1.37,
      ) *
      star.amplitudeX *
      star.curveFactor;

    // Даже самые дальние звёзды получают заметное движение.
    const movementDepth = 0.45 + depthFactor * 0.55;

    x =
      star.x +
      offsetX +
      (primaryX + secondaryX) * movementDepth;

    y =
      star.y +
      offsetY +
      (primaryY + secondaryY) * movementDepth;
  }

  const color = getStarColor();

  ctx.shadowColor = color;
  ctx.shadowBlur = GLOW_BLUR;
  ctx.globalAlpha = GLOW_ALPHA;
  ctx.fillStyle = color;

  ctx.fillRect(
    x - star.size / 2,
    y - star.size / 2,
    star.size,
    star.size,
  );

  ctx.shadowBlur = 0;
  ctx.shadowColor = "transparent";
  ctx.globalAlpha = 1.0;
};

// ┌───────────────────────────────────────┐
// │ АНИМАЦИОННЫЙ ЦИКЛ                     │
// └───────────────────────────────────────┘
const render = () => {
  if (!ctx) return;
  const time = Date.now();
  ctx.clearRect(0, 0, width, height);
  stars.forEach((star) => drawStar(star, time));
  rafId = requestAnimationFrame(render);
};

// ┌───────────────────────────────────────┐
// │ ОБРАБОТЧИКИ СОБЫТИЙ                   │
// └───────────────────────────────────────┘
const onMouseMove = (e: MouseEvent) => {
  mouseX = e.clientX / width - 0.5;
  mouseY = e.clientY / height - 0.5;
};

const onTouchMove = (e: TouchEvent) => {
  if (e.touches.length === 0) return;
  const touch = e.touches[0];
  mouseX = touch.clientX / width - 0.5;
  mouseY = touch.clientY / height - 0.5;
};

const onResize = () => {
  if (!canvas.value) return;
  width = window.innerWidth;
  height = window.innerHeight;
  canvas.value.width = width;
  canvas.value.height = height;
  ctx = canvas.value.getContext("2d", { alpha: true });
  initStars();
};

let observer: MutationObserver | null = null;
const watchTheme = () => {
  observer = new MutationObserver(() => render());
  observer.observe(document.body, {
    attributes: true,
    attributeFilter: ["class"],
  });
};

// ┌───────────────────────────────────────┐
// │ ЖИЗНЕННЫЙ ЦИКЛ                        │
// └───────────────────────────────────────┘
onMounted(() => {
  // ✅ Определяем мобильное устройство ТОЛЬКО на клиенте
  isMobile =
    /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(
      navigator.userAgent,
    );

  // ✅ Настройка параметров под устройство
  if (isMobile) {
    STAR_COUNT = 26;
    JITTER_AMOUNT = 9.0;
    JITTER_FREQUENCY = 0.0025;
    GLOW_BLUR = 1;
    GLOW_ALPHA = 0.5;
  } else {
    STAR_COUNT = 52;
    JITTER_AMOUNT = 5.8;
    JITTER_FREQUENCY = 0.003;
    GLOW_BLUR = 2;
    GLOW_ALPHA = 0.65;
  }

  onResize();
  window.addEventListener("mousemove", onMouseMove);
  window.addEventListener("touchmove", onTouchMove, { passive: true });
  window.addEventListener("resize", onResize);
  watchTheme();
  render();
});

onUnmounted(() => {
  if (rafId) cancelAnimationFrame(rafId);
  window.removeEventListener("mousemove", onMouseMove);
  window.removeEventListener("touchmove", onTouchMove);
  window.removeEventListener("resize", onResize);
  observer?.disconnect();
});
</script>

<style scoped>
.starry-sky-canvas {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  pointer-events: none;
  z-index: -1;
  background: transparent;
  background-color: var(--light);
}
</style>
