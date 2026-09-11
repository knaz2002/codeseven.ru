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
let STAR_COUNT = 20;

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
  phaseX: number;
  phaseY: number;
}

let stars: Star[] = [];

// ┌───────────────────────────────────────┐
// │ ГЕНЕРАЦИЯ ЗВЁЗД                       │
// └───────────────────────────────────────┘
const initStars = () => {
  stars = [];
  for (let i = 0; i < STAR_COUNT; i++) {
    stars.push({
      x: Math.random() * width,
      y: Math.random() * height,
      z: Math.random(),
      // Размер от почти нуля до STAR_SIZE (не больше!)
      size: Math.random() * STAR_SIZE,
      phaseX: Math.random() * 100,
      phaseY: Math.random() * 100,
    });
  }
};

// ┌───────────────────────────────────────┐
// │ ОТРИСОВКА ОДНОЙ ЗВЕЗДЫ                │
// └───────────────────────────────────────┘
const drawStar = (star: Star, time: number) => {
  if (!ctx) return;

  const depthFactor = star.z;
  const offsetX = mouseX * depthFactor * DEPTH_FACTOR * width;
  const offsetY = mouseY * depthFactor * DEPTH_FACTOR * height;

  const jitterX =
    Math.sin(time * JITTER_FREQUENCY + star.phaseX) *
    JITTER_AMOUNT *
    depthFactor;
  const jitterY =
    Math.cos(time * JITTER_FREQUENCY + star.phaseY) *
    JITTER_AMOUNT *
    depthFactor;

  const x = star.x + offsetX + jitterX;
  const y = star.y + offsetY + jitterY;

  const color = getStarColor();
  ctx.shadowColor = color;
  ctx.shadowBlur = GLOW_BLUR;
  ctx.globalAlpha = GLOW_ALPHA;
  ctx.fillStyle = color;
  ctx.fillRect(x - star.size / 2, y - star.size / 2, star.size, star.size);

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
    STAR_COUNT = 20;
    JITTER_AMOUNT = 9.0;
    JITTER_FREQUENCY = 0.0025;
    GLOW_BLUR = 1;
    GLOW_ALPHA = 0.5;
  } else {
    STAR_COUNT = 40;
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
