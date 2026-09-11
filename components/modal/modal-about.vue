<template>
  <Teleport to="body">
    <Transition name="modal-appear" :duration="{ enter: 350, leave: 0 }">
      <div
        v-if="isModalVisible"
        class="modal modal-about modal-service"
        @click.self="closeModal"
      >
        <div class="modal__overlay" @click="closeModal"></div>
        <div class="modal__wrap" data-simplebar>
          <div class="modal__content modal-service__content">
            <button
              class="modal__close"
              @click="closeModal"
              aria-label="Закрыть модальное окно"
            ></button>

            <div class="modal-service__head">
              <div class="modal-service__ico ico-anim">
                <img src="/img/logo.svg" alt="Code7" />
              </div>
              <h2 class="modal-service__title tite">
                Code7 — IT-решения для бизнеса
              </h2>
              <div class="modal-service__subtitle">
                IT-компания из Екатеринбурга
              </div>
            </div>

            <div class="modal-service__body">
              <div class="modal-service__desktop">
                <div class="modal-service__block">
                  <span class="modal-service__tag">О компании</span>
                  <p class="modal-service__text">
                    Мы создаём сайты и цифровые сервисы. У нас обширный стек
                    технологий и специалисты разного профиля, поэтому мы берём
                    на себя весь цикл разработки — от идеи до запуска.
                  </p>
                </div>

                <div class="modal-service__block">
                  <span class="modal-service__tag">В цифрах</span>
                  <div class="modal-service-card modal-about__stats">
                    <div
                      v-for="(card, i) in cards"
                      :key="i"
                      class="modal-service-card__item"
                    >
                      <div
                        class="modal-about__stat-numb"
                        v-html="card.numb"
                      ></div>
                      <div class="modal-service-card__text">{{ card.text }}</div>
                    </div>
                  </div>
                </div>

                <div class="modal-service__block">
                  <span class="modal-service__tag">Наша миссия</span>
                  <div
                    v-for="(item, i) in missionItems"
                    :key="i"
                    class="modal-service__list-check"
                  >
                    <p><TheSvg type="check" /> {{ item.title }}</p>
                    <p>{{ item.text }}</p>
                  </div>
                </div>
              </div>

              <div class="modal-service__mobile">
                <p class="modal-service__text">
                  IT-компания из Екатеринбурга. Создаём сайты и цифровые
                  сервисы, берём на себя весь цикл разработки — от идеи до
                  запуска.
                </p>
              </div>
            </div>

            <div class="modal-service__footer">
              <button class="btn btn-dark" @click="openCallModal">
                Связаться с нами
                <TheSvg type="arrow-r" />
              </button>
              <span class="modal-service__logo modal-service__desktop">
                <TheSvg type="logo" />
              </span>
            </div>
          </div>
        </div>
      </div>
    </Transition>
  </Teleport>
</template>

<script setup>
import { useModalStore } from "~/stores/modal";
import TheSvg from "../TheSvg.vue";

const modalStore = useModalStore();

const cards = [
  {
    numb: "7<span>+</span>",
    text: "Направлений работы",
  },
  {
    numb: "17<span>+</span>",
    text: "Лет опыта в IT",
  },
  {
    numb: "250<span>+</span>",
    text: "Завершённых проектов",
  },
  {
    numb: "24<span>/</span>7",
    text: "Всегда на связи",
  },
];

const missionItems = [
  {
    title: "Рост бизнеса:",
    text: "Создавать цифровые продукты, которые помогают бизнесам расти и трансформироваться.",
  },
  {
    title: "Доступные технологии:",
    text: "Упрощать сложное, делая технологии доступными и эффективными для каждого клиента.",
  },
];

const isModalVisible = computed(() => modalStore.activeModal === "about");

const closeModal = () => {
  modalStore.closeModal();
};

const openCallModal = () => {
  modalStore.closeModal();
  modalStore.openModal("call");
};
</script>
