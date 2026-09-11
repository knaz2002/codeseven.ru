import { defineNuxtConfig } from "nuxt/config";

export default defineNuxtConfig({
  compatibilityDate: "2025-12-12",
  vue: {
    compilerOptions: {
      whitespace: "condense",
    },
  },

  devtools: { enabled: false },

  modules: ["@pinia/nuxt", "nuxt-swiper"],

  css: ["~/assets/style/main.scss", "simplebar/dist/simplebar.css"],

  app: {
    head: {
      title: "Code7",
      meta: [
        { name: "viewport", content: "width=device-width, initial-scale=1" },
      ],
      link: [{ rel: "icon", type: "image/x-icon", href: "/favicon.ico" }],
    },
  },
});
