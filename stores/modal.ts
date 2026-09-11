import { defineStore } from "pinia";

export const useModalStore = defineStore("modal", {
  state: () => ({
    activeModal: null as string | null,

    modalData: {
      about: {},
      development: {},
      designer: {},
      seo: {},
      it: {},
      analytics: {},
      outstaff: {},
      lidogen: {},
      call: {
        name: "",
        phone: "",
        email: "",
        message: "",
      },
    },

    validations: {
      call: {
        name: false,
        phone: false,
        email: false,
        message: false,
      },
    },

    /** Статус отправки формы обратной связи: null | 'success' | 'error' */
    callSubmitStatus: null as null | "success" | "error",
  }),

  getters: {
    isVisible: (state) => !!state.activeModal,

    isCallFormValid: (state) => {
      return Object.values(state.validations.call).every((v) => v === true);
    },

    currentModalData: (state) => {
      return (
        state.modalData[state.activeModal as keyof typeof state.modalData] || {}
      );
    },
  },

  actions: {
    syncBodyScrollLock() {
      if (import.meta.client) {
        document.body.style.overflow = this.activeModal ? "hidden" : "";
      }
    },

    openModal(modalName: string) {
      this.activeModal = modalName;
      this.syncBodyScrollLock();
    },

    closeModal() {
      this.activeModal = null;
      this.syncBodyScrollLock();
    },

    closeAndReset(modalName: string) {
      this.closeModal();
      this.resetModalData(modalName);
    },

    updateModalData(modalName: string, data: Partial<Record<string, any>>) {
      const key = modalName as keyof typeof this.modalData;
      const current = this.modalData[key];
      if (current && typeof current === "object") {
        Object.assign(current, data);
      }
    },

    updateValidation(modalName: string, fieldName: string, isValid: boolean) {
      if (modalName !== "call") return;
      const row = this.validations.call;
      if (!(fieldName in row)) return;
      row[fieldName as keyof typeof row] = isValid;
    },

    resetModalData(modalName: string) {
      if (modalName === "call") {
        this.modalData.call = {
          name: "",
          phone: "",
          email: "",
          message: "",
        };
        this.validations.call = {
          name: false,
          phone: false,
          email: false,
          message: false,
        };
        this.callSubmitStatus = null;
      }
    },

    async sendToTelegram() {
      const token = "8228558618:AAEjGUANdKstsPqr0WWtxlhAR6DPzqDNx9M";
      const chatId = "-5038920103";

      try {
        const response = await fetch(
          `https://api.telegram.org/bot${token}/sendMessage`,
          {
            method: "POST",
            headers: {
              "Content-Type": "application/json",
            },
            body: JSON.stringify({
              chat_id: chatId,
              text: `Новая заявка:\nИмя: ${this.modalData.call.name}\nТелефон: ${this.modalData.call.phone}\nEmail: ${this.modalData.call.email}\nСообщение: ${this.modalData.call.message}`,
            }),
          },
        );

        return response.ok;
      } catch (error) {
        // console.error("Ошибка при отправке в Telegram:", error);
        return false;
      }
    },

    async submitCallForm() {
      if (!this.isCallFormValid) {
        // console.warn("Форма не прошла валидацию");
        return false;
      }

      try {
        // console.log("Отправка формы:", this.modalData.call);
        // Отправляем в Telegram
        const success = await this.sendToTelegram();

        if (success) {
          this.callSubmitStatus = "success";
          return true;
        } else {
          this.callSubmitStatus = "error";
          return false;
        }
      } catch (error) {
        this.callSubmitStatus = "error";
        return false;
      }
    },
  },
});
