<template>
  <!-- Анимация снега -->
  <div ref="container" class="snow-circles-background"></div>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount } from "vue";
import * as THREE from "three";

const container = ref(null);
let scene, camera, renderer, points, geometry, material;
let animationId = null;
let themeObserver = null;

// === Настройка ===
const MAX_PIXEL_SIZE = 10; // ← МАКСИМУМ В ПИКСЕЛЯХ НА ЭКРАНЕ
const MIN_PIXEL_SIZE = 4; // минимум — для разнообразия

// === 1. Текстура кружка ===
const createCircleTexture = () => {
  const size = 32;
  const canvas = document.createElement("canvas");
  canvas.width = size;
  canvas.height = size;
  const ctx = canvas.getContext("2d");

  ctx.clearRect(0, 0, size, size);
  const cx = size / 2,
    cy = size / 2,
    r = size * 0.45;
  const grad = ctx.createRadialGradient(cx, cy, 0, cx, cy, r);
  grad.addColorStop(0, "rgba(255,255,255,1)");
  grad.addColorStop(1, "rgba(255,255,255,0)");
  ctx.beginPath();
  ctx.arc(cx, cy, r, 0, Math.PI * 2);
  ctx.fillStyle = grad;
  ctx.fill();

  const tex = new THREE.CanvasTexture(canvas);
  tex.needsUpdate = true;
  return tex;
};

// === 2. Обновление внешнего вида под тему ===
const updateAppearance = () => {
  if (!material) return;
  const isDark = document.body.classList.contains("dark-theme");
  material.color.setHex(isDark ? 0xffffff : 0xb0e0ff);
  material.opacity = isDark ? 0.85 : 0.6;
  material.needsUpdate = true;
};

// === 3. Наблюдатель за темой ===
const startThemeObserver = () => {
  updateAppearance();
  themeObserver = new MutationObserver((mutations) => {
    for (const m of mutations) {
      if (
        m.type === "attributes" &&
        m.attributeName === "class" &&
        m.target === document.body
      ) {
        updateAppearance();
      }
    }
  });
  themeObserver.observe(document.body, {
    attributes: true,
    attributeFilter: ["class"],
  });
};

const stopThemeObserver = () => {
  if (themeObserver) {
    themeObserver.disconnect();
    themeObserver = null;
  }
};

// === 4. Инициализация ===
const init = () => {
  if (typeof window === "undefined") return;

  const w = window.innerWidth,
    h = window.innerHeight;
  const pixelRatio = window.devicePixelRatio || 1;

  scene = new THREE.Scene();
  camera = new THREE.PerspectiveCamera(75, w / h, 0.1, 1000);
  camera.position.set(0, 20, 50);
  camera.lookAt(0, 0, 0);

  renderer = new THREE.WebGLRenderer({ alpha: true, antialias: true });
  renderer.setSize(w, h);
  renderer.setPixelRatio(pixelRatio);
  renderer.domElement.style.cssText = `
    position: fixed; top: 0; left: 0;
    width: 100%; height: 100%;
    z-index: -1; pointer-events: none;
  `;

  if (container.value) container.value.appendChild(renderer.domElement);

  createCircles(pixelRatio);
  startThemeObserver();
  animate();
};

// === 5. Создание кружков с ограничением в пикселях ===
const createCircles = (pixelRatio) => {
  const count = 600;

  // Преобразуем пиксели → world units
  const maxSizeWorld = MAX_PIXEL_SIZE / pixelRatio; // 10px → ~5 при dPR=2
  const minSizeWorld = MIN_PIXEL_SIZE / pixelRatio; // 4px → ~2 при dPR=2

  const positions = new Float32Array(count * 3);
  const sizes = new Float32Array(count);
  const velocities = new Float32Array(count);

  for (let i = 0; i < count; i++) {
    const i3 = i * 3;
    positions[i3] = (Math.random() - 0.5) * 200;
    positions[i3 + 1] = Math.random() * 150 + 50;
    positions[i3 + 2] = (Math.random() - 0.5) * 200;

    sizes[i] = minSizeWorld + Math.random() * (maxSizeWorld - minSizeWorld);
    velocities[i] = 0.5 + Math.random() * 1.0;
  }

  geometry = new THREE.BufferGeometry();
  geometry.setAttribute("position", new THREE.BufferAttribute(positions, 3));
  geometry.setAttribute("size", new THREE.BufferAttribute(sizes, 1));
  geometry.velocities = velocities;

  material = new THREE.PointsMaterial({
    size: maxSizeWorld, // fallback (но будет переопределён атрибутом 'size')
    map: createCircleTexture(),
    transparent: true,
    depthWrite: false,
    blending: THREE.AdditiveBlending,
    sizeAttenuation: false, // ← КЛЮЧЕВОЕ: отключаем масштабирование по расстоянию
  });

  points = new THREE.Points(geometry, material);
  scene.add(points);
};

// === 6. Анимация ===
const animate = () => {
  animationId = requestAnimationFrame(animate);
  if (!geometry) return;

  const pos = geometry.attributes.position.array;
  const vel = geometry.velocities;
  const n = pos.length / 3;

  for (let i = 0; i < n; i++) {
    const i3 = i * 3;
    pos[i3 + 1] -= vel[i] * 0.016;
    if (pos[i3 + 1] < -40) {
      pos[i3] = (Math.random() - 0.5) * 200;
      pos[i3 + 1] = Math.random() * 100 + 120;
      pos[i3 + 2] = (Math.random() - 0.5) * 200;
    }
  }

  geometry.attributes.position.needsUpdate = true;
  renderer.render(scene, camera);
};

// === 7. Cleanup ===
const cleanup = () => {
  if (animationId) cancelAnimationFrame(animationId);
  stopThemeObserver();
  if (renderer) {
    renderer.dispose();
    renderer.domElement.remove();
  }
};

// === 8. Lifecycle ===
onMounted(() => {
  if (process.client) {
    init();
    window.addEventListener("resize", () => {
      if (renderer) {
        const w = window.innerWidth,
          h = window.innerHeight;
        camera.aspect = w / h;
        camera.updateProjectionMatrix();
        renderer.setSize(w, h);
      }
    });
  }
});

onBeforeUnmount(() => {
  cleanup();
});
</script>

<style scoped>
.snow-circles-background {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  z-index: -1;
  pointer-events: none;
}
</style>
