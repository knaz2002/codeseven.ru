<template>
  <footer class="it-outsourcing-footer">
    <div class="it-outsourcing-footer__container container">
      <div class="it-outsourcing-footer__layout">
        <div class="it-outsourcing-footer__brand">
          <a class="it-outsourcing-footer__logo" href="/" aria-label="Code7 — на главную">
            <img
              src="/img/logo-text-light.svg"
              alt="Логотип Code7 в подвале страницы"
            />
          </a>

          <p class="it-outsourcing-footer__copy">
            © КОДСЕВЕН {{ year }}.<br>
            <a href="/OPD.pdf" target="_blank">Обработка персональных данных</a>
          </p>
        </div>

        <aside class="it-outsourcing-footer-contacts" aria-label="Контакты">
          <div class="it-outsourcing-footer-contacts__head">
            <p class="it-outsourcing-footer-contacts__label">Контакты</p>
            <div class="it-outsourcing-footer-contacts__person">
              <div class="it-outsourcing-footer-contacts__person-body">
                <p class="it-outsourcing-footer-contacts__name">Константин</p>
                <p class="it-outsourcing-footer-contacts__company">CEO Code7</p>
              </div>
              <img
                class="it-outsourcing-footer-contacts__avatar"
                src="/img/outsourcing/person.png"
                alt="Заглушка вместо фото менеджера в блоке контактов"
                width="48"
                height="48"
              />
            </div>
          </div>

          <p class="it-outsourcing-footer-contacts__phone">
            <a href="tel:+79090058585">+7 (909) 005-85-85</a>
          </p>
          <p class="it-outsourcing-footer-contacts__email">
            <a href="mailto:info@codeseven.ru">info@codeseven.ru</a>
          </p>
          <button
            type="button"
            class="it-outsourcing-footer-contacts__telegram"
            @click="openCallModal"
          >
            Оставить заявку
          </button>
        </aside>
      </div>
    </div>
  </footer>
</template>

<script setup lang="ts">
import { useModalStore } from "~/stores/modal";

const year = new Date().getFullYear();
const modalStore = useModalStore();

const openCallModal = () => {
  modalStore.openModal("call");
};
</script>
