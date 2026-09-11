<template>
  <div class="portfolio-sphere">
    <div class="portfolio-sphere__content">
      <canvas class="portfolio-sphere__canvas" ref="canvasRef"></canvas>
      <Teleport to="body">
        <div
          v-if="selectedProject"
          class="portfolio-sphere__info"
          @click="closeDetail"
        >
          <button @click="closeDetail" class="portfolio-sphere__close">
            ×
          </button>
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
                <a
                  :href="selectedProject.url"
                  target="_blank"
                  class="btn btn-theme"
                  >Перейти</a
                >
              </div>
            </div>
          </div>
        </div>
      </Teleport>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted, nextTick } from "vue";
import * as THREE from "three";
import { OrbitControls } from "three/examples/jsm/controls/OrbitControls.js";

const canvasRef = ref(null);
const selectedProject = ref(null);

let scene, camera, renderer, sphere, raycaster, mouse, animationId, controls;
let darkModeObserver = null; // ← для отписки от наблюдателя темы

const props = defineProps({
  cards: {
    type: Array,
    required: true,
  },
});

const projects = props.cards;

// ИНИЦИАЛИЗАЦИЯ THREE.JS СЦЕНЫ
// Создаёт камеру, сцену, сферу, карточки и рендерер
function initThree() {
  const canvasEl = canvasRef.value;
  if (!canvasEl) return;

  const width = canvasEl.clientWidth;
  const height = canvasEl.clientHeight;

  camera = new THREE.PerspectiveCamera(75, width / height, 0.1, 1000);
  camera.position.z = 50;

  scene = new THREE.Scene();
  scene.background = null;

  // Создаём wireframe-сферу (визуальный каркас)
  const geometry = new THREE.SphereGeometry(20, 32, 32);
  const material = new THREE.MeshBasicMaterial({
    color: 0x000000, // временный цвет — будет обновлён
    wireframe: true,
    transparent: true,
    opacity: 0.3,
  });
  sphere = new THREE.Mesh(geometry, material);
  scene.add(sphere);

  // Обновляем цвет сферы в зависимости от текущей темы
  updateSphereColor();

  //ФУНКЦИЯ: Создаёт текстуру-маску для круглых карточек
  const createCircularAlphaMap = (size = 256) => {
    const canvas = document.createElement("canvas");
    canvas.width = size;
    canvas.height = size;
    const ctx = canvas.getContext("2d");
    ctx.clearRect(0, 0, size, size);
    ctx.fillStyle = "white";
    ctx.beginPath();
    ctx.arc(size / 2, size / 2, size / 2, 0, Math.PI * 2);
    ctx.fill();
    const texture = new THREE.CanvasTexture(canvas);
    texture.wrapS = THREE.ClampToEdgeWrapping;
    texture.wrapT = THREE.ClampToEdgeWrapping;
    return texture;
  };

  const alphaMap = createCircularAlphaMap(256);

  //РАЗМЕЩЕНИЕ КАРТОЧЕК НА СФЕРЕ
  projects.forEach((project, i) => {
    const cardSize = 10;
    const imageTexture = new THREE.TextureLoader().load(project.img);
    imageTexture.minFilter = THREE.LinearFilter;
    imageTexture.magFilter = THREE.LinearFilter;
    imageTexture.wrapS = THREE.ClampToEdgeWrapping;
    imageTexture.wrapT = THREE.ClampToEdgeWrapping;

    const cardMaterial = new THREE.MeshBasicMaterial({
      map: imageTexture,
      alphaMap: alphaMap,
      transparent: true,
      side: THREE.DoubleSide,
    });

    const cardGeometry = new THREE.PlaneGeometry(cardSize, cardSize);
    const card = new THREE.Mesh(cardGeometry, cardMaterial);

    // РАСЧЁТ ПОЗИЦИИ НА СФЕРЕ (Fibonacci Spiral)
    const phi = Math.acos(-1 + (2 * (i + 1)) / projects.length);
    const theta = Math.sqrt(projects.length * Math.PI) * phi;

    // РАССТОЯНИЕ КАРТОЧЕК ОТ ЦЕНТРА СФЕРЫ
    card.position.set(
      22 * Math.cos(theta) * Math.sin(phi), // X
      22 * Math.sin(theta) * Math.sin(phi), // Y
      22 * Math.cos(phi), // Z
    );

    card.userData = { project, index: i };
    scene.add(card);
  });

  // Инициализация WebGL-рендерера
  renderer = new THREE.WebGLRenderer({
    antialias: true,
    alpha: true,
    canvas: canvasEl,
  });
  renderer.setSize(width, height);
  renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
  renderer.setClearColor(0x000000, 0);

  // Raycaster для взаимодействия с карточками
  raycaster = new THREE.Raycaster();
  mouse = new THREE.Vector2();

  // Управление камерой (вращение мышью)
  controls = new OrbitControls(camera, canvasEl);
  controls.enableDamping = true;
  controls.dampingFactor = 0.5;
  controls.rotateSpeed = 0.5;
  controls.enablePan = false;
  controls.enableZoom = false;
}

// Обновляет цвет wireframe-сферы при смене темы
// Использует класс "dark-mode" на <body> для определения текущей темы
function updateSphereColor() {
  if (!sphere || !sphere.material) return;

  const isDarkMode = document.body.classList.contains("dark-mode");
  const newColor = isDarkMode ? 0xfffff0 : 0x2b2b2b; // белый в dark, серый в light

  sphere.material.color.set(newColor);
}

// ГЛАВНЫЙ ЦИКЛ АНИМАЦИИ
// Обновляет управление камерой и заставляет карточки всегда смотреть на камеру (billboard effect)
function animate() {
  animationId = requestAnimationFrame(animate);
  controls.update();
  scene.children.forEach((obj) => {
    if (obj.userData && obj.userData.project) {
      obj.lookAt(camera.position);
    }
  });
  renderer?.render(scene, camera);
}

// Изменение размера окна
function onWindowResize() {
  const canvasEl = canvasRef.value;
  if (!canvasEl || !renderer) return;
  const width = canvasEl.clientWidth;
  const height = canvasEl.clientHeight;
  camera.aspect = width / height;
  camera.updateProjectionMatrix();
  renderer.setSize(width, height);
}

// клик мыши (выбор карточки)
function onMouseDown(event) {
  if (selectedProject.value) return;
  const canvasEl = canvasRef.value;
  if (!canvasEl) return;
  const rect = canvasEl.getBoundingClientRect();
  mouse.x = ((event.clientX - rect.left) / rect.width) * 2 - 1;
  mouse.y = -((event.clientY - rect.top) / rect.height) * 2 + 1;
  raycaster.setFromCamera(mouse, camera);
  const intersects = raycaster.intersectObjects(
    scene.children.filter((obj) => obj.userData && obj.userData.project),
  );
  if (intersects.length > 0) {
    openDetail(intersects[0].object.userData.project);
  }
}

// Движение мыши (курсор-указатель)
function onMouseMove(event) {
  const canvasEl = canvasRef.value;
  if (!canvasEl) return;
  const rect = canvasEl.getBoundingClientRect();
  mouse.x = ((event.clientX - rect.left) / rect.width) * 2 - 1;
  mouse.y = -((event.clientY - rect.top) / rect.height) * 2 + 1;
  raycaster.setFromCamera(mouse, camera);
  const intersects = raycaster.intersectObjects(
    scene.children.filter((obj) => obj.userData && obj.userData.project),
  );
  canvasEl.style.cursor = intersects.length > 0 ? "pointer" : "default";
}

// Уход мыши за пределы холста
function onMouseLeave() {
  const canvasEl = canvasRef.value;
  if (canvasEl) canvasEl.style.cursor = "default";
}

//Открытие модального окна проекта
function openDetail(project) {
  selectedProject.value = project;
  document.body.style.overflow = "hidden";
}

// Закрытие модального окна проекта
function closeDetail() {
  selectedProject.value = null;
  document.body.style.overflow = "";
}

// ЖИЗНЕННЫЙ ЦИКЛ: Компонент смонтирован
onMounted(async () => {
  await nextTick();
  initThree();
  animate();

  window.addEventListener("resize", onWindowResize);
  const canvasEl = canvasRef.value;
  if (canvasEl) {
    canvasEl.addEventListener("mousedown", onMouseDown);
    canvasEl.addEventListener("mousemove", onMouseMove);
    canvasEl.addEventListener("mouseleave", onMouseLeave);
  }

  // Наблюдаем за изменением классов <body> (для реакции на смену темы)
  darkModeObserver = new MutationObserver(() => {
    updateSphereColor();
  });

  darkModeObserver.observe(document.body, {
    attributes: true,
    attributeFilter: ["class"],
  });
});

// ЖИЗНЕННЫЙ ЦИКЛ: Компонент размонтирован
// Очищает ресурсы: анимацию, слушатели, рендерер, наблюдатель
onUnmounted(() => {
  if (animationId) cancelAnimationFrame(animationId);
  window.removeEventListener("resize", onWindowResize);
  const canvasEl = canvasRef.value;
  if (canvasEl) {
    canvasEl.removeEventListener("mousedown", onMouseDown);
    canvasEl.removeEventListener("mousemove", onMouseMove);
    canvasEl.removeEventListener("mouseleave", onMouseLeave);
  }
  renderer?.dispose();

  if (darkModeObserver) {
    darkModeObserver.disconnect();
  }
});
</script>

<style lang="scss" scoped>
.portfolio-sphere {
  padding: 2rem 0rem;
  margin: 0 auto;
  // display: flex;
  // position: absolute;
  // left: 50%;
  // top: 50%;
  // transform: translate(-50%, -50%);
  height: 100vh;
  &__content {
    margin: 0 auto;
    position: relative;
    height: 100%;
  }

  &__title {
    position: absolute;
    top: 5rem;
    padding: 0 2rem;
  }

  &__canvas {
    width: 100dvw;
    height: 100dvh;
    position: absolute;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%);
    box-shadow: none;
    background: transparent;
    // @media (max-width: 575px) {
    //   width: 70dvw;
    //   height: 70dvh;
    // }
  }

  &__info {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 3000;
    backdrop-filter: blur(0.2rem);
  }

  &__close {
    position: absolute;
    top: 2rem;
    right: 2rem;
    background: none;
    border: none;
    font-size: 4rem;
    color: var(--color-bg);
    cursor: pointer;
    z-index: 3001;
  }

  &__detail {
    background: var(--grafit);
    border-radius: var(--radius);
    max-width: 80vw;
    max-width: 50%;
    max-height: 80vh;
    overflow: hidden;
    box-shadow: 0 20px 50px rgba(0, 0, 0, 0.2);
    display: flex;
    flex-direction: column;
    gap: 2rem;
    padding: 2rem;
    // width: 50%;
    @media (max-width: 768px) {
      flex-direction: column;
      max-width: 90vw;
      max-height: 90vh;
      padding: 1rem;
    }
  }

  &__img {
    overflow: hidden;
    border-radius: 1.6rem;
    filter: drop-shadow(0 0 2px rgba(0, 0, 0, 0.4));
    img {
    }
  }

  &__detail-content {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;

    @media (max-width: 768px) {
      width: 100%;
    }
  }

  &__detail-title {
    font-size: 1.5rem;
    font-weight: 700;
    margin-bottom: 1rem;
    color: var(--text);
    min-width: 0;
  }

  &__detail-desc {
    color: var(--light);
    line-height: 1.6;
    margin-right: auto;
    margin-bottom: 0;
    font-weight: 700;
    font-size: 1.6rem;
  }

  &__detail-tags {
    display: flex;
    gap: 0.5rem;
    margin-bottom: 1.5rem;
  }

  // &__detail-tag {
  //   display: inline-block;
  //   background: #eef2ff;
  //   color: #4f46e5;
  //   padding: 0.25rem 0.75rem;
  //   border-radius: 20px;
  //   font-size: 0.85rem;
  //   font-weight: 600;
  // }
}
</style>
