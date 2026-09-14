<template>
  <div class="partners" id="partners">
    <Cards :cards="cardsPartners" wrapper-class="partners__cards-wrapper" />
  </div>
</template>

<script>
import Cards from "~/components/TheCards.vue";

export default {
  name: "ThePartners",
  components: {
    Cards,
  },
  data() {
    return {
      cardsPartners: [
        {
          id: 1,
          img: "/img/partners/selectel.svg",
          url: "https://selectel.ru/?ref_code=b8fa4d2dd8",
        },
        {
          id: 2,
          img: "/img/partners/tbank.svg",
          url: "https://www.tbank.ru/kassa/?utm_source=partners_sme&utm_medium=prt.utl&utm_campaign=business.int_acquiring.7-3S940JHQ8&partnerId=7-3S940JHQ8&agentId=5-2W3CJXCWZ&agentSsoId=f44ce3bf-1cb8-4710-a891-254cc2cb266c",
        },
        {
          id: 3,
          img: "/img/partners/timeweb.svg",
          url: "https://timeweb.cloud/?i=122675",
        },
        {
          id: 4,
          img: "/img/partners/zetta.png",
          url: "https://zt.codeseven.ru/",
        },
      ],
    };
  },
};
</script>

<style lang="scss">
.partners {
  width: 100%;
  padding: 4rem 0;

  &__cards-wrapper {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 3rem;
    align-items: center;
    justify-content: space-around;
    @media (max-width: 991px) {
      grid-template-columns: repeat(2, minmax(0, 1fr));
      gap: 2rem;
    }

    @media (max-width: 767px) {
      /*
       * На мобильных устройствах партнёры располагаются
       * по две карточки в строке. Четыре партнёра занимают
       * два компактных ряда вместо одной высокой колонки.
       */
      grid-template-columns: repeat(2, minmax(0, 1fr));
      max-width: 92%;
      gap: 1.5rem;
      justify-content: center;
      margin: 0 auto;
    }
    .card {
      min-height: auto !important;
      background-color: var(--bg);

      /*
       * Все логотипы партнёров центрируем внутри плашки независимо
       * от исходных пропорций SVG или PNG. Это особенно важно после
       * добавления Zetta: высота строки определяется самой высокой
       * карточкой, поэтому без flex короткие логотипы смещаются вверх.
       */
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 4rem 3rem;
      border-radius: var(--radius);
      overflow: hidden;
      @media (max-width: 767px) {
        /*
         * На мобильных устройствах все плашки партнёров имеют
         * одинаковую фиксированную высоту. Высота подобрана по
         * компактной плашке Т-Банка, чтобы Zetta с PNG-логотипом
         * больше не растягивала свою карточку.
         */
        height: 8.8rem !important;
        min-height: 8.8rem !important;
        max-height: 8.8rem !important;
        box-sizing: border-box;
        padding: 0 1.5rem;
      }
      &__item {
        box-shadow: none !important;
      }
      &__wrapper {
      }
      &__img {
        margin-bottom: 0;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;

        img {
          display: block;
          margin: 0 auto;
          object-fit: contain;
        }
      }
    }
  }
  &__title {
    position: absolute;
    top: 15px;
    left: 15px;
  }
  .cards {
  }
}
</style>
