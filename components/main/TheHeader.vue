<template>
  <div class="header">
    <div class="header__container">
      <div class="header__list">
        <div class="header__logo">
          <NuxtLink to="/" @click="closeMenu">
            <TheSvg type="logo" />
          </NuxtLink>
        </div>
        <div class="header__menu">
          <div
            ref="trigger"
            class="header-menu-trigger"
            @mouseenter="onTriggerEnter"
            @mouseleave="onTriggerLeave"
          >
            <div
              ref="burger"
              class="header-burger"
              :class="{ active: isMenuOpen }"
              @click="toggleMenu"
            >
              <span></span>
              <span></span>
              <span></span>
            </div>
            <div
              class="header-burger-close"
              :class="{ active: isMenuOpen }"
              @click="closeMenu"
            >
              x
            </div>
            <nav ref="menu" class="header-menu" @click="handleMenuClick">
              <ul>
                <li>
                  <button
                    type="button"
                    class="menu-link"
                    @click="openAboutModal"
                    data-text="О нас"
                  >
                    О нас
                  </button>
                </li>
                <li>
                  <button
                    type="button"
                    class="menu-link"
                    @click="openCallModal"
                    data-text="Контакты"
                  >
                    Контакты
                  </button>
                </li>
                <li>
                  <button
                    type="button"
                    class="menu-link"
                    @click="goToServices"
                    data-text="Услуги"
                  >
                    Услуги
                  </button>
                </li>
                <li>
                  <button
                    type="button"
                    class="menu-link"
                    @click="goToPortfolio"
                    data-text="Портфолио"
                  >
                    Портфолио
                  </button>
                </li>
              </ul>
            </nav>
          </div>
        </div>
        <div class="header-switch">
          <div class="header-switch__wrap">
            <label class="header-switch__label">
              <input
                type="checkbox"
                class="header-switch__input"
                :checked="isDark"
                @change="toggleTheme"
              />
              <span class="header-switch__checked">
                <span class="header-switch__ico">
                  <span class="header-switch__ico-sun">
                    <svg
                      width="24"
                      height="24"
                      viewBox="0 0 24 24"
                      fill="none"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <path
                        d="M12 16.5833C9.47 16.5833 7.41667 14.53 7.41667 12C7.41667 9.47 9.47 7.41667 12 7.41667C14.53 7.41667 16.5833 9.47 16.5833 12C16.5833 14.53 14.53 16.5833 12 16.5833ZM12 9.25C10.4875 9.25 9.25 10.4875 9.25 12C9.25 13.5125 10.4875 14.75 12 14.75C13.5125 14.75 14.75 13.5125 14.75 12C14.75 10.4875 13.5125 9.25 12 9.25ZM12.9167 1H11.0833V5.58333H12.9167V1ZM12.9167 18.4167H11.0833V23H12.9167V18.4167ZM5.58333 11.0833H1V12.9167H5.58333V11.0833ZM23 11.0833H18.4167V12.9167H23V11.0833ZM20.4242 4.86833L19.1317 3.57583L15.8867 6.82083L17.1792 8.11333L20.4242 4.86833ZM8.11333 17.1883L6.82083 15.8958L3.57583 19.1408L4.86833 20.4333L8.1133 17.1883ZM8.11333 6.82083L4.86833 3.57583L3.57583 4.86833L6.82083 8.11333L8.11333 6.82083ZM20.4333 19.1408L17.1883 15.8958L15.8958 17.1883L19.1408 20.4333L20.4333 19.1408Z"
                        :fill="isDark ? '#ffffff' : '#141517'"
                      />
                    </svg>
                  </span>
                  <span class="header-switch__ico-moon">
                    <svg
                      width="24"
                      height="24"
                      viewBox="0 0 24 24"
                      fill="none"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <path
                        d="M13.9115 21C9.00327 21.0136 5.01344 16.9951 5.00003 12.0246C4.98662 7.05409 8.95461 3.01361 13.8629 3.00003C15.3803 2.99584 16.8735 3.38518 18.2003 4.13096L19.3505 4.77745L18.207 5.43745C14.8323 7.37794 13.6499 11.7215 15.566 15.1391C16.3038 16.4548 17.4364 17.4982 18.7995 18.1177L20 18.666L18.9135 19.416C17.4431 20.4448 15.6987 20.9972 13.9115 21ZM13.9115 4.49996C9.82128 4.49996 6.5055 7.85783 6.5055 12C6.5055 16.1421 9.82128 19.5 13.9115 19.5C14.9745 19.5001 16.0247 19.2652 16.9887 18.8115C13.0699 16.1911 11.9907 10.8498 14.5782 6.88122C15.0619 6.13928 15.6562 5.4777 16.3399 4.91999C15.5601 4.64042 14.7387 4.49833 13.9115 4.49996Z"
                        :fill="isDark ? '#ffffff' : '#141517'"
                      />
                    </svg>
                  </span>
                </span>
              </span>
            </label>
          </div>
        </div>
      </div>
    </div>
  </div>
  <ModalAbout />
  <ModalCall />
</template>

<script setup>
import { useModalStore } from "~/stores/modal";
import { ref, onMounted, onBeforeUnmount, watch } from "vue";
import { gsap } from "gsap";
import TheSvg from "~/components/TheSvg.vue";
import ModalAbout from "~/components/modal/modal-about.vue";
import ModalCall from "~/components/modal/modal-call.vue";

const isDark = ref(true);
const isMenuOpen = ref(false);
const isHoveringMenu = ref(false);
const mediaQuery = ref(null);
const hoverTimeout = ref(null);
const isMobileView = ref(false);

const trigger = ref(null);
const burger = ref(null);
const menu = ref(null);

// Методы для перехода к секциям
const goToServices = () => {
  closeMenu();
  // Вызываем событие для перехода к слайду с услугами (второй слайд)
  window.dispatchEvent(
    new CustomEvent("navigate-to-section", {
      detail: { sectionId: "main-slider" },
    }),
  );
};

const goToPortfolio = () => {
  closeMenu();
  // Вызываем событие для перехода к слайду с портфолио (последний слайд)
  window.dispatchEvent(
    new CustomEvent("navigate-to-section", {
      detail: { sectionId: "portfolio" },
    }),
  );
};

const openAboutModal = () => {
  closeMenu();
  const modalStore = useModalStore();
  modalStore.openModal("about");
};

const openCallModal = () => {
  closeMenu();
  const modalStore = useModalStore();
  modalStore.openModal("call");
};

const isDesktop = () => window.innerWidth >= 1024;

const checkDeviceType = () => {
  isMobileView.value = !isDesktop();
};

const onResize = () => {
  const wasMobile = isMobileView.value;
  checkDeviceType();

  if (wasMobile !== isMobileView.value) {
    isMenuOpen.value = false;
    isHoveringMenu.value = false;
    setInitialMenuPosition();
  }
};

const setInitialMenuPosition = () => {
  if (!menu.value || !burger.value) return;

  // Восстанавливаем бургер в начальное состояние
  gsap.set(burger.value, {
    opacity: 1,
    scale: 1,
    pointerEvents: "auto",
    visibility: "visible",
  });

  if (isDesktop()) {
    // Меню изначально скрыто слева от бургера
    gsap.set(menu.value, {
      x: 0, // сбрасываем любые предыдущие значения
      opacity: 0,
      pointerEvents: "none",
    });

    // После рендера устанавливаем начальное смещение
    requestAnimationFrame(() => {
      if (!menu.value || !burger.value) return;
      const menuWidth = menu.value.offsetWidth;
      gsap.set(menu.value, {
        x: -menuWidth, // скрываем меню слева от бургера
        opacity: 0,
        pointerEvents: "none",
      });
    });
  } else {
    // Для мобильной версии меню изначально скрыто внизу
    gsap.set(menu.value, {
      xPercent: 0,
      yPercent: 100,
      opacity: 0,
      pointerEvents: "none",
    });
  }
};

const animateMenuIn = () => {
  if (!menu.value || !burger.value) return;

  // Скрываем бургер при открытии меню
  gsap.to(burger.value, {
    opacity: 0,
    scale: 0.8,
    pointerEvents: "none",
    visibility: "hidden",
    duration: 0.3,
    ease: "power2.in",
  });

  if (isDesktop()) {
    // Меню появляется слева и движется вправо к бургеру
    gsap.to(menu.value, {
      x: 0,
      opacity: 1,
      pointerEvents: "auto",
      duration: 0.4,
      ease: "power2.out",
    });
  } else {
    // Для мобильной версии меню появляется сверху
    gsap.to(menu.value, {
      yPercent: 0,
      opacity: 1,
      pointerEvents: "auto",
      duration: 0.4,
      ease: "power2.out",
    });
  }
};

const animateMenuOut = () => {
  if (!menu.value || !burger.value) return;

  // Показываем бургер при закрытии меню
  gsap.to(burger.value, {
    opacity: 1,
    scale: 1,
    pointerEvents: "auto",
    visibility: "visible",
    duration: 0.3,
    ease: "power2.out",
  });

  if (isDesktop()) {
    // Меню уходит обратно влево
    requestAnimationFrame(() => {
      if (!menu.value) return;
      const menuWidth = menu.value.offsetWidth;
      gsap.to(menu.value, {
        x: -menuWidth,
        opacity: 0,
        pointerEvents: "none",
        duration: 0.3,
        ease: "power2.in",
      });
    });
  } else {
    // Для мобильной версии меню скрывается вниз
    gsap.to(menu.value, {
      yPercent: 100,
      opacity: 0,
      pointerEvents: "none",
      duration: 0.3,
      ease: "power2.in",
    });
  }
};

const closeMenu = () => {
  isMenuOpen.value = false;
  isHoveringMenu.value = false;
  animateMenuOut();
};

const toggleMenu = () => {
  if (isDesktop()) return;
  isMenuOpen.value = !isMenuOpen.value;
};

const onTriggerEnter = () => {
  if (!isDesktop()) return;
  if (hoverTimeout.value) {
    clearTimeout(hoverTimeout.value);
    hoverTimeout.value = null;
  }
  isHoveringMenu.value = true;
};

const onTriggerLeave = () => {
  if (!isDesktop()) return;
  hoverTimeout.value = setTimeout(() => {
    isHoveringMenu.value = false;
    hoverTimeout.value = null;
  }, 150);
};

const handleMenuClick = (event) => {
  const link =
    event.target.tagName === "A" ? event.target : event.target.closest("a");
  if (link) {
    closeMenu();
  }
};

const handleClickOutside = (event) => {
  if (isDesktop() || !isMenuOpen.value) return;
  if (trigger.value && !trigger.value.contains(event.target)) {
    closeMenu();
  }
};

const toggleTheme = () => {
  const newDark = !isDark.value;
  const { $theme } = useNuxtApp();
  $theme.set(newDark ? "dark" : "light");
  isDark.value = $theme.get() === "dark";
};

const handleSystemThemeChange = () => {
  if (!localStorage.getItem("theme")) {
    const { $theme } = useNuxtApp();
    isDark.value = $theme.get() === "dark";
  }
};

onMounted(() => {
  const { $theme } = useNuxtApp();
  isDark.value = $theme.get() === "dark";

  mediaQuery.value = window.matchMedia("(prefers-color-scheme: dark)");
  mediaQuery.value.addEventListener("change", handleSystemThemeChange);

  checkDeviceType();
  window.addEventListener("resize", onResize);

  setInitialMenuPosition();

  document.addEventListener("click", handleClickOutside);
  document.body.classList.add("hydrated");
});

onBeforeUnmount(() => {
  if (mediaQuery.value) {
    mediaQuery.value.removeEventListener("change", handleSystemThemeChange);
  }
  if (hoverTimeout.value) {
    clearTimeout(hoverTimeout.value);
  }
  document.removeEventListener("click", handleClickOutside);
  window.removeEventListener("resize", onResize);
  document.body.classList.remove("hydrated");
});

// Исправление: убедимся, что при ховере срабатывает анимация
watch(isHoveringMenu, (newVal) => {
  if (isDesktop()) {
    if (newVal) {
      animateMenuIn();
    } else {
      animateMenuOut();
    }
  }
});

watch(isMenuOpen, (newVal) => {
  if (!isDesktop()) {
    if (newVal) {
      animateMenuIn();
    } else {
      animateMenuOut();
    }
  }
});
</script>

<style lang="scss" scoped>
.header {
  position: fixed;
  width: 100%;
  left: 0;
  right: 0;
  z-index: 10;
  background-color: transparent;
  backdrop-filter: blur(10px);
  border-bottom: 1px solid rgba(255, 255, 255, 0.1);
  &__container {
    padding-top: 1rem;
    padding-bottom: 1rem;
    max-width: 1400px;
    margin: 0 auto;
  }

  &__logo {
    a {
      display: block;
    }
  }

  &__list {
    display: grid;
    grid-template-columns: auto 1fr auto;
    align-items: center;
    gap: 1rem;
  }

  &__menu {
    display: flex;
    align-items: center;
    position: relative;
  }
}

.header-menu-trigger {
  position: relative;
  display: flex;
  align-items: center;
  height: 3rem;
}

.header-burger {
  position: relative;
  width: 2rem;
  height: 1.5rem;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  padding: 0.1em 0;

  span {
    width: 100%;
    height: 0.04em;
    background-color: var(--grafit);
    display: block;
    transition: all 0.3s ease;
  }
}

.header-burger-close {
  position: fixed;
  right: 2rem;
  top: 2rem;
  font-size: 5vw;
  z-index: 9999;
  color: var(--light);
  opacity: 0;
  pointer-events: none;
  transition: ease 0.3s;
  cursor: pointer;
  &.active {
    opacity: 1;
    pointer-events: all;
  }
}

// .header-menu {
//   position: absolute;
//   top: 50%;
//   bottom: 0px;
//   left: 0; // теперь меню появляется слева от бургера
//   background-color: var(--background);
//   padding: 0 2rem;
//   z-index: 1000;
//   white-space: nowrap;
//   display: flex;
//   align-items: center;
//   justify-content: flex-start;
//   will-change: transform, opacity;
//   /* Скрыто до гидратации, чтобы не показывалось при загрузке */
//   opacity: 0;
//   pointer-events: none;
//   // Удаляем transform: translateX(-100%) - теперь управляем через GSAP

//   ul {
//     display: flex;
//     flex-direction: row;
//     gap: 1.5rem;
//     list-style: none;
//     margin: 0;
//     padding: 1rem 0;

//     li {
//       a,
//       button {
//         font-size: 1.4rem;
//         text-decoration: none;
//         color: var(--text);
//         position: relative;
//         display: inline-block;
//         padding: 0.2rem 0;
//         overflow: hidden;
//         transition: ease 0.3s;
//         &:hover {
//           @media (any-hover: hover) {
//             color: rgb(var(--primary));
//           }
//         }
//       }
//     }
//   }
// }
.header-menu {
  position: absolute;
  top: 50%; // выравниваем по вертикали по центру триггера
  transform: translateY(-50%); // компенсируем половину высоты меню
  left: 0;
  background-color: var(--background);
  padding: 0 2rem;
  z-index: 1000;
  white-space: nowrap;
  display: flex;
  align-items: center;
  justify-content: flex-start;
  will-change: transform, opacity;
  opacity: 0;
  pointer-events: none;

  ul {
    display: flex;
    flex-direction: row;
    gap: 1.5rem;
    list-style: none;
    margin: 0;
    padding: 0;

    li {
      a,
      button {
        font-size: 1.4rem;
        text-decoration: none;
        color: var(--text);
        position: relative;
        display: inline-block;
        padding: 0.2rem 0;
        overflow: hidden;
        transition: ease 0.3s;
        &:hover {
          @media (any-hover: hover) {
            color: rgb(var(--primary));
          }
        }
      }
    }
  }
}

@media (max-width: 1023px) {
  .header-menu {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100vh;
    background-color: var(--text);
    padding: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    // Убираем transform: translateY(100%) - теперь GSAP управляет этим
    // transform: translateY(100%); // УДАЛЕННО

    ul {
      flex-direction: column;
      gap: 2rem;
      padding: 0;

      li {
        a,
        button {
          font-size: 2.2rem;
          color: var(--light);
        }
      }
    }
  }

  .header-burger {
    z-index: 1001;
  }

  .header-menu-trigger {
    height: auto;
  }
}

.header-switch {
  display: none;

  &__label {
    display: flex;
    align-items: center;
    flex-direction: column;
    gap: 8px;
    cursor: pointer;
    position: relative;
  }

  &__name {
    font-size: 1rem;
    color: var(--text);
    user-select: none;
  }

  &__input {
    opacity: 0;
    position: absolute;
    width: 0;
    height: 0;
  }

  &__checked {
    display: flex;
    align-items: center;
    justify-content: flex-start;
    border-radius: 5rem;
    height: 2.4rem;
    width: 5rem;
    border: solid 1px var(--text);
    background-color: transparent;
    position: relative;
    transition: all 0.3s ease;

    &:after {
      content: "";
      width: 1.8rem;
      height: 1.8rem;
      border-radius: 50%;
      background-color: var(--light);
      border: solid 1px var(--text);
      position: absolute;
      left: 0.2rem;
      top: 50%;
      transform: translateY(-50%);
      transition: all 0.3s ease;
      z-index: -1;
    }
  }

  &__input:checked + &__checked {
    &:after {
      left: calc(100% - 2rem);
    }
  }
  &__ico {
    span {
      position: absolute;
      max-width: 1.4rem;
      top: 50%;
      transform: translateY(-50%);
    }
    svg {
      display: block;
      width: 100%;
      height: 100%;
    }
  }
  &__ico-sun {
    left: 0.4rem;
  }
  &__ico-moon {
    right: 0.4rem;
  }
}
</style>
