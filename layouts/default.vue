<!-- layouts/default.vue -->
<template>
  <div class="page-wrap">
    <TheHeader />
    <main class="main"><slot /></main>
    <ModalHost />
    <!-- <TheFooter /> -->
    <!-- <BG /> -->
    <!-- Показываем FogBG ТОЛЬКО когда body.dark-mode -->
    <!-- <BG v-if="isDarkMode" /> -->
  </div>
</template>

<script setup lang="ts">
import TheHeader from "~/components/main/TheHeader.vue";
import TheFooter from "~/components/main/TheFooter.vue";
import BG from "~/components/TheBG.vue";
import ModalHost from "~/components/modal/ModalHost.vue";

// Реактивно отслеживаем класс dark-mode на body
const isDarkMode = ref(false);

// Функция обновления состояния
const updateDarkMode = () => {
  isDarkMode.value = document.body.classList.contains("dark-mode");
};

onMounted(() => {
  // Инициализируем состояние
  updateDarkMode();

  // Наблюдаем за изменениями класса body (работает с любым способом смены темы)
  const observer = new MutationObserver(updateDarkMode);
  observer.observe(document.body, {
    attributes: true,
    attributeFilter: ["class"],
  });

  // Очистка при размонтировании layout (на всякий случай)
  onBeforeUnmount(() => {
    observer.disconnect();
  });
});
</script>
