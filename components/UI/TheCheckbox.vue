<template>
  <label class="default-checkbox">
    <input v-model="isCheck" type="checkbox" class="default-checkbox__input" />
    <span class="default-checkbox__container"></span>
    <span v-if="!hiddenLabel" class="default-checkbox__text" v-html="label"></span>
  </label>
</template>

<script>
export default {
  props: {
    label: {
      type: String,
      default: '',
    },
    hiddenLabel: {
      type: Boolean,
      default: false,
    },
    size: {
      type: String,
      default: '',
    },
  },
  data() {
    return {
      isCheck: false,
    };
  },
  watch: {
    isCheck(val) {
      this.$emit('input', val);
    },
  },
};
</script>

<style lang="scss">
.default-checkbox {
  display: inline-flex;
  column-gap: 15px;
  cursor: pointer;
  &__input {
    display: none;
    &:checked ~ .default-checkbox__container {
      border-color: rgb(var(--primary));
      background-color: rgb(var(--primary));
      &::before {
        opacity: 1;
      }
    }
  }
  &__container {
    position: relative;
    display: inline-block;
    width: 15px;
    height: 15px;
    border: 1px solid var(--border);
    flex: 0 0 15px;
    transition: background-color 0.3s;
    &:before {
      content: '';
      position: absolute;
      display: block;
      top: 45%;
      left: 50%;
      width: 4px;
      height: 7px;
      border-right: solid 1px rgb(var(--light));
      border-bottom: solid 1px rgb(var(--light));
      transform: translate(-50%, -50%) rotate(45deg);
      opacity: 0;
    }
  }
}
</style>
