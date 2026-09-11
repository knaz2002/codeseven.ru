<template>
  <Swiper
    v-if="typeSlider === 'events'"
    class="slider-swiper slider-swiper--events"
    :modules="modules"
    :loop="options.loop"
    :navigation="options.navigation"
    :slidesPerView="options.slidesPerView"
    :slidesPerGroup="options.slidesPerGroup"
    :centeredSlides="options.centeredSlides"
    :spaceBetween="options.spaceBetween"
    :pagination="options.pagination"
    :breakpoints="options.breakpoints"
    :effect="options.effect"
    :mousewheel="options.mousewheel"
    :autoHeight="options.autoHeight"
  >
    <SwiperSlide v-for="(slide, i) in slider" :key="i">
      <div class="event-item">
        <div class="event-item__photo">
          <a href="#"><img src="/public/image/event.jpg" alt="" /></a>
          <span v-if="slide.frame" class="video-icon" @click="modalVideoOpen(slide.frame)"> </span>
        </div>
        <div class="event-item__info">
          <div v-if="slide.date" class="event-item__date">
            <div>{{ slide.date }}</div>
            <div v-if="slide.place">
              <a :href="slide.placeUrl">{{ slide.place }}</a>
            </div>
          </div>
          <div v-if="slide.tags" class="event-item__tags">
            <div v-for="(tag, i) in slide.tags" :key="i" class="event-item__tags-item">
              {{ tag }}
            </div>
          </div>
          <div class="event-item__name">
            {{ slide.name }}
          </div>
          <div class="event-item__descr">
            {{ slide.descr }}
          </div>
          <div class="event-item__bottom">
            <div class="event-item__bottom-left">
              <div v-if="slide.oldPice" class="event-item__price event-item__price--old">
                {{ slide.oldPice }}
              </div>
              <div class="event-item__price">{{ slide.price ? slide.price : 'БЕСПЛАТНО' }}</div>
              <div v-if="slide.price" class="event-item__price event-item__price--unit">₽</div>
            </div>
            <div class="event-item__link">
              <a href="#">
                <span>Смотреть</span>
                <svg
                  width="18"
                  height="13"
                  viewBox="0 0 18 13"
                  fill="none"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    d="M17.7015 5.79768C17.8926 5.98078 18 6.22909 18 6.488C18 6.74691 17.8926 6.99522 17.7015 7.17833L11.9346 12.7019C11.8405 12.7952 11.728 12.8696 11.6037 12.9207C11.4793 12.9719 11.3455 12.9988 11.2101 13C11.0748 13.0011 10.9406 12.9764 10.8153 12.9273C10.69 12.8782 10.5762 12.8057 10.4804 12.714C10.3847 12.6223 10.309 12.5133 10.2578 12.3933C10.2065 12.2733 10.1807 12.1447 10.1819 12.0151C10.1831 11.8855 10.2112 11.7573 10.2646 11.6382C10.318 11.5191 10.3957 11.4113 10.4931 11.3213L14.5199 7.46442L1.01944 7.46442C0.749067 7.46442 0.489767 7.36155 0.298586 7.17843C0.107405 6.99532 0 6.74696 0 6.488C0 6.22904 0.107405 5.98069 0.298586 5.79757C0.489767 5.61446 0.749067 5.51159 1.01944 5.51159L14.5199 5.51159L10.4931 1.65474C10.3074 1.47059 10.2046 1.22395 10.2069 0.967933C10.2093 0.71192 10.3165 0.467022 10.5055 0.285987C10.6945 0.104951 10.9502 0.00226212 11.2175 3.71933e-05C11.4848 -0.00218773 11.7423 0.0962296 11.9346 0.274092L17.7015 5.79768Z"
                    fill="#3AAA35"
                  />
                </svg>
              </a>
            </div>
          </div>
        </div>
      </div>
    </SwiperSlide>
    <SwiperControls />
  </Swiper>

  <Swiper
    v-else
    :class="class"
    :modules="modules"
    :loop="options.loop"
    :navigation="options.navigation"
    :slidesPerView="options.slidesPerView"
    :slidesPerGroup="options.slidesPerGroup"
    :centeredSlides="options.centeredSlides"
    :spaceBetween="options.spaceBetween"
    :pagination="options.pagination"
    :breakpoints="options.breakpoints"
    :effect="options.effect"
    :mousewheel="options.mousewheel"
    :autoHeight="options.autoHeight"
  >
    <SwiperSlide v-for="(slide, i) in slider" :key="i">
      <div v-if="typeSlider === 'feedback'" class="feedback-slide">
        <div class="feedback-slide__item">
          <div class="feedback-slide__photo">
            <img :src="slide.photo" :alt="slide.alt" loading="lazy" />
            <div v-if="slide.video" class="relative">
              <span class="video-icon video-icon--small"></span>
            </div>
          </div>
          <div class="feedback-slide__name t-32" v-if="slide.name">{{ slide.name }}</div>
        </div>
      </div>

      <div v-else-if="typeSlider === 'feedback-item'" class="feedback-item-slide">
        <div class="feedback-item-slide__wrap">
          <div class="feedback-item-slide__head">
            <div class="feedback-item-slide__photo">
              <img :src="slide.photo" :alt="slide.alt" />
            </div>
            <div class="feedback-item-slide__name t-18" v-if="slide.name">{{ slide.name }}</div>
          </div>
          <div class="feedback-item-slide__body">
            <div class="feedback-item-slide__text t-18" v-if="slide.text">{{ slide.text }}</div>
          </div>
          <div class="feedback-item-slide__footer">
            <NuxtLink :to="slide.url">Читать полностью</NuxtLink>
          </div>
        </div>

        <!-- <div class="feedback-slide__item">
          <div class="feedback-slide__photo">
            <img :src="slide.photo" :alt="slide.alt" loading="lazy" />
            <div v-if="slide.video" class="relative">
              <span class="video-icon video-icon--small"></span>
            </div>
          </div>
          <div class="feedback-slide__name t-32">{{ slide.name }}</div>
        </div> -->
      </div>

      <div v-else-if="typeSlider === 'experts'" class="expert-slide">
        <div class="expert-slide__photo">
          <img :src="slide.photo" :alt="slide.alt" loading="lazy" />
          <div v-if="slide.video" class="relative">
            <span class="video-icon video-icon--small"></span>
          </div>
        </div>
        <div class="expert-slide__info">
          <div class="expert-slide__iinfo-item">
            <div class="expert-slide__name t-24">{{ slide.name }}</div>
            <div class="expert-slide__position">{{ slide.position }}</div>
          </div>
          <div class="expert-slide__info-item">
            <UITheButton :label="'Задать вопрос'" class="btn-light" />
          </div>
        </div>
      </div>

      <div v-else class="slider__wrap">
        <div v-if="slide.head" class="slider__head">{{ slide.head }}</div>
        <div v-if="slide.img" class="slider__img">
          <img :src="slide.img" alt="" />
          <span class="video-icon"></span>
        </div>
        <div class="slider__name">{{ slide.name }}</div>
        <div v-if="slide.description" class="slider__description t-24">{{ slide.description }}</div>
      </div>
    </SwiperSlide>
    <SwiperControls />
  </Swiper>
</template>

<script>
import { Swiper, SwiperSlide } from 'swiper/vue';

import 'swiper/css';

import 'swiper/css/effect-coverflow';
import 'swiper/css/effect-fade';
import 'swiper/css/pagination';
import 'swiper/css/navigation';

import { Pagination, Navigation, Mousewheel, EffectCoverflow, EffectFade } from 'swiper/modules';
export default {
  components: {
    Swiper,
    SwiperSlide,
  },
  props: {
    slider: { type: Array, default: [], require: false },
    options: { type: Object, default: {}, require: false },
    typeSlider: { type: String, default: '', require: false },
  },

  setup() {
    return {
      modules: [Pagination, Navigation, Mousewheel, EffectCoverflow, EffectFade],
    };
  },

  methods: {
    modalVideoOpen(frameSrc) {
      this.$emit('modal-video-open', { src: frameSrc });
    },
  },
};
</script>

<style lang="scss">
.slider-swiper {
  .swiper-wrapper {
    padding-top: 100px;
    @media (max-width: 767px) {
      padding: 20px 0 60px;
    }
  }
  .swiper-button-prev,
  .swiper-button-next {
    display: block;
    width: 50px;
    height: 50px;
    background-color: rgb(var(--primary));
    border-radius: 5px;
    text-align: center;
    line-height: 50px;
    position: absolute;
    transition: 0.3s;
    top: 50px;
    @media (max-width: 767px) {
      top: auto;
      bottom: 0;
    }
    &:hover {
      @media (min-width: 1023px) {
        background: rgba(var(--primary), 0.5);
      }
    }
    &:active {
      background: rgba(var(--primary), 0.9);
    }
    &::after {
      content: '';
      background-image: url('@/assets/img/slider/arrow.svg');
      background-repeat: no-repeat;
      background-size: cover;
      background-position: center;
      z-index: 50;
      display: block;
      width: 8px;
      height: 14px;
      position: absolute;
      top: 50%;
      left: 50%;
    }
  }
  .swiper-button-prev {
    right: 60px;
    left: auto;
    &::after {
      transform: translate(-50%, -50%);
    }
  }
  .swiper-button-next {
    right: 0;
    &::after {
      transform: translate(-50%, -50%) rotate(180deg);
    }
  }
  .swiper-pagination {
    display: inline-block;
    width: auto;
    font-size: 30px;
  }
  .slider {
    &__img {
      border-radius: 10px;
      overflow: hidden;
      margin-bottom: 15px;
      position: relative;
      @media (max-width: 1023px) {
        max-height: 600px;
      }
      img {
        border-radius: 10px;
        width: 100%;
        height: 100%;
        object-fit: cover;
        // @media(max-width: 1023px) {
        //   object-fit: none;
        // }
      }
    }
    &__name {
      font-size: 32px;
      font-weight: 500;
      line-height: 110%;
    }
    &__description {
      margin-top: 15px;

      // font-size: 18px;
      // font-weight: 400;
      // line-height: 135%;
    }
  }

  &--events {
    @media screen and (min-width: 1024px) {
      margin-top: -74px;
      padding-top: 74px;
    }
    .swiper-wrapper {
      @media screen and (min-width: 1024px) {
        padding-top: 0;
      }

      @media screen and (max-width: 1023px) {
        padding-top: 65px;
      }
    }

    .swiper-button-prev,
    .swiper-button-next {
      top: 24px;
    }

    .swiper-button-prev {
      @media screen and (max-width: 1023px) {
        left: 0;
        right: auto;
      }
    }
    .swiper-button-next {
      @media screen and (max-width: 1023px) {
        left: 60px;
        right: auto;
      }
    }
  }
}
</style>
