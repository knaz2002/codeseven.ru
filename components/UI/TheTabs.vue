<template>
  <div class="tabs">
    <ol class="tabs__header">
      <li
        v-for="(tab, i) in tabs"
        :key="i"
        class="tab"
        :class="{ active: tab.value == activeTab }"
        @click="activeTab = tab.value"
      >
        {{ tab.title }}
        <span class="tab-arrow">
          <TheSvg :type="'arrow'" />
        </span>
      </li>
    </ol>
    <div class="tabs__content">
      <slot name="content" :active="activeTab" />
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
const props = defineProps({
  tabs: { type: Array, default: [], require: true },
});
const activeTab = ref(props.tabs[0].value);
</script>

<style lang="scss">
.tabs {
  &__header {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    .tab {
      margin-right: 10px;
      margin-bottom: 10px;
      border: solid 1px var(--border);
      font-size: 16px;
      background-color: #fff;
      padding: 15px 25px;
      border-radius: 30px;
      cursor: pointer;
      transition: 0.3s;
      &:hover {
        @media (min-width: 1023px) {
          background: rgba(var(--primary), 0.2);
          border: solid 1px rgb(var(--primary));
        }
      }
      &.active {
        background-color: rgb(var(--primary));
        border: solid 1px rgb(var(--primary));
        color: rgb(var(--light));
      }
    }
  }
  &__content {
    margin-top: 25px;
  }
}
</style>
