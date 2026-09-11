<template>
  <Transition name="modal-appear" :duration="{ enter: 350, leave: 0 }">
    <div
      v-if="modalStore.activeModal === 'seo'"
      class="modal modal-seo modal-service"
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
            <img src="/public/img/modal/seo.svg" alt="ico" />
          </div>
          <h2 class="modal-service__title tite">SEO-продвижение</h2>
        </div>
        <div class="modal-service__body">
          <div class="modal-service__desktop">
            <div class="modal-service__block">
              <span class="modal-service__tag">Как будем работать? </span>
              <div class="modal-service__list">
                <ol>
                  <li v-for="(item, i) in listItem" :key="i">
                    <p>{{ item.title }}</p>
                    <p>{{ item.text }}</p>
                  </li>
                </ol>
              </div>
            </div>
          </div>
          <div class="modal-service__mobile">
            <p class="modal-service__text">
              Повышаем позиции сайта в Яндексе, улучшаем видимость и привлекаем
              бесплатный трафик.
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
    title: "Анализ и аудит",
    text: "Изучаем сайт, его техническое состояние и позиции конкурентов.",
  },
  {
    title: "Сбор семантики и аналитика",
    text: "Формируем ядро запросов и подключаем системы отслеживания эффективности.",
  },
  {
    title: "Техническая оптимизация",
    text: "Исправляем ошибки, улучшаем загрузку, адаптацию и безопасность сайта.",
  },
  {
    title: "Контент и мета-теги",
    text: "Разрабатываем и внедряем SEO-тексты, заголовки и описания для страниц.",
  },
  {
    title: "Ссылочная стратегия",
    text: "Создаём безопасный и естественный профиль внешних ссылок для вашего сайта.",
  },
  {
    title: "Мониторинг и улучшения",
    text: "Постоянно отслеживаем результаты и корректируем стратегию продвижения.",
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
