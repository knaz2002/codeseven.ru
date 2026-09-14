<template>
  <TheVerticalSlider
    ref="verticalSliderRef"
    :sections="sections"
    :allow-touch-move="allowSwiperTouch"
    @ready="restoreHomeSection"
  >
    <template #section-0>
      <section class="slide-content">
        <Glitch />
      </section>
    </template>

    <template #section-1>
      <section class="slide-content">
        <div class="swiper-no-swiping">
          <h2 class="title mt-5 name-block">Услуги</h2>
          <MainSlider ref="mainSliderRef" />
        </div>
      </section>
    </template>

    <template #section-2>
      <section class="slide-content" id="portfolio">
        <h2 class="title mt-5 name-block">Портфолио</h2>
        <div class="swiper-no-swiping">
          <PortfolioSphere :cards="portfolioCards" />
        </div>
      </section>
    </template>

    <template #section-3>
      <section class="slide-content">
        <h2 class="title mt-5 name-block">Наши партнеры</h2>
        <Partners />
      </section>
    </template>
  </TheVerticalSlider>
</template>

<script>
import MainSlider from "~/components/mainSlider/MainSlider.vue";
import Glitch from "~/components/TheGlitch.vue";
import TheVerticalSlider from "~/components/TheVerticalSlider.vue";
import PortfolioSphere from "~/components/PortfolioSphere.vue";
import Partners from "~/components/ThePartners.vue";

export default {
  name: "IndexPage",
  components: {
    MainSlider,
    Glitch,
    TheVerticalSlider,
    PortfolioSphere,
    Partners,
  },
  data() {
    return {
      allowSwiperTouch: true,
      sections: [
        { id: "glitch", title: "Glitch Section" },
        { id: "main-slider", title: "Main Slider Section" },
        { id: "portfolio", title: "Cards PortfolioSphere" },
        { id: "partners", title: "Partners Section" },
      ],
      portfolioCards: [
        {
          id: "project-1",
          img: "/img/portfolio/biz.webp",
          url: "https://www.biz-architects.ru/",
          desc: "BIZ-ARCHITECTS",
        },
        {
          id: "project-2",
          img: "/img/portfolio/home.webp",
          url: "https://xn--b1adekaljdr1bw.xn--p1ai/",
          desc: "Домики в лесу",
        },
        {
          id: "project-3",
          img: "/img/portfolio/darmina.webp",
          url: "https://xn--80aakrths.xn--p1ai/",
          desc: "Дармина",
        },
        {
          id: "project-4",
          img: "/img/portfolio/zetta.webp",
          url: "https://zetta.codeseven.ru/",
          desc: "ОСГОП такси",
        },
        {
          id: "project-5",
          img: "/img/portfolio/saturo.webp",
          url: "https://saturoterm.ru/",
          desc: "Saturo",
        },
        {
          id: "project-6",
          img: "/img/portfolio/batik.webp",
          url: "https://opt.batik.ru/",
          desc: "Batik",
        },
        {
          id: "project-7",
          img: "/img/portfolio/capital.webp",
          url: "https://osnova.capital",
          desc: "АГ Капитал",
        },
        {
          id: "project-8",
          img: "/img/portfolio/buhgalter.webp",
          url: "https://ya-buhgalter.osnova.capital/",
          desc: "Я Бухгалтер",
        },
      ],
    };
  },
  mounted() {
    window.addEventListener("carousel-drag-start", this.disableSwiperSwipe);
    window.addEventListener("carousel-drag-end", this.enableSwiperSwipe);
    window.addEventListener(
      "swiper-transition-end",
      this.handleSwiperTransitionEnd,
    );
    // Новый обработчик для навигации из хедера
    window.addEventListener(
      "navigate-to-section",
      this.handleNavigateToSection,
    );

    this.$nextTick(() => {
      if (
        this.$refs.mainSliderRef &&
        this.$refs.verticalSliderRef &&
        typeof this.$refs.verticalSliderRef.goToSlideById === "function"
      ) {
        this.$refs.mainSliderRef.setSliderController(
          this.$refs.verticalSliderRef.goToSlideById,
        );
      }
    });
  },
  beforeUnmount() {
    window.removeEventListener("carousel-drag-start", this.disableSwiperSwipe);
    window.removeEventListener("carousel-drag-end", this.enableSwiperSwipe);
    window.removeEventListener(
      "swiper-transition-end",
      this.handleSwiperTransitionEnd,
    );
    window.removeEventListener(
      "navigate-to-section",
      this.handleNavigateToSection,
    );
  },
  methods: {
    disableSwiperSwipe() {
      this.allowSwiperTouch = false;
    },
    enableSwiperSwipe() {
      this.allowSwiperTouch = true;
    },
    handleSwiperTransitionEnd() {
      if (
        this.$refs.mainSliderRef &&
        typeof this.$refs.mainSliderRef.scrollToPendingAnchor === "function"
      ) {
        this.$refs.mainSliderRef.scrollToPendingAnchor();
      }
    },
    // Новый метод для обработки навигации из хедера
    handleNavigateToSection(event) {
      const { sectionId } = event.detail;

      if (
        this.$refs.verticalSliderRef &&
        typeof this.$refs.verticalSliderRef.goToSlideById === "function"
      ) {
        this.$refs.verticalSliderRef.goToSlideById(sectionId);
      } else {
        // console.warn("[IndexPage] VerticalSlider не готов для навигации");
      }
    },
    restoreHomeSection() {
      const sectionId = sessionStorage.getItem("homeSection");
      if (!sectionId) return;

      sessionStorage.removeItem("homeSection");
      this.$refs.verticalSliderRef?.goToSlideById(sectionId);
    },
  },
};
</script>

<style lang="scss" scoped>
.slide-content {
  height: 100%;
  width: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
  box-sizing: border-box;
}
.swiper-no-swiping {
  width: 100%;
  height: 100%;
}
.name-block {
  position: absolute;
  left: 1.5rem;
  top: 1.5rem;
  right: 1.5rem;
  text-align: center;
  @media (max-width: 767px) {
    left: 50%;
    transform: translateX(-50%);
    width: 100%;
    text-align: center;
  }
}
</style>
