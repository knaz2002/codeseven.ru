<template>
  <div class="glitch">
    <div class="glitch__container">
      <h1 class="glitch__text">Code Seven</h1>
    </div>
  </div>
</template>

<script>
export default {
  name: "TheGlitch",
};
</script>

<style lang="scss" scoped>
.glitch {
  display: flex;
  justify-content: center;
  align-items: center;
  width: 100%;
  height: 100%;
  //background: var(--light);
  &__text {
    position: relative;
    font-size: 10vw;
    font-weight: 700;
    color: var(--text);
    padding: 30px;
    line-height: 1.2;
    text-align: center;
    margin: 0;
    animation:
      glitch-flicker 4s infinite,
      glitch-shake 0.5s infinite;

    @media (max-width: 575px) {
      font-size: 13vw;
    }
    &:before,
    &:after {
      content: "Code Seven";
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      padding: 30px;
      box-sizing: border-box;
    }

    &:before {
      color: transparent;
      text-shadow: 2px 0 red;
      animation: glitch-red 4s infinite;
      clip-path: inset(0);
      z-index: -1;
    }

    &:after {
      color: transparent;
      text-shadow: -2px 0 cyan;
      animation: glitch-cyan 4s infinite;
      clip-path: inset(0);
      z-index: -2;
    }
  }
}

// Мерцание: кратковременное исчезновение
@keyframes glitch-flicker {
  0%,
  19%,
  21%,
  23%,
  25%,
  54%,
  56%,
  58%,
  60%,
  62%,
  64%,
  66%,
  68%,
  70%,
  100% {
    opacity: 1;
  }
  20%,
  24%,
  55%,
  59%,
  61%,
  63%,
  65%,
  67%,
  69% {
    opacity: 0;
  }
}

// Лёгкое дрожание (подёргивание)
@keyframes glitch-shake {
  0%,
  100% {
    transform: translateX(0);
  }
  10% {
    transform: translateX(-1px);
  }
  20% {
    transform: translateX(1px);
  }
  30% {
    transform: translateX(-1px);
  }
  40% {
    transform: translateX(0);
  }
  50% {
    transform: translateX(1px);
  }
  60% {
    transform: translateX(-1px);
  }
  70% {
    transform: translateX(0);
  }
  80% {
    transform: translateX(1px);
  }
  90% {
    transform: translateX(-1px);
  }
}

// Глитч-смещение красного канала
@keyframes glitch-red {
  0%,
  100% {
    clip-path: inset(0);
    transform: translateX(0);
  }
  2% {
    clip-path: inset(15% 0 70% 0);
    transform: translateX(3px);
  }
  4% {
    clip-path: inset(30% 0 40% 0);
    transform: translateX(-2px);
  }
  6% {
    clip-path: inset(5% 0 80% 0);
    transform: translateX(1px);
  }
  8% {
    clip-path: inset(20% 0 60% 0);
    transform: translateX(-3px);
  }
  10% {
    clip-path: inset(0);
    transform: translateX(0);
  }
  /* остальное — без изменений */
}

// Глитч-смещение голубого канала
@keyframes glitch-cyan {
  0%,
  100% {
    clip-path: inset(0);
    transform: translateX(0);
  }
  3% {
    clip-path: inset(10% 0 75% 0);
    transform: translateX(-3px);
  }
  5% {
    clip-path: inset(25% 0 50% 0);
    transform: translateX(2px);
  }
  7% {
    clip-path: inset(5% 0 85% 0);
    transform: translateX(-1px);
  }
  9% {
    clip-path: inset(15% 0 65% 0);
    transform: translateX(3px);
  }
  11% {
    clip-path: inset(0);
    transform: translateX(0);
  }
  /* остальное — без изменений */
}
</style>
