<template>
  <Transition name="modal-appear" :duration="{ enter: 350, leave: 0 }">
    <div
      v-if="modalStore.activeModal === 'development'"
      class="modal modal-development modal-service"
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
            <img src="/public/img/modal/develop.svg" alt="ico" />
          </div>
          <h2 class="modal-service__title tite">Разработка</h2>
          <div class="modal-service__subtitle">
            35 % от общего времени проекта
          </div>
        </div>
        <div class="modal-service__body">
          <div class="modal-service__desktop">
            <div class="modal-service__block">
              <span class="modal-service__tag"
                >Front-end разработка (Клиентская часть)
              </span>
              <p class="modal-service__text">
                Создание внешней части сайта, которую видит пользователь
                в браузере.
              </p>
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
              <span class="modal-service__tag"
                >Back-end разработка (Серверная часть)
              </span>
              <p class="modal-service__text">
                Настройка внутренней логики, которая скрыта от глаз
                пользователя.
              </p>
              <div class="modal-service__list">
                <ol>
                  <li v-for="(item, i) in listItemSecond" :key="i">
                    <p>{{ item.title }}</p>
                    <p>{{ item.text }}</p>
                  </li>
                </ol>
              </div>
            </div>
          </div>
          <div class="modal-service__mobile">
            <p class="modal-service__text">
              Создаём самые сложные системы: сайты, мобильные приложения,
              web-системы.
            </p>
          </div>
        </div>
        <div class="modal-service__footer">
          <button class="btn btn-dark" @click="openCallModal">
            Обсудить проект
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
    title: "Верстка",
    text: "Перенос дизайна из графических редакторов (Figma) в код HTML и CSS.",
  },
  {
    title: "Адаптивность",
    text: "Настройка корректного отображения на мобильных устройствах и планшетах.",
  },
  {
    title: "Интерактивность",
    text: "Программирование анимаций, кнопок и форм с помощью JavaScript.",
  },
];
const listItemSecond = [
  {
    title: "Серверная логика",
    text: "Написание кода на языках PHP, Python, Go или Node.js",
  },
  {
    title: "Базы данных",
    text: "Проектирование структуры хранения данных (пользователи, товары, заказы)",
  },
  {
    title: "Интеграции",
    text: "Подключение сторонних сервисов (платежные системы, CRM, службы доставки) через API.",
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

<style scoped>
.modal-development {
}
</style>
