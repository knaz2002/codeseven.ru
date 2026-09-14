<template>
  <div class="carousel-3d-icon-box-wrapper">
    <div
      :class="[
        'carousel-3d-icon-box',
        item.mod ? `carousel-3d-icon-box--${item.mod}` : '',
      ]"
    >
      <img :src="item.img" alt="" @error="onImageError" />

      <!--
        Отдельный визуальный слой ripple находится непосредственно внутри
        плашки услуги. Благодаря этому волна заполняет всю площадь карточки,
        а overflow у самой плашки обрезает её точно по границам элемента.
      -->
      <span class="carousel-3d-ripple" aria-hidden="true"></span>
    </div>
    <div v-if="item.text && item.text.trim() !== ''" class="carousel-3d-text">
      <span v-for="(part, idx) in item.text.split('<br>')" :key="idx">
        {{ part }}
        <br v-if="idx < item.text.split('<br>').length - 1" />
      </span>
    </div>
  </div>
</template>

<script setup lang="ts">
defineProps<{
  item: {
    href: string;
    img: string;
    text: string;
    mod?: string;
  };
}>();

const onImageError = (e: Event) => {
  const target = e.target as HTMLImageElement | null;
  if (target) {
    target.src =
      "data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI4MCIgaGVpZ2h0PSI4MCI+PHJlY3Qgd2lkdGg9IjgwIiBoZWlnaHQ9IjgwIiBmaWxsPSIjZmZmIi8+PC9zdmc+";
  }
};
</script>

<style lang="scss" scoped>
.carousel-3d-icon-box-wrapper {
  display: flex;
  flex-direction: column;
  align-items: center;
}

.carousel-3d-icon-box {
  width: 15rem;
  height: 15rem;
  border-radius: var(--radius);
  display: flex;
  align-items: center;
  justify-content: center;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  @media (max-width: 991px) {
    width: 9rem;
    height: 9rem;
  }
}

.carousel-3d-icon-box--primary {
  background: rgba(var(--primary));
}

.carousel-3d-icon-box--black {
  background: #1c1c1c;
  svg { 
    path {
      fill: #fff;
    }
  }
}

.carousel-3d-icon-box img {
  width: 7.5rem;
  height: 7.5rem;
  object-fit: contain;
  @media (max-width: 991px) {
    width: 4.5rem;
    height: 4.5rem;
  }
}

.carousel-3d-text {
  margin-top: 1.2rem;
  text-align: center;
  font-size: 1.4rem;
  font-weight: 500;
  line-height: 1.3;
  color: var(--text);
  text-shadow: 0 1px 2px rgba(0, 0, 0, 0.5);

  @media (max-width: 991px) {
    margin-top: 0.8rem;
    font-size: 12px;
  }
}

.carousel-3d-icon-box {
  position: relative;
  overflow: hidden;
  background-color: transparent !important;
  border: solid 1px #fff;
  box-shadow:
    0 0 6px rgba(255, 255, 255, 0.45),
    0 0 3px rgba(255, 255, 255, 0.35),
    inset 0 0 2px rgba(255, 255, 255, 0.25)
    !important;

  img {
    opacity: 0.6;
  }  

  &::before {
    content: '';
    position: absolute;
    top: .75rem;
    left: .75rem;
    right: .75rem;
    bottom: .75rem;
    background: rgba(255, 255, 255, 0.12);
    z-index: -1;
    pointer-events: none;
    border-radius: 8px;
  }
}

/*
 * Реальный слой световой волны внутри плашки услуги.
 *
 * В исходном состоянии он невидим. MainSlider.vue запускает его через GSAP
 * только в момент, когда активная передняя карточка проходит через центр
 * контейнера по горизонтали.
 */
.carousel-3d-ripple {
  position: absolute;
  inset: 0;
  display: block;
  border-radius: inherit;
  pointer-events: none;
  z-index: 5;

  /*
   * Это именно внутренняя волна, а не дополнительная рамка.
   * Яркое световое кольцо начинается около центра и при масштабировании
   * проходит через всю площадь плашки до её углов.
   */
  background:
    radial-gradient(
      circle at center,
      rgba(255, 255, 255, 0.08) 0%,
      rgba(255, 255, 255, 0.12) 18%,
      rgba(255, 255, 255, 0.95) 27%,
      rgba(255, 255, 255, 0.55) 34%,
      rgba(255, 255, 255, 0.16) 43%,
      rgba(255, 255, 255, 0) 56%
    );

  mix-blend-mode: screen;

  opacity: 0;
  transform: scale(0.05);
  transform-origin: center center;

  will-change: transform, opacity;
}

</style>
