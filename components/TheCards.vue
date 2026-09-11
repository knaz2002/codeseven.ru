<template>
  <div class="cards">
    <div class="cards__container">
      <div :class="['card__wrapper', wrapperClass]">
        <template
          v-for="(card, index) in cards"
          :key="card.id || card.title || nanoid()"
        >
          <a
            v-if="card.url && isExternalUrl(card.url)"
            :href="card.url"
            class="card__link"
            target="_blank"
            rel="noopener noreferrer"
          >
            <div
              ref="cardRefs"
              class="card"
              @mousemove="handleMouseMove($event, index)"
              @mouseleave="resetPosition(index)"
            >
              <div class="card__highlight" ref="highlightRefs" />
              <div v-if="card.img" class="card__img">
                <img :src="card.img" :alt="card.title || 'Card image'" />
              </div>
              <div v-if="card.title" class="card__title">{{ card.title }}</div>
              <div v-if="card.text" class="card__text">{{ card.text }}</div>
              <div v-if="card.description" class="card__description">
                {{ card.description }}
              </div>
            </div>
          </a>

          <NuxtLink v-else-if="card.url" :to="card.url" class="card__link">
            <div
              ref="cardRefs"
              class="card"
              @mousemove="handleMouseMove($event, index)"
              @mouseleave="resetPosition(index)"
            >
              <div class="card__highlight" ref="highlightRefs" />

              <div v-if="card.img" class="card__img">
                <img :src="card.img" :alt="card.title || 'Card image'" />
              </div>
              <div v-if="card.title" class="card__title">{{ card.title }}</div>
              <div v-if="card.text" class="card__text">{{ card.text }}</div>
              <div v-if="card.description" class="card__description">
                {{ card.description }}
              </div>
            </div>
          </NuxtLink>

          <div
            v-else
            ref="cardRefs"
            class="card"
            @mousemove="handleMouseMove($event, index)"
            @mouseleave="resetPosition(index)"
          >
            <div class="card__highlight" ref="highlightRefs" />

            <div v-if="card.img" class="card__img">
              <img :src="card.img" :alt="card.title || 'Card image'" />
            </div>
            <div v-if="card.title" class="card__title">{{ card.title }}</div>
            <div v-if="card.text" class="card__text">{{ card.text }}</div>
            <div v-if="card.description" class="card__description">
              {{ card.description }}
            </div>
          </div>
        </template>
      </div>
    </div>
  </div>
</template>

<script setup>
import gsap from "gsap";
import { nanoid } from "nanoid";
import { onMounted, nextTick, ref } from "vue";

const props = defineProps({
  cards: {
    type: Array,
    required: true,
    default: () => [],
  },
  wrapperClass: [String, Object, Array],
});

const cardRefs = ref([]);
const highlightRefs = ref([]);

const MAX_ROTATION = 10;
const DURATION = 0.6;
const EASE = "power3.out";
const SHADOW_INTENSITY = 20;

const isExternalUrl = (url) => {
  if (!url) return false;
  try {
    const parsed = new URL(url, window.location.href);
    return (
      parsed.protocol !== window.location.protocol ||
      parsed.host !== window.location.host
    );
  } catch {
    return false;
  }
};

const handleMouseMove = (e, index) => {
  const el = cardRefs.value[index];
  const highlight = highlightRefs.value[index];
  if (!el || !highlight) return;

  const rect = el.getBoundingClientRect();
  const centerX = rect.left + rect.width / 2;
  const centerY = rect.top + rect.height / 2;

  const mouseX = e.clientX - centerX;
  const mouseY = e.clientY - centerY;

  const xPercent = mouseX / (rect.width / 2);
  const yPercent = mouseY / (rect.height / 2);

  const rotateY = xPercent * MAX_ROTATION;
  const rotateX = -(yPercent * MAX_ROTATION);

  const shadowX = xPercent * SHADOW_INTENSITY;
  const shadowY = yPercent * SHADOW_INTENSITY;
  const shadowBlur = 20 + Math.abs(xPercent) * 10 + Math.abs(yPercent) * 10;

  const highlightX = (xPercent + 1) * 50;
  const highlightY = (yPercent + 1) * 50;

  gsap.to(el, {
    rotateX,
    rotateY,
    x: shadowX * 0.2,
    y: shadowY * 0.2,
    z: 10,
    boxShadow: `${shadowX}px ${shadowY}px ${shadowBlur}px rgba(0,0,0,0.25)`,
    duration: DURATION,
    ease: EASE,
  });

  gsap.to(highlight, {
    x: `${highlightX}%`,
    y: `${highlightY}%`,
    opacity: 0.6 - (Math.abs(xPercent) + Math.abs(yPercent)) * 0.2,
    duration: DURATION,
    ease: EASE,
  });
};

const resetPosition = (index) => {
  const el = cardRefs.value[index];
  const highlight = highlightRefs.value[index];
  if (!el || !highlight) return;

  gsap.to(el, {
    rotateX: 0,
    rotateY: 0,
    x: 0,
    y: 0,
    z: 0,
    boxShadow: "0 6px 20px rgba(0,0,0,0.12)",
    duration: 0.8,
    ease: "elastic.out(1, 0.3)",
  });

  gsap.to(highlight, {
    opacity: 0,
    duration: 0.5,
    ease: "power2.out",
  });
};

onMounted(() => {
  nextTick(() => {
    cardRefs.value.forEach((el) => {
      if (el) {
        el.style.transformStyle = "preserve-3d";
        el.style.backfaceVisibility = "hidden";
      }
    });
  });
});
</script>

<style lang="scss" scoped>
.cards {
  width: 100%;
  &__container {
  }
}

.card {
  position: relative;
  box-shadow: 0 6px 20px rgba(0, 0, 0, 0.12);
  cursor: pointer;
  transform-style: preserve-3d;
  backface-visibility: hidden;
  min-height: 30rem;
  height: 100%;
  &__wrapper {
    width: 100%;
  }
  &__link {
    height: 100%;
  }

  &__highlight {
    position: absolute;
    top: 0;
    left: 0;
    width: 8rem;
    height: 8rem;
    background: radial-gradient(
      circle,
      rgba(255, 255, 255, 0.8) 0%,
      transparent 70%
    );
    border-radius: 50%;
    pointer-events: none;
    opacity: 0;
    transform: translate(-50%, -50%);
    z-index: 1;
  }

  &__img {
    width: 100%;

    margin-bottom: 1.6rem;
    border-radius: 0.8rem;
    overflow: hidden;

    img {
      width: 100%;
      height: auto;
      display: block;
      object-fit: cover;
    }
  }

  &__title {
    font-size: 2rem;
    font-weight: 600;
    color: var(--text);
    margin-bottom: 0.8rem;
  }

  &__text {
    font-size: 1.4rem;
    color: var(--text);
    margin-bottom: 1.2rem;
    font-weight: 400;
    line-height: 1.5;
  }

  &__description {
    font-size: 0.9rem;
    color: var(--text);
    line-height: 1.4;
  }
}
</style>
