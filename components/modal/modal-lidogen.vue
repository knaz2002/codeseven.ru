<template>
  <Transition name="modal-appear" :duration="{ enter: 350, leave: 0 }">
    <div
      v-if="modalStore.activeModal === 'lidogen'"
      class="modal modal-lidogen modal-service"
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
              <img src="/public/img/modal/lidogen.svg" alt="ico" />
            </div>
            <h2 class="modal-service__title tite">Сервис лидогенерации</h2>
          </div>
          <div class="modal-service__body">
            <div class="modal-service__desktop">
              <div class="modal-service__block">
                <div class="modal-lidogen__info">
                  <p>Мы предлагаем Платформу для автоматизации (SaaS)</p>
                  <p>
                    Это инструменты для самостоятельной работы вашего отдела
                    продаж или маркетинга:
                  </p>
                </div>
              </div>
              <div class="modal-service__block">
                <div class="modal-service-card">
                  <div
                    class="modal-service-card__item"
                    v-for="(item, i) in cardInfo"
                    :key="i"
                  >
                    <div class="modal-service-card__head">
                      <div class="modal-service-card__title">
                        {{ item.title }}
                      </div>
                      <div
                        class="modal-service-card__dote"
                        :class="'modal-service-card__dote--' + (i + 1)"
                      >
                        <span></span>
                        <span></span>
                        <span></span>
                      </div>
                    </div>
                    <div class="modal-service-card__body">
                      <div class="modal-service-card__text">
                        {{ item.text }}
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="modal-service__block">
                <div class="modal-lidogen__attention">
                  Скоро запуск! Не пропусти!
                </div>
              </div>
            </div>
            <div class="modal-service__mobile">
              <p class="modal-service__text">
                Подбираем целевых клиентов по ключевым запросам и передаём лиды
                по подписке в личный кабинет.
              </p>
            </div>
          </div>
          <div class="modal-service__footer">
            <button class="btn btn-dark" @click="openCallModal" disabled>
              Скоро запуск
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

const cardInfo = [
  {
    title: "Парсеры и базы данных: ",
    text: "Сервисы для сбора контактов из открытых источников (Telegramm, Avito, VK).",
  },
  {
    title: "Email-рассыльщики и чат-боты: ",
    text: "Автоматизируют первое касание и квалификацию лида. ",
  },
  {
    title: "Конструкторы квизов и лендингов: ",
    text: "Помогают собирать заявки через вовлекающие формы.",
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
