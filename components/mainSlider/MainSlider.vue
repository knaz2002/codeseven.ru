<template>
  <div class="carousel-3d__container">
    <div ref="containerRef" class="carousel-3d" aria-label="3D карусель услуг">
      <div
        v-for="(item, index) in sliderItems"
        :key="index"
        ref="items"
        class="carousel-3d-item"
      >
        <NuxtLink
          v-if="isInternal(item.href) && !isFeedbackItem(item) && !item.isFile"
          :to="item.href"
          class="carousel-3d-item-link"
          @click.stop="(e) => handleClick(e, item)"
        >
          <ItemContent :item="item" />
        </NuxtLink>
        <a
          v-else-if="!isFeedbackItem(item)"
          :href="item.href"
          class="carousel-3d-item-link"
          :target="isExternal(item.href) ? '_blank' : undefined"
          rel="noopener"
          @click.stop="(e) => handleClick(e, item)"
        >
          <ItemContent :item="item" />
        </a>
        <button
          v-else
          type="button"
          class="carousel-3d-item-link feedback-trigger"
          @click.stop="openFeedbackModal"
          aria-label="Открыть форму обратной связи"
        >
          <ItemContent :item="item" />
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { onMounted, onBeforeUnmount, ref, nextTick } from "vue";
import gsap from "gsap";
import ItemContent from "./ItemContent.vue";
import { useModalStore } from "~/stores/modal"; // ← импортируем хранилище модалок

const modalStore = useModalStore(); // ← инициализируем хранилище

const sliderItems = [
  {
    href: "#",
    img: "/img/carousel/analitics.svg",
    text: "Аналитика",
    mod: "black",
    slideId: "portfolio",
    modalId: "analytics",
  },
  {
    href: "#",
    img: "/img/carousel/design.svg",
    text: "Дизайн",
    mod: "black",
    slideId: "portfolio",
    modalId: "designer",
  },
  {
    href: "/develop",
    img: "/img/carousel/develop.svg",
    text: "Разработка",
    mod: "black",
  },
  {
    href: "/opd.pdf",
    target: "_blank",
    img: "/img/carousel/opd.svg",
    text: "ОПД",
    mod: "black",
    isFile: true,
  },
  {
    href: "#",
    img: "/img/carousel/feedback.svg",
    text: "Обратная<br>связь",
    mod: "black",
  },
  {
    href: "#",
    img: "/img/carousel/sites.svg",
    text: "Сайты<br>и веб-проекты",
    mod: "primary",
    slideId: "portfolio",
  },
  {
    href: "/it-outsourcing",
    img: "/img/carousel/outsource.svg",
    text: "IT-outsource",
    mod: "primary",
  },
  {
    href: "#",
    img: "/img/carousel/its.svg",
    text: "1С: outstaff",
    mod: "primary",
    modalId: "outstaff",
  },
  {
    href: "/ai",
    img: "/img/carousel/leadgen.svg",
    text: "AI агенты",
    mod: "primary",
  },
  {
    href: "#",
    img: "/img/carousel/seo.svg",
    text: "SEO-продвижение",
    mod: "primary",
    modalId: "seo",
  },
];

const isInternal = (href) =>
  href.startsWith("/") && !href.startsWith("//") && !href.startsWith("http");
const isExternal = (href) => href.startsWith("http") || href.startsWith("//");
const isFeedbackItem = (item) => item.text.includes("Обратная");

const openFeedbackModal = () => {
  modalStore.openModal("call"); // ← открываем модалку через хранилище
};

const sliderController = ref(null);
const pendingScrollId = ref(null); // ← новое: запоминаем, к какому id скроллить

const setSliderController = (fn) => {
  sliderController.value = fn;
};

// Экспортируем метод для внешнего вызова скролла
const scrollToPendingAnchor = () => {
  if (pendingScrollId.value) {
    const el = document.getElementById(pendingScrollId.value);
    if (el) {
      el.scrollIntoView({ behavior: "smooth", block: "start" });
      history.pushState(null, "", `#${pendingScrollId.value}`);
    }
    pendingScrollId.value = null;
  }
};

const handleClick = (event, item) => {
  // Если есть modalId — открываем модалку
  if (item.modalId) {
    event.preventDefault();
    modalStore.openModal(item.modalId);
    return;
  }

  // Иначе — обрабатываем как раньше (slideId + scroll)
  if (item.slideId && sliderController.value) {
    event.preventDefault();
    pendingScrollId.value = item.slideId;
    sliderController.value(item.slideId);
    return;
  }

  // Переход на другую страницу с карусели — запоминаем секцию для возврата
  if (isInternal(item.href) && !item.isFile) {
    sessionStorage.setItem("homeSection", "main-slider");
  }
};

const containerRef = ref(null);
const items = ref([]);

let rotation = 0;
let isDragging = false;
let autoRotateTL = null;

const DRAG_SENSITIVITY = 0.5;
const MIN_INERTIA_VELOCITY = 30;
const INERTIA_DECAY = 0.93;
const AUTO_ROTATE_DURATION = 100;
const AUTO_ROTATE_ENABLED = true;
const MOBILE_ROW_OFFSET = 110;

const getMode = () => {
  const w = window.innerWidth;
  if (w <= 767) return "mobile";
  if (w <= 991) return "tablet-sm";
  if (w <= 1359) return "tablet-lg";
  return "desktop";
};

const updatePositions = () => {
  const mode = getMode();
  const total = sliderItems.length;
  let radius;

  if (mode === "mobile") {
    radius = Math.min(window.innerWidth * 0.7, 120);
  } else if (mode === "tablet-sm") {
    radius = Math.min(window.innerWidth * 0.55, 220);
  } else if (mode === "tablet-lg") {
    radius = Math.min(window.innerWidth * 0.45, 420);
  } else {
    radius = Math.min(window.innerWidth, window.innerHeight) * 0.65;
  }

  const els = items.value;
  if (!els?.length) return;

  if (mode === "mobile") {
    const half = Math.ceil(total / 2);
    const step = (2 * Math.PI) / half;
    const baseRadius = Math.min(window.innerWidth * 0.7, 120);
    const verticalArcScale = 0.18;

    for (let i = 0; i < total; i++) {
      const isBottomRow = i >= half;
      const indexInRow = isBottomRow ? i - half : i;
      const angle = (rotation * Math.PI) / 180 + indexInRow * step;
      const x = Math.sin(angle) * baseRadius;
      const yArc = Math.cos(angle) * baseRadius * verticalArcScale;
      const yBase = isBottomRow ? -MOBILE_ROW_OFFSET : MOBILE_ROW_OFFSET;
      const y = yBase + yArc;
      const depth = (1 + Math.cos(angle)) / 2;
      const opacity = 0.35 + 0.65 * depth;
      const scale = 0.82 + 0.18 * depth;

      gsap.set(els[i], {
        x,
        y,
        scale,
        opacity,
        zIndex: Math.round(depth * 100),
        transformOrigin: "center",
      });
    }
  } else {
    const step = (2 * Math.PI) / total;
    const yScale = mode === "tablet-sm" ? 0.32 : 0.26;

    for (let i = 0; i < total; i++) {
      const angle = (rotation * Math.PI) / 180 + i * step;
      const x = Math.sin(angle) * radius;
      const y = -Math.cos(angle) * radius * yScale;
      const depth = (1 + Math.cos(angle)) / 2;
      const opacity = 0.3 + 0.7 * depth;
      const scale =
        mode === "tablet-lg" ? 1.05 : mode === "tablet-sm" ? 0.92 : 1;

      gsap.set(els[i], {
        x,
        y,
        scale,
        opacity,
        zIndex: Math.round(depth * 100),
        transformOrigin: "center",
      });
    }
  }
};

const startAutoRotate = () => {
  if (!AUTO_ROTATE_ENABLED) return;
  if (autoRotateTL) autoRotateTL.play();
};

const stopAutoRotate = () => {
  if (autoRotateTL) autoRotateTL.pause();
};

let startX = 0;
let startY = 0;
let velocity = 0;
let lastTime = 0;
let animationId = null;
let dragDistance = 0;
let shouldPreventDefault = false;
let isHorizontalGesture = false;

const handleStart = (clientX, clientY) => {
  stopAutoRotate();
  isDragging = true;
  startX = clientX;
  startY = clientY;
  velocity = 0;
  lastTime = Date.now();
  dragDistance = 0;
  shouldPreventDefault = false;
  isHorizontalGesture = false;
  if (animationId) cancelAnimationFrame(animationId);

  window.dispatchEvent(new CustomEvent("carousel-drag-start"));
};

const handleMove = (clientX, clientY) => {
  if (!isDragging) return;

  const deltaX = clientX - startX;
  const deltaY = clientY - startY;
  const now = Date.now();
  const dt = (now - lastTime) / 1000;

  if (Math.abs(deltaX) > Math.abs(deltaY)) {
    isHorizontalGesture = true;
  }

  if (dt > 0 && isHorizontalGesture) {
    dragDistance += Math.abs(deltaX);
    if (dragDistance > 5) shouldPreventDefault = true;
    velocity = deltaX / dt;
    rotation += deltaX * DRAG_SENSITIVITY;
    startX = clientX;
    lastTime = now;
    updatePositions();
  }
};

const handleEnd = () => {
  if (!isDragging) return;
  isDragging = false;

  if (
    shouldPreventDefault &&
    Math.abs(velocity) > MIN_INERTIA_VELOCITY &&
    isHorizontalGesture
  ) {
    animateInertia();
  } else {
    shouldPreventDefault = false;
    startAutoRotate();
  }

  window.dispatchEvent(new CustomEvent("carousel-drag-end"));
};

const animateInertia = () => {
  if (Math.abs(velocity) < 5) {
    startAutoRotate();
    return;
  }
  rotation += velocity * 0.016 * DRAG_SENSITIVITY;
  velocity *= INERTIA_DECAY;
  updatePositions();
  animationId = requestAnimationFrame(animateInertia);
};

const handleMouseDown = (e) => {
  handleStart(e.clientX, e.clientY);
  e.stopPropagation();
};

const handleMouseMove = (e) => {
  handleMove(e.clientX, e.clientY);
  if (shouldPreventDefault && isHorizontalGesture) {
    e.preventDefault();
    e.stopPropagation();
  }
};

const handleMouseUp = () => handleEnd();

const handleTouchStart = (e) => {
  if (e.touches.length === 1) {
    handleStart(e.touches[0].clientX, e.touches[0].clientY);
  }
};

const handleTouchMove = (e) => {
  if (e.touches.length === 1) {
    handleMove(e.touches[0].clientX, e.touches[0].clientY);
    if (shouldPreventDefault && isHorizontalGesture) {
      e.preventDefault();
      e.stopPropagation();
    }
  }
};

const handleTouchEnd = () => handleEnd();

const handleResize = () => updatePositions();

onMounted(() => {
  nextTick(() => {
    rotation = 0;
    updatePositions();

    autoRotateTL = gsap.timeline({ repeat: -1, paused: true });
    autoRotateTL.to(
      {},
      {
        duration: AUTO_ROTATE_DURATION,
        ease: "none",
        onUpdate: () => {
          rotation += 360 / (AUTO_ROTATE_DURATION * 60);
          updatePositions();
        },
      },
    );

    const container = containerRef.value;
    if (container) {
      container.addEventListener("mousedown", handleMouseDown);
      container.addEventListener("mousemove", handleMouseMove);
      container.addEventListener("mouseup", handleMouseUp);
      container.addEventListener("touchstart", handleTouchStart, {
        passive: true,
      });
      container.addEventListener("touchmove", handleTouchMove, {
        passive: false,
      });
      container.addEventListener("touchend", handleTouchEnd, { passive: true });
    }

    window.addEventListener("resize", handleResize);
    if (AUTO_ROTATE_ENABLED) {
      startAutoRotate();
    }
  });
});

onBeforeUnmount(() => {
  if (animationId) cancelAnimationFrame(animationId);
  if (autoRotateTL) autoRotateTL.kill();
  const container = containerRef.value;
  if (container) {
    container.removeEventListener("mousedown", handleMouseDown);
    container.removeEventListener("mousemove", handleMouseMove);
    container.removeEventListener("mouseup", handleMouseUp);
    container.removeEventListener("touchstart", handleTouchStart);
    container.removeEventListener("touchmove", handleTouchMove);
    container.removeEventListener("touchend", handleTouchEnd);
  }
  window.removeEventListener("resize", handleResize);
});

defineExpose({
  rotateTo: (angle) => {
    stopAutoRotate();
    rotation = angle;
    updatePositions();
  },
  startAutoRotate,
  stopAutoRotate,
  getRotation: () => rotation,
  setSliderController,
  scrollToPendingAnchor, // ← ключевой метод
});
</script>

<style scoped>
.carousel-3d__container {
  position: relative;
  width: 100%;
  height: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
  perspective: 1000px;
  /* verflow: hidden; */
}

.carousel-3d {
  position: relative;
  width: 100%;
  height: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
  transform-style: preserve-3d;
  cursor: grab;
  touch-action: none;
}

.carousel-3d:active {
  cursor: grabbing;
}

.carousel-3d-item {
  position: absolute;
  display: flex;
  align-items: center;
  justify-content: center;
  backface-visibility: hidden;
  will-change: transform, opacity, scale;
  user-select: none;
  pointer-events: auto;
}

.carousel-3d-item-link {
  display: block;
  width: 100%;
  height: 100%;
  text-decoration: none;
  color: inherit;
  border: none;
  background: none;
  padding: 0;
  cursor: pointer;
}

@media (max-width: 767px) {
  .carousel-3d-item {
    width: 140px;
    height: 140px;
  }
}

@media (min-width: 768px) and (max-width: 991px) {
  .carousel-3d-item {
    width: 160px;
    height: 160px;
  }
}

@media (min-width: 992px) and (max-width: 1359px) {
  .carousel-3d-item {
    width: 180px;
    height: 180px;
  }
}

@media (min-width: 1360px) {
  .carousel-3d-item {
    width: 220px;
    height: 220px;
  }
}
</style>
