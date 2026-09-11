<template>
  <Teleport to="body">
    <ModalDevelopment />
    <ModalDesigner />
    <ModalSeo />
    <ModalIt />
    <ModalAnalytics />
    <ModalOutstaff />
    <ModalLidogen />
  </Teleport>
</template>

<script setup lang="ts">
import ModalDevelopment from "~/components/modal/modal-development.vue";
import ModalDesigner from "~/components/modal/modal-designer.vue";
import ModalSeo from "~/components/modal/modal-seo.vue";
import ModalIt from "~/components/modal/modal-it.vue";
import ModalAnalytics from "~/components/modal/modal-analytics.vue";
import ModalOutstaff from "~/components/modal/modal-outstaff.vue";
import ModalLidogen from "~/components/modal/modal-lidogen.vue";
</script>
