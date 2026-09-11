<template>
  <section class="portfolio-sphere">
    <div class="portfolio-sphere__container">
      <canvas ref="canvasRef" class="portfolio-sphere__canvas"></canvas>
    </div>

    <Teleport to="body">
      <div
        v-if="selectedProject"
        class="portfolio-sphere__info"
        @click="closeDetail"
      >
        <button @click="closeDetail" class="portfolio-sphere__close">×</button>
        <div class="portfolio-sphere__detail">
          <div class="portfolio-sphere__img">
            <img
              :src="selectedProject.img"
              :alt="selectedProject.title"
              class="portfolio-sphere__detail-image"
            />
          </div>
          <div class="portfolio-sphere__detail-content">
            <h3 class="portfolio-sphere__detail-title">
              {{ selectedProject.title }}
            </h3>
            <p class="portfolio-sphere__detail-desc">
              {{ selectedProject.desc }}
            </p>
            <div class="portfolio-sphere__detail-tags">
              <span
                v-for="tag in selectedProject.tags"
                :key="tag"
                class="portfolio-sphere__detail-tag"
                >{{ tag }}</span
              >
            </div>
            <div class="portfolio-sphere__more">
              <a :href="selectedProject.url" target="_blank" class="btn">
                Перейти
              </a>
            </div>
          </div>
        </div>
      </div>
    </Teleport>
  </section>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from "vue";
import * as THREE from "three";

const canvasRef = ref(null);
const selectedProject = ref(null);
const isDesktop = ref(true);

let scene, camera, renderer, raycaster, mouse, animationId;
let cards = [];
let isAnimating = true;

const props = defineProps({
  cards: {
    type: Array,
    required: true,
  },
});

onMounted(() => {
  checkDevice();
  window.addEventListener("resize", checkDevice);
  initThree();
  animate();

  const canvasEl = canvasRef.value;
  if (canvasEl) {
    canvasEl.addEventListener("mousedown", onClickCard);
  }
});

onUnmounted(() => {
  if (animationId) cancelAnimationFrame(animationId);
  window.removeEventListener("resize", checkDevice);

  const canvasEl = canvasRef.value;
  if (canvasEl) {
    canvasEl.removeEventListener("mousedown", onClickCard);
  }

  renderer?.dispose();
});

function checkDevice() {
  isDesktop.value = window.innerWidth > 768;
}

function initThree() {
  const canvasEl = canvasRef.value;
  if (!canvasEl) return;

  const width = canvasEl.clientWidth;
  const height = canvasEl.clientHeight;

  camera = new THREE.PerspectiveCamera(60, width / height, 0.1, 1000);
  camera.position.set(0, 0, 50);

  scene = new THREE.Scene();
  scene.background = null;

  raycaster = new THREE.Raycaster();
  mouse = new THREE.Vector2();

  cards = [];

  props.cards.forEach((project, i) => {
    const cardWidth = 12;
    const cardHeight = 9;
    const texture = new THREE.TextureLoader().load(project.img);
    texture.minFilter = THREE.LinearFilter;
    texture.magFilter = THREE.LinearFilter;

    const geometry = new THREE.PlaneGeometry(cardWidth, cardHeight);
    const material = new THREE.MeshBasicMaterial({
      map: texture,
      transparent: true,
    });

    const card = new THREE.Mesh(geometry, material);

    const rangeX = 40;
    const rangeY = 30;
    const rangeZ = 30;

    const x = (Math.random() - 0.5) * rangeX;
    const y = (Math.random() - 0.5) * rangeY;
    const z = -5 - Math.random() * rangeZ;

    card.position.set(x, y, z);
    card.userData = { project, index: i };
    scene.add(card);
    cards.push(card);
  });

  renderer = new THREE.WebGLRenderer({
    antialias: true,
    alpha: true,
    canvas: canvasEl,
  });
  renderer.setSize(width, height);
  renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
  renderer.setClearColor(0x000000, 0);
}

function animate() {
  animationId = requestAnimationFrame(animate);

  if (isAnimating) {
    cards.forEach((card, i) => {
      const time = Date.now() * 0.001;
      card.position.y += Math.sin(time * 0.7 + i) * 0.02;
      card.position.x += Math.cos(time * 0.5 + i) * 0.02;
      card.rotation.y = Math.sin(time * 0.3 + i) * 0.05;
    });
  }

  renderer.render(scene, camera);
}

function onClickCard(event) {
  if (selectedProject.value) return; // блокируем повторный клик при открытом модале

  const canvasEl = canvasRef.value;
  if (!canvasEl || !scene) return;

  const rect = canvasEl.getBoundingClientRect();
  mouse.x = ((event.clientX - rect.left) / rect.width) * 2 - 1;
  mouse.y = -((event.clientY - rect.top) / rect.height) * 2 + 1;

  raycaster.setFromCamera(mouse, camera);

  const intersectableCards = cards.filter((c) => c.userData?.project);
  const intersects = raycaster.intersectObjects(intersectableCards);

  if (intersects.length > 0) {
    const clickedCard = intersects[0].object;
    openDetail(clickedCard.userData.project);
  }
}

function openDetail(project) {
  // Останавливаем анимацию
  isAnimating = false;

  // Скрываем все карточки, чтобы не просвечивали
  cards.forEach((card) => {
    card.visible = false;
  });

  selectedProject.value = project;
  document.body.style.overflow = "hidden";
}

function closeDetail() {
  // Восстанавливаем видимость всех карточек
  cards.forEach((card) => {
    card.visible = true;
  });

  selectedProject.value = null;
  isAnimating = true;
  document.body.style.overflow = "";
}
</script>

<style lang="scss" scoped>
.portfolio-sphere {
  padding: 2rem;
  margin: 0 auto;
  display: flex;
  flex-direction: column;
  align-items: center;
  position: relative;

  &__title {
    font-size: 2.5rem;
    text-align: center;
    margin-bottom: 2rem;
    color: #fff;
  }

  &__container {
    width: 100%;
    max-width: 100dvw;
    height: 60vh;
    position: relative;
    overflow: hidden;
    border-radius: var(--radius);
  }

  &__canvas {
    width: 100%;
    height: 100%;
    display: block;
    background: transparent;
  }

  /* --- Модальное окно --- */
  &__info {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.85);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 3000;
    backdrop-filter: blur(0.2rem);
    padding: 2rem;
    box-sizing: border-box;
  }

  &__close {
    position: absolute;
    top: 2rem;
    right: 2rem;
    background: none;
    border: none;
    font-size: 3rem;
    color: white;
    cursor: pointer;
    z-index: 3001;
    transition: opacity 0.2s;

    &:hover {
      opacity: 0.8;
    }
  }

  &__detail {
    background: var(--light);
    border-radius: var(--radius);
    max-width: 90vw;
    max-height: 90vh;
    overflow: hidden;
    box-shadow: 0 20px 50px rgba(0, 0, 0, 0.3);
    display: flex;
    gap: 2rem;
    padding: 2rem;

    @media (max-width: 768px) {
      flex-direction: column;
      max-width: 95vw;
      max-height: 95vh;
      padding: 1.5rem;
    }
  }

  &__img {
    overflow: hidden;
    border-radius: 1.6rem;
    flex-shrink: 0;
    width: 300px;

    @media (max-width: 768px) {
      width: 100%;
      height: auto;
    }
  }

  &__detail-image {
    width: 100%;
    height: auto;
    display: block;
  }

  &__detail-content {
    display: flex;
    flex-direction: column;
    gap: 1rem;
    min-width: 0;

    @media (max-width: 768px) {
      width: 100%;
    }
  }

  &__detail-title {
    font-size: 1.5rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
    color: #1e293b;
    word-break: break-word;
  }

  &__detail-desc {
    color: var(--color-text);
    line-height: 1.6;
    margin-bottom: 1rem;
  }

  &__detail-tags {
    display: flex;
    gap: 0.5rem;
    margin-bottom: 1rem;
    flex-wrap: wrap;
  }

  &__detail-tag {
    display: inline-block;
    background: #eef2ff;
    color: #4f46e5;
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 600;
  }

  &__more {
    margin-top: auto;
  }

  .btn {
    display: inline-block;
    padding: 0.75rem 1.5rem;
    background: #4f46e5;
    color: white;
    text-decoration: none;
    border-radius: 0.5rem;
    font-weight: 600;
    transition: background 0.2s;

    &:hover {
      background: #4338ca;
    }
  }
}
</style>
