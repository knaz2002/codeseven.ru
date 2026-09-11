<template>
  <Transition name="modal-appear" :duration="{ enter: 350, leave: 0 }">
    <div
      v-if="modalStore.activeModal === 'outstaff'"
      class="modal modal-outstaff modal-service"
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
              <img src="/public/img/modal/1c.svg" alt="ico" />
            </div>
            <h2 class="modal-service__title tite">1С outstaff</h2>
          </div>
          <div class="modal-service__body">
            <div class="modal-service__desktop">
              <div class="modal-service__block">
                <span class="modal-service__tag">Основные НАШИ роли</span>
                <div class="modal-service__list-ico modal-service-ico-block">
                  <div class="modal-service-ico-block__item">
                    <div class="modal-service-ico-block__ico">
                      <svg
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                      >
                        <path
                          d="M17 7.83008L18.6965 9.3569C20.239 10.7452 21.0103 11.4394 21.0103 12.3301C21.0103 13.2208 20.239 13.915 18.6965 15.3033L17 16.8301"
                          stroke="#414A4C"
                          stroke-width="1.5"
                          stroke-linecap="round"
                        />
                        <path
                          d="M13.9873 5L12.9939 8.70743M11.8437 13L10.0137 19.8297"
                          stroke="#414A4C"
                          stroke-width="1.5"
                          stroke-linecap="round"
                        />
                        <path
                          d="M6.99956 7.83008L5.30309 9.3569C3.76054 10.7452 2.98926 11.4394 2.98926 12.3301C2.98926 13.2208 3.76054 13.915 5.30309 15.3033L6.99956 16.8301"
                          stroke="#414A4C"
                          stroke-width="1.5"
                          stroke-linecap="round"
                        />
                      </svg>
                    </div>
                    <div class="modal-service-ico-block__info">
                      <p>Разработчики (Junior/Middle/Senior):</p>
                      <p>
                        Написание кода, доработка конфигураций, интеграции через
                        API.
                      </p>
                    </div>
                  </div>
                  <div class="modal-service-ico-block__item">
                    <div class="modal-service-ico-block__ico">
                      <svg
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                      >
                        <path
                          d="M18.2497 3.66699C18.2497 3.66699 19.9163 4.66699 19.9163 7.00033C19.9163 9.33366 18.2497 10.3337 18.2497 10.3337M16.583 5.33366C16.583 5.33366 17.4163 5.83366 17.4163 7.00033C17.4163 8.16699 16.583 8.66699 16.583 8.66699M17.4142 17.0003C17.4163 16.8635 17.4163 16.7245 17.4163 16.5837C17.4163 14.5126 14.4316 12.8337 10.7497 12.8337C7.06778 12.8337 4.08301 14.5126 4.08301 16.5837C4.08301 18.6547 4.08301 20.3337 10.7497 20.3337C12.6088 20.3337 13.9495 20.2031 14.9163 19.9698M14.083 7.00033C14.083 8.84127 12.5906 10.3337 10.7497 10.3337C8.90873 10.3337 7.41634 8.84127 7.41634 7.00033C7.41634 5.15938 8.90873 3.66699 10.7497 3.66699C12.5906 3.66699 14.083 5.15938 14.083 7.00033Z"
                          stroke="#414A4C"
                          stroke-width="1.5"
                          stroke-linecap="round"
                        />
                      </svg>
                    </div>
                    <div class="modal-service-ico-block__info">
                      <p>Консультанты: </p>
                      <p>
                        Интервью со стейкхолдерами, опросы пользователей, анализ
                        рынка (TAM-SAM-SOM), бенчмаркинг, CustDev.
                      </p>
                    </div>
                  </div>
                  <div class="modal-service-ico-block__item">
                    <div class="modal-service-ico-block__ico">
                      <svg
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                      >
                        <path
                          d="M3.41435 15.5315C3.15559 15.8549 3.20803 16.3269 3.53148 16.5857C3.85493 16.8444 4.32689 16.792 4.58565 16.4685L4 16L3.41435 15.5315ZM7.66863 11.4142L8.25428 11.8827V11.8827L7.66863 11.4142ZM9.93137 11.4142L10.517 10.9457V10.9457L9.93137 11.4142ZM12.4686 14.5858L11.883 15.0543V15.0543L12.4686 14.5858ZM14.7314 14.5858L15.317 15.0543V15.0543L14.7314 14.5858ZM20 8H20.75C20.75 7.58579 20.4142 7.25 20 7.25V8ZM19.25 13C19.25 13.4142 19.5858 13.75 20 13.75C20.4142 13.75 20.75 13.4142 20.75 13H20H19.25ZM16 7.25C15.5858 7.25 15.25 7.58579 15.25 8C15.25 8.41421 15.5858 8.75 16 8.75V8V7.25ZM4 16L4.58565 16.4685L8.25428 11.8827L7.66863 11.4142L7.08298 10.9457L3.41435 15.5315L4 16ZM9.93137 11.4142L9.34572 11.8827L11.883 15.0543L12.4686 14.5858L13.0543 14.1173L10.517 10.9457L9.93137 11.4142ZM14.7314 14.5858L15.317 15.0543L20.5857 8.46852L20 8L19.4143 7.53148L14.1457 14.1173L14.7314 14.5858ZM20 8H19.25V13H20H20.75V8H20ZM20 8V7.25H16V8V8.75H20V8ZM12.4686 14.5858L11.883 15.0543C12.3228 15.604 12.9398 15.9216 13.6 15.9216C14.2602 15.9216 14.8772 15.604 15.317 15.0543L14.7314 14.5858L14.1457 14.1173C13.9607 14.3486 13.7587 14.4216 13.6 14.4216C13.4413 14.4216 13.2393 14.3486 13.0543 14.1173L12.4686 14.5858ZM7.66863 11.4142L8.25428 11.8827C8.43933 11.6514 8.64128 11.5784 8.8 11.5784C8.95872 11.5784 9.16067 11.6514 9.34572 11.8827L9.93137 11.4142L10.517 10.9457C10.0772 10.396 9.46023 10.0784 8.8 10.0784C8.13977 10.0784 7.52277 10.396 7.08298 10.9457L7.66863 11.4142Z"
                          fill="#EEEEEE"
                        />
                      </svg>
                    </div>
                    <div class="modal-service-ico-block__info">
                      <p>Аналитики:</p>
                      <p>
                        Сбор требований, проектирование архитектуры, составление
                        ТЗ.
                      </p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="modal-service__block">
                <span class="modal-service__tag">Преимущества</span>
                <div
                  class="modal-service__list-check"
                  v-for="(item, i) in listItem"
                  :key="i"
                >
                  <p><TheSvg type="check" /> {{ item.title }}</p>
                  <p>{{ item.text }}</p>
                </div>
              </div>
              <div class="modal-service__block">
                <span class="modal-service__tag"
                  >Популярные форматы оплаты:</span
                >
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
            </div>
            <div class="modal-service__mobile">
              <p class="modal-service__text">
                Разрабатываем и адаптируем конфигурации 1С под задачи вашей
                компании, сопровождаем и консультируем.
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

const listItem = [
  {
    title: "Экономия на налогах и HR: ",
    text: "Вы не платите страховые взносы, отпускные и больничные; замена специалиста — наша забота.",
  },
  {
    title: "Оптимизация: ",
    text: "Улучшает юзабилити, содержание и структуру сайта.",
  },
  {
    title: "Экспертиза:",
    text: "Возможность привлечь узкого эксперта (например, по «1С: УТ 11» или маркировке товаров) только на нужный этап проекта.",
  },
  {
    title: "Управление ресурсами:",
    text: "Вы сами определяете приоритетность задач для привлеченного сотрудника.",
  },
];
const cardInfo = [
  {
    title: "Time & Materials",
    text: "Оплата за фактически отработанные часы",
  },
  {
    title: "Full-time:",
    text: "Фиксированная ставка за полный рабочий месяц специалиста ",
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
