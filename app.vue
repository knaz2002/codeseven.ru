<template>
  <NuxtLayout :name="layout">
    <NuxtPage />
    <BG />
  </NuxtLayout>
</template>

<script setup lang="ts">
import BG from "~/components/TheBG.vue";
const layout = "default";
</script>

<style lang="scss"></style>
