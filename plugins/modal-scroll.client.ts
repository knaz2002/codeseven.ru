import { useModalStore } from "~/stores/modal";

export default defineNuxtPlugin((nuxtApp) => {
  const modalStore = useModalStore();

  nuxtApp.hook("page:start", () => {
    if (modalStore.activeModal) {
      modalStore.closeModal();
    } else {
      document.body.style.overflow = "";
    }
  });
});
