<template>
  <Transition name="modal-appear" :duration="{ enter: 350, leave: 0 }">
    <div
      v-if="modalStore.activeModal === 'analytics'"
      class="modal modal-analytics modal-service"
    >
      <div class="modal__overlay" @click="closeModal"></div>
      <div class="modal__wrap" data-simplebar>
      <div class="modal__content modal-service__content">
        <button
          class="modal__close"
          @click="closeModal"
          aria-label="Закрыть"
        ></button>
        <div class="modal-service__head">
          <div class="modal-service__ico ico-anim">
            <img src="/public/img/modal/analytics.svg" alt="ico" />
          </div>
          <h2 class="modal-service__title tite">Аналитика</h2>
          <div class="subtitle">15 % от общего времени проекта</div>
        </div>
        <div class="modal-service__body">
          <div class="modal-service__desktop">
            <div class="modal-service__block">
              <span class="modal-service__tag">Аналитика предпроектная</span>
              <div class="modal-service__list">
                <ol>
                  <li v-for="(item, i) in listItemFirst" :key="i">
                    <p>{{ item.title }}</p>
                    <p>{{ item.text }}</p>
                  </li>
                </ol>
              </div>
            </div>
            <div class="modal-service__block">
              <span class="modal-service__tag">Почему аналитика важна?</span>
              <div
                class="modal-service__list-check"
                v-for="(item, i) in listItemSecond"
                :key="i"
              >
                <p><TheSvg type="check" /> {{ item.title }}</p>
                <p>{{ item.text }}</p>
              </div>
            </div>
          </div>
          <div class="modal-service__mobile">
            <p class="modal-service__text">
              Вникаем в ваши бизнес-процессы и предметную область.
            </p>
          </div>
        </div>
        <div class="modal-service__footer">
          <button class="btn btn-dark" @click="openCallModal">
            Узнать больше
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
</template>

<script setup>
import { useModalStore } from "~/stores/modal";
import TheSvg from "../TheSvg.vue";

const modalStore = useModalStore();

const listItemFirst = [
  {
    title: "Цель: ",
    text: "Понять бизнес-процессы, задачи и ожидания заказчика, определить потенциал идеи, изучить целевую аудиторию и конкурентов.",
  },
  {
    title: "Действия: ",
    text: "Интервью со стейкхолдерами, опросы пользователей, анализ рынка (TAM-SAM-SOM), бенчмаркинг, CustDev.",
  },
  {
    title: "Результат: ",
    text: "Формирование требований, карты ролей, прототипы, техническое задание (ТЗ). ",
  },
];
const listItemSecond = [
  {
    title: "Основа для принятия решений:",
    text: "Помогает перевести абстрактные идеи в конкретные шаги, опираясь на данные.",
  },
  {
    title: "Оптимизация: ",
    text: "Улучшает юзабилити, содержание и структуру сайта.",
  },
  {
    title: "Рост эффективности: ",
    text: "Повышает конверсию и окупаемость вложений в маркетинг.",
  },
  {
    title: "Синхронизация:",
    text: "Обеспечивает единое видение проекта у заказчика и команды.",
  },
];
const closeModal = () => {
  modalStore.closeModal();
};

const openCallModal = () => {
  modalStore.closeModal();
  modalStore.openModal("call");
};
</script>
