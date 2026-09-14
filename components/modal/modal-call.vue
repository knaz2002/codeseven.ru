<template>
  <Teleport to="body">
    <Transition name="modal-appear" :duration="{ enter: 350, leave: 0 }">
      <div
        v-if="isModalVisible"
        class="modal modal-call"
        @click.self="closeModal"
      >
        <div class="modal__overlay" @click="closeModal"></div>
        <div class="modal__wrap" data-simplebar>
          <div class="modal__content">
            <button
              class="modal__close"
              @click="closeModal"
              aria-label="Закрыть модальное окно"
            ></button>
            <h2 class="modal__name title">
              {{ submitStatus === 'success' ? 'Сообщение отправлено' : 'Оставить заявку' }}
            </h2>
            <div class="modal__text">
              <!-- Успешная отправка: только сообщение и кнопка закрыть -->
              <div v-if="submitStatus === 'success'" class="modal-call-result">
                <p class="modal-call-result__message">
                  Спасибо! Ваше сообщение успешно отправлено. Мы свяжемся с вами в ближайшее время.
                </p>
                <button type="button" class="btn btn-dark" @click="closeModal">
                  Закрыть
                </button>
              </div>
              <!-- Форма: при ошибке показываем сообщение об ошибке над формой -->
              <template v-else>
                <div
                  v-if="submitStatus === 'error'"
                  class="modal-call-error"
                  role="alert"
                >
                  Не удалось отправить сообщение. Проверьте подключение к интернету и попробуйте ещё раз.
                </div>
                <form method="POST" action="" @submit.prevent="submitForm">
                  <div class="modal-call-form">
                    <div class="modal-call-form__inputs">
                      <InputField
                        v-model="formData.name"
                        type="text"
                        name="Имя"
                        @update:valid="updateValidation('name', $event)"
                      />
                      <InputField
                        v-model="formData.phone"
                        type="tel"
                        name="Телефон"
                        @update:valid="updateValidation('phone', $event)"
                      />
                      <InputField
                        v-model="formData.email"
                        type="email"
                        name="Email"
                        @update:valid="updateValidation('email', $event)"
                      />
                      <InputField
                        v-model="formData.message"
                        type="textarea"
                        name="Сообщение"
                        @update:valid="updateValidation('message', $event)"
                      />

                      <!--
                        Согласие на обработку персональных данных является
                        обязательным условием отправки формы. По умолчанию
                        чекбокс отмечен, но пользователь может снять отметку.
                        В этом случае кнопка отправки становится недоступной.
                      -->
                      <label class="modal-call-consent">
                        <input
                          v-model="consentAccepted"
                          type="checkbox"
                          required
                          class="modal-call-consent__input"
                        />
                        <span class="modal-call-consent__check" aria-hidden="true"></span>
                        <span class="modal-call-consent__text">
                          Соглашаюсь с
                          <a
                            href="https://codeseven.ru/opd.pdf"
                            target="_blank"
                            rel="noopener noreferrer"
                            @click.stop
                          >
                            политикой конфиденциальности и обработки персональных данных
                          </a>
                        </span>
                      </label>

                      <button
                        type="submit"
                        :disabled="!isFormValid || isSubmitting"
                        class="btn btn-dark"
                      >
                        {{ isSubmitting ? 'Отправка…' : 'Отправить' }}
                      </button>
                    </div>
                  </div>
                </form>
              </template>
            </div>
          </div>
        </div>
      </div>
    </Transition>
  </Teleport>
</template>

<script setup>
import { useModalStore } from "~/stores/modal";
import InputField from "~/components/UI/TheInput.vue";

const modalStore = useModalStore();

const isModalVisible = computed(() => modalStore.activeModal === "call");

const formData = computed({
  get() {
    return modalStore.modalData.call;
  },
  set(value) {
    modalStore.updateModalData("call", value);
  },
});

// Согласие на обработку персональных данных включено по умолчанию.
// Без активного согласия отправка формы запрещена.
const consentAccepted = ref(true);

const isFormValid = computed(
  () => modalStore.isCallFormValid && consentAccepted.value,
);

const submitStatus = computed(() => modalStore.callSubmitStatus);

const isSubmitting = ref(false);

const closeModal = () => {
  modalStore.closeModal();
};

const updateValidation = (field, isValid) => {
  modalStore.updateValidation("call", field, isValid);
};

const submitForm = async () => {
  // Даже если отправка будет вызвана программно, без обязательного
  // согласия данные пользователя не должны быть отправлены.
  if (!isFormValid.value) return;

  isSubmitting.value = true;
  await modalStore.submitCallForm();
  isSubmitting.value = false;
};

watch(isModalVisible, (newVal) => {
  if (!newVal) {
    modalStore.resetModalData("call");

    // При следующем открытии формы обязательное согласие снова
    // отображается отмеченным по умолчанию.
    consentAccepted.value = true;
  }
});
</script>

<style lang="scss" scoped>
.modal-call {
  .modal {
    &__wrap {
      padding: 0;
      max-width: 600px;
    }
    &__name {
      color: var(--color-text);
      margin-bottom: 3rem;

      @media (max-width: 767px) {
        font-size: 2rem;
        margin-bottom: 2rem;
      }
    }
  }
  .btn {
    width: 100%;
  }
}
.modal-call-form {
  &__inputs {
    .block-input,
    .block-textarea {
      margin-bottom: 2rem;
    }
  }
}
.modal-call-result {
  &__message {
    color: var(--color-text);
    margin-bottom: 2rem;
    line-height: 1.5;
  }
  .btn {
    width: 100%;
  }
}
.modal-call-error {
  padding: 1rem 1.25rem;
  margin-bottom: 1.5rem;
  background: rgba(200, 60, 60, 0.12);
  border: 1px solid rgba(200, 60, 60, 0.4);
  border-radius: 8px;
  color: #c0392b;
  font-size: 0.95rem;
  line-height: 1.4;
}

/*
 * Оформление обязательного согласия на обработку персональных данных.
 * Используется собственная визуальная галочка, чтобы она одинаково
 * выглядела в основных браузерах и соответствовала стилю проекта.
 */
.modal-call-consent {
  display: flex;
  align-items: flex-start;
  gap: 10px;
  margin-bottom: 1.5rem;
  cursor: pointer;
  line-height: 1.4;

  &__input {
    position: absolute;
    width: 1px;
    height: 1px;
    opacity: 0;
    pointer-events: none;
  }

  &__check {
    position: relative;
    width: 16px;
    height: 16px;
    flex: 0 0 16px;
    margin-top: 2px;
    border: 1px solid var(--border);
    border-radius: 3px;
    background-color: var(--bg);
    transition:
      background-color 0.2s ease,
      border-color 0.2s ease;

    &::after {
      content: "";
      position: absolute;
      left: 5px;
      top: 2px;
      width: 4px;
      height: 8px;
      border-right: 2px solid #fff;
      border-bottom: 2px solid #fff;
      transform: rotate(45deg);
      opacity: 0;
    }
  }

  &__input:checked + &__check {
    border-color: rgb(var(--primary));
    background-color: rgb(var(--primary));

    &::after {
      opacity: 1;
    }
  }

  &__input:focus-visible + &__check {
    outline: 2px solid rgba(var(--primary), 0.35);
    outline-offset: 2px;
  }

  &__text {
    color: var(--color-text);
    font-size: 1.2rem;

    a {
      color: inherit;
      text-decoration: underline;
      text-underline-offset: 2px;

      &:hover {
        opacity: 0.7;
      }
    }
  }
}



/*
 * Центрирование CTA-кнопок формы.
 * Сама ширина 170px задаётся глобальным стилем .btn.
 */
.modal-call .btn,
.modal-call-result .btn {
  margin-left: auto;
  margin-right: auto;
}

</style>
