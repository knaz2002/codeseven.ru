<template>
  <div
    v-if="isClient"
    class="vertical-slider-wrapper"
    :style="{ height: sliderHeight + 'px' }"
  >
    <Swiper
      ref="swiperRef"
      direction="vertical"
      :mousewheel="{
        forceToAxis: true,
        sensitivity: 1,
        releaseOnEdges: true,
      }"
      :keyboard="{ enabled: true }"
      :slidesPerView="1"
      :spaceBetween="0"
      :loop="false"
      :pagination="{
        clickable: true,
        type: 'bullets',
        el: '.swiper-pagination',
        bulletClass: 'swiper-pagination-bullet',
        bulletActiveClass: 'swiper-pagination-bullet-active',
      }"
      :navigation="{
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
      }"
      :allowTouchMove="allowTouchMove"
      :speed="800"
      :modules="[Mousewheel, Keyboard, Pagination, Navigation]"
      class="vertical-slider"
      @swiper="onSwiperInit"
      @slideChange="onSlideChange"
      @transitionEnd="onTransitionEnd"
    >
      <SwiperSlide v-for="(section, index) in sections" :key="index">
        <slot :name="`section-${index}`" />
      </SwiperSlide>
    </Swiper>

    <div class="swiper-pagination"></div>

    <button class="swiper-button-prev">
      <svg
        viewBox="0 0 24 24"
        fill="none"
        stroke="currentColor"
        stroke-width="2"
      >
        <path d="M18 15l-6-6-6 6" />
      </svg>
    </button>
    <button class="swiper-button-next">
      <svg
        viewBox="0 0 24 24"
        fill="none"
        stroke="currentColor"
        stroke-width="2"
      >
        <path d="M6 9l6 6 6-6" />
      </svg>
    </button>
  </div>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount, nextTick, defineExpose } from "vue";
import { Swiper, SwiperSlide } from "swiper/vue";
import { Mousewheel, Keyboard, Pagination, Navigation } from "swiper/modules";

import "swiper/css";
import "swiper/css/pagination";
import "swiper/css/navigation";

const emit = defineEmits(["ready"]);

const props = defineProps({
  sections: {
    type: Array,
    required: true,
    default: () => [],
  },
  allowTouchMove: {
    type: Boolean,
    default: true,
  },
});

const isClient = ref(false);
const swiperRef = ref(null);
const sliderHeight = ref(0);
const swiperReady = ref(false);
let internalSwiper = null; // ← храним реальный экземпляр Swiper

const onSwiperInit = (swiperInstance) => {
  internalSwiper = swiperInstance;
  swiperReady.value = true;
  emit("ready");
};

const goToSlideById = (targetId) => {
  const index = props.sections.findIndex((section) => section.id === targetId);

  if (index === -1) {
    // console.warn(`[TheVerticalSlider] Секция с id="${targetId}" не найдена`);
    return;
  }

  if (swiperReady.value && internalSwiper) {
    internalSwiper.slideTo(index, 800);
  } else {
    // console.warn("[TheVerticalSlider] Swiper ещё не готов для прокрутки");
  }
};

const onTransitionEnd = () => {
  window.dispatchEvent(new CustomEvent("swiper-transition-end"));
};

const onSlideChange = () => {};

const updateSliderHeight = () => {
  if (typeof window !== "undefined") {
    sliderHeight.value = window.innerHeight;
    nextTick(() => {
      if (internalSwiper) {
        internalSwiper.update();
      }
    });
  }
};

onMounted(() => {
  isClient.value = true;
  updateSliderHeight();

  let resizeTimeout;
  const handleResize = () => {
    clearTimeout(resizeTimeout);
    resizeTimeout = setTimeout(updateSliderHeight, 100);
  };

  window.addEventListener("resize", handleResize);

  onBeforeUnmount(() => {
    window.removeEventListener("resize", handleResize);
    clearTimeout(resizeTimeout);
  });
});

defineExpose({
  goToSlideById,
});
</script>

<style lang="scss" scoped>
.vertical-slider-wrapper {
  position: relative;
  width: 100%;
  overflow: hidden;

  .swiper-pagination {
    position: absolute;
    top: 50%;
    right: 20px;
    transform: translateY(-50%);
    display: flex;
    flex-direction: column;
    gap: 10px;
    z-index: 1;

    .swiper-pagination-bullet {
      width: 12px;
      height: 12px;
      background-color: #ccc;
      opacity: 1;
      border-radius: 50%;
      transition: all 0.3s ease;

      &.swiper-pagination-bullet-active {
        background-color: var(--light, #fff);
        transform: scale(1.4);
      }
    }
  }

  .swiper-button-prev,
  .swiper-button-next {
    position: absolute;
    bottom: 0;
    background: none;
    border: none;
    cursor: pointer;
    z-index: 10;
    opacity: 0.2;
    transition: opacity 0.3s ease;
    box-shadow: 0 0 4px rgba(0, 0, 0, 0.2);
    color: var(--text);
    outline: none;
    border: solid 1px var(--text);
    width: 4rem;
    height: 4rem;
    border-radius: 100%;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;

    &::after {
      display: none;
    }

    &:hover {
      @media (any-hover: hover) {
        opacity: 1;
      }
    }

    svg {
      position: absolute;
      left: 50%;
      top: 50%;
      transform: translate(-50%, -50%);
      path {
        stroke: var(--text);
      }
    }
  }

  .swiper-button-prev {
    top: 95%;
    left: calc(48% - 4rem);
  }

  .swiper-button-next {
    top: 95%;
    right: calc(48% - 4rem);
  }

  :deep(.swiper-no-swiping) {
    touch-action: auto !important;
  }
}

.vertical-slider {
  height: 100%;
  width: 100%;

  .swiper-wrapper {
    transition-timing-function: cubic-bezier(0.34, 1.56, 0.64, 1) !important;
  }

  .swiper-slide {
    height: 100% !important;
    min-height: 100%;
    width: 100% !important;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0;
    box-sizing: border-box;
    overflow: hidden;
  }
}
</style>
