export default defineNuxtPlugin(() => {
  useHead({
    htmlAttrs: { class: "dark-mode" },
    bodyAttrs: { class: "dark-mode" },
  });
});
