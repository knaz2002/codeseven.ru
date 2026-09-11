<template>
  <div class="radio">
    <label class="radio__label">
      <input type="radio" :name="name" class="radio__input" />
      <span class="radio__checked"></span>
      <span v-if="label" class="radio__name">{{ label }}</span>
    </label>
  </div>
</template>

<script>
export default {
  props: {
    label: {
      type: String,
      default: "",
    },
    name: {
      type: String,
      default: "",
    },
  },
  mounted() {},
};
</script>

<style lang="scss">
.radio {
  position: relative;
  &__label {
    display: flex;
    align-items: center;
    cursor: pointer;
  }
  &__input {
    opacity: 0;
    appearance: none;
    position: absolute;
  }
  &__checked {
    display: block;
    width: 20px;
    height: 20px;
    flex: 0 0 20px;
    margin-right: 10px;
    border: solid 1px var(--border);
    border-radius: 50%;
    transition: 0.3s;
    position: relative;
    &::after {
      content: "";
      display: block;
      width: 12px;
      height: 12px;
      background-color: rgb(var(--primary));
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      border-radius: 50%;
      transition: 0.3s;
      opacity: 0;
    }
  }
  &__input:checked + &__checked {
    border-color: rgb(var(--dark));
    &::after {
      opacity: 1;
    }
  }
}
</style>
