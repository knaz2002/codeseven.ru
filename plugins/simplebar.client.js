import { defineNuxtPlugin } from "#app";
import SimpleBar from "simplebar";

export default defineNuxtPlugin((nuxtApp) => {
  if (process.client) {
    let observer = null;

    const initSimpleBar = () => {
      // Отключаем observer на время инициализации, чтобы изменения DOM от SimpleBar не вызывали бесконечный цикл
      if (observer) {
        observer.disconnect();
      }

      document.querySelectorAll("[data-simplebar]").forEach((el) => {
        // Инициализируем только элементы, у которых ещё нет SimpleBar (избегаем destroy → DOM change → observer → loop)
        if (el._simplebar) {
          return;
        }

        try {
          el._simplebar = new SimpleBar(el, {
            autoHide: true,
            scrollbarMinSize: 30,
            scrollbarMaxSize: 100,
            touch: true,
          });
        } catch (e) {
          // console.error("Error initializing SimpleBar:", e);
        }
      });

      // Включаем observer снова после того, как DOM успокоится
      if (observer) {
        requestAnimationFrame(() => {
          observer.observe(document.body, {
            childList: true,
            subtree: true,
          });
        });
      }
    };

    // Инициализируем после монтирования приложения, когда DOM готов (index, TheGlitch и т.д.)
    nuxtApp.hook("app:mounted", () => {
      nuxtApp.hook("page:finish", () => {
        requestAnimationFrame(() => initSimpleBar());
      });
      requestAnimationFrame(() => initSimpleBar());
    });

    // Перезапускаем при изменении DOM (для модалок) — только для новых элементов
    observer = new MutationObserver(initSimpleBar);
    observer.observe(document.body, {
      childList: true,
      subtree: true,
    });

    // Очищаем при размонтировании
    return {
      provide: {
        simplebar: {
          update: initSimpleBar,
        },
      },
    };
  }
});