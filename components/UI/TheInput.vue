<template>
  <div v-if="type === 'textarea'" class="block-textarea">
    <textarea
      :value="modelValue"
      @input="handleTextareaInput"
      @focus="isFocused = true"
      @blur="markAsTouched"
      :placeholder="placeholder || name"
      :class="{ invalid: !isValid && isTouched }"
    ></textarea>
    <span v-if="!isValid && isTouched" class="error-message">{{
      errorMessage
    }}</span>
  </div>
  <div
    v-else-if="type === 'tel'"
    class="block-input block-input--tel-masked"
    :class="{ invalid: !isValid && isTouched }"
  >
    <div class="block-input__mask">{{ maskedDisplay }}</div>
    <input
      ref="telInput"
      type="tel"
      inputmode="numeric"
      pattern="[0-9]*"
      :value="modelValue"
      @input="handleTelInput"
      @focus="isFocused = true"
      @blur="markAsTouched"
      :class="{ invalid: !isValid && isTouched }"
      autocomplete="tel"
    />
    <span
      v-if="name"
      class="block-input__label block-input__label--always-active"
    >
      {{ name }}
    </span>
    <span v-if="!isValid && isTouched" class="error-message">{{
      errorMessage
    }}</span>
  </div>
  <div v-else class="block-input" :class="{ invalid: !isValid && isTouched }">
    <label>
      <input
        :type="type"
        :value="modelValue"
        @input="handleInput"
        @focus="isFocused = true"
        @blur="markAsTouched"
        :class="{ invalid: !isValid && isTouched }"
      />
      <span
        v-if="name"
        class="block-input__label"
        :class="{ active: modelValue || isFocused }"
      >
        {{ name }}
      </span>
    </label>
    <span v-if="!isValid && isTouched" class="error-message">{{
      errorMessage
    }}</span>
  </div>
</template>

<script>
export default {
  name: "TheInput",
  props: {
    modelValue: {
      type: [String, Number],
      default: "",
    },
    type: {
      type: String,
      required: true,
      validator(value) {
        return ["text", "email", "tel", "textarea"].includes(value);
      },
    },
    name: {
      type: String,
      default: "",
    },
    placeholder: {
      type: String,
      default: "",
    },
  },
  emits: ["update:modelValue", "update:valid"],
  data() {
    return {
      isTouched: false,
      isFocused: false,
    };
  },
  computed: {
    // Формат для отображения: +7 (999) 999-99-99
    maskedDisplay() {
      const digits = String(this.modelValue).replace(/\D/g, "");
      let formatted = "+7 (___) ___-__-__";
      if (digits.length > 0) {
        formatted = "+7 (" + digits.substring(0, 3).padEnd(3, "_") + ") ";
        if (digits.length > 3) {
          formatted += digits.substring(3, 6).padEnd(3, "_") + "-";
          if (digits.length > 6) {
            formatted += digits.substring(6, 8).padEnd(2, "_") + "-";
            if (digits.length > 8) {
              formatted += digits.substring(8, 10).padEnd(2, "_");
            } else {
              formatted += "__";
            }
          } else {
            formatted += "__-__";
          }
        } else {
          formatted += "___-__-__";
        }
      }
      return formatted;
    },
    isValid() {
      const value = String(this.modelValue).trim();
      if (!value) return false;

      if (this.type === "email") {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(value);
      }

      if (this.type === "tel") {
        const digits = value.replace(/\D/g, "");
        if (digits.length !== 10) return false;
        if (/^(\d)\1{9}$/.test(digits)) return false;
        return true;
      }

      return value.length > 0;
    },
    errorMessage() {
      const value = String(this.modelValue).trim();
      if (!value) {
        return "Поле обязательно для заполнения";
      }

      if (this.type === "email") {
        return "Некорректный email";
      }

      if (this.type === "tel") {
        const digits = value.replace(/\D/g, "");
        if (digits.length < 10) return "Недостаточно цифр";
        if (digits.length > 10) return "Слишком много цифр";
        if (/^(\d)\1{9}$/.test(digits)) return "Некорректный номер";
        return "Некорректный телефон";
      }

      return "Поле заполнено некорректно";
    },
  },
  watch: {
    isValid(newVal) {
      this.$emit("update:valid", newVal);
    },
  },
  methods: {
    markAsTouched() {
      this.isTouched = true;
    },
    handleInput(e) {
      this.$emit("update:modelValue", e.target.value);
    },
    handleTextareaInput(e) {
      this.$emit("update:modelValue", e.target.value);
    },
    handleTelInput(e) {
      let raw = e.target.value;
      // Оставляем только цифры
      const digits = raw.replace(/\D/g, "").substring(0, 10);
      this.$emit("update:modelValue", digits);
      // Сбрасываем значение input, чтобы он оставался "чистым" (но это не обязательно)
      // Vue управляет значением через :value, так что всё ок
    },
  },
};
</script>

<style lang="scss" scoped>
.block-input,
.block-textarea {
  width: 100%;
  margin-bottom: 1rem;
  position: relative;
  background-color: var(--bg);

  &.invalid {
    border-color: var(--error);
  }
}

/*  Общие стили для всех .block-input  */
.block-input {
  position: relative;
  border: 1px solid var(--border);
  border-radius: 6px;
  label {
  }
  input {
    width: 100%;
    padding: 1.5rem 2.5rem;
    height: 5rem;
    font-size: 1.4rem;
    border: none;
    outline: none;
    background: transparent;
    box-sizing: border-box;
    transition: all 0.2s ease;

    @media (max-width: 767px) {
      font-size: 1.2rem;
      padding: 1.2rem 1.8rem;
      height: 4rem;
    }
  }

  input.invalid {
    border-color: var(--error);
  }
}

/* Плавающий label для обычных инпутов (НЕ tel-masked) */
.block-input:not(.block-input--tel-masked) {
  .block-input__label {
    position: absolute;
    left: 2.5rem;
    top: 50%;
    transform: translateY(-50%);
    pointer-events: none;
    color: var(--color-text);
    font-size: 1.4rem;
    transition: all 0.2s ease;
    z-index: 1;

    &.active {
      top: 0rem;
      font-size: 1.2rem;
      color: var(--accent);
      transform: translateY(0);
    }
  }
}

/* стиль для телефона с маской */
.block-input--tel-masked {
  position: relative;
  border: 1px solid var(--border);
  border-radius: 6px;
  height: 5rem;
  padding: 2rem 2.5rem;
  .block-input__mask {
    position: absolute;
    left: 2.5rem;
    top: 70%;
    transform: translateY(-50%);
    font-size: 1.4rem;
    color: var(--color-text);
    pointer-events: none;
    z-index: 1;
  }

  input {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    padding: 1.4rem 2.5rem;
    font-size: 1.8rem;
    border: none;
    outline: none;
    background: transparent;
    opacity: 0; /* Невидимый, но кликабельный */
    caret-color: var(--accent);
    z-index: 2;
  }

  .block-input__label {
    position: absolute;
    left: 2.5rem;
    top: 0.5rem;
    font-size: 1.2rem;
    color: var(--accent);
    pointer-events: none;
    transition: none;
    z-index: 3;
  }
}

/* Textarea - с плейсхолдером вместо плавающего лейбла */
.block-textarea {
  textarea {
    width: 100%;
    padding: 1.4rem;
    font-size: 1.8rem;
    border: 1px solid var(--border);
    background-color: var(--bg);
    border-radius: 0.6rem;
    min-height: 10rem;
    outline: none;
    box-sizing: border-box;
    transition: all 0.2s ease;
    resize: none;

    &::placeholder {
      color: var(--color-text);
      opacity: 0.6;
    }

    &:focus::placeholder {
      opacity: 0.3;
    }
  }

  textarea.invalid {
    border-color: #e74c3c;
  }
}

.error-message {
  position: absolute;

  display: block;
  color: var(--error);

  left: 0;
  bottom: -1.4rem;
  font-size: 1.2rem;
  margin-top: 0rem;
  min-height: 1.6rem;
}
</style>
