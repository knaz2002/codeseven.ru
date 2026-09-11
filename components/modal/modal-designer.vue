<template>
  <Transition name="modal-appear" :duration="{ enter: 350, leave: 0 }">
    <div
      v-if="modalStore.activeModal === 'designer'"
      class="modal modal-designer modal-service"
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
            <img src="/public/img/modal/diz.svg" alt="ico" />
          </div>
          <h2 class="modal-service__title tite">Дизайн</h2>
          <div class="modal-service__subtitle">
            15 % от общего времени проекта
          </div>
        </div>
        <div class="modal-service__body">
          <div class="modal-service__desktop">
            <div class="modal-service__block">
              <div class="modal-service__list">
                <ol>
                  <li>
                    <p>Брифинг и исследование</p>
                    <p>
                      Понимание целей проекта, целевой аудитории, анализ
                      конкурентов.
                    </p>
                  </li>
                  <li>
                    <p>Проектирование (UX-дизайн)</p>
                    <p>
                      Создание логики, структуры, сценариев взаимодействия,
                      прототипов (wireframes) без цвета, но с расположением
                      элементов.
                    </p>
                  </li>
                  <li>
                    <p>Визуальное оформление (UI-дизайн)</p>
                    <p>
                      Разработка цветовой схемы, типографики, подбор
                      иллюстраций, создание детальных макетов страниц (главная,
                      внутренние).
                    </p>
                  </li>
                  <li>
                    <p>Адаптивный дизайн</p>
                    <p>
                      Проработка версий для разных устройств (десктоп, планшет,
                      смартфон).
                    </p>
                  </li>
                  <li>
                    <p>Согласование</p>
                    <p>Презентация макетов заказчику, внесение правок.</p>
                  </li>
                  <li>
                    <p>Подготовка к разработке</p>
                    <p>
                      Передача утвержденных макетов верстальщикам (HTML/CSS) и
                      программистам для реализации на CMS или фреймворке. 
                    </p>
                  </li>
                </ol>
              </div>
            </div>
          </div>
          <div class="modal-service__mobile">
            <ul class="modal-service__mobile-list">
              <li>Брифинг и исследование</li>
              <li>Проектирование (UX-дизайн)</li>
              <li>Визуальное оформление (UI-дизайн)</li>
              <li>Адаптивный дизайн</li>
              <li>Согласование</li>
              <li>Подготовка к разработке</li>
            </ul>
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
