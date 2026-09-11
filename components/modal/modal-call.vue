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
              {{ submitStatus === 'success' ? 'Сообщение отправлено' : 'Обратная связь' }}
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

const isFormValid = computed(() => modalStore.isCallFormValid);

const submitStatus = computed(() => modalStore.callSubmitStatus);

const isSubmitting = ref(false);

const closeModal = () => {
  modalStore.closeModal();
};

const updateValidation = (field, isValid) => {
  modalStore.updateValidation("call", field, isValid);
};

const submitForm = async () => {
  isSubmitting.value = true;
  await modalStore.submitCallForm();
  isSubmitting.value = false;
};

watch(isModalVisible, (newVal) => {
  if (!newVal) {
    modalStore.resetModalData("call");
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
</style>
