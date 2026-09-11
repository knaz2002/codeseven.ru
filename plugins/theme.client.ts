export default defineNuxtPlugin(() => {
  const setTheme = () => {
    document.documentElement.classList.remove("dark-mode", "light-mode");
    document.body.classList.remove("dark-mode", "light-mode");
    document.documentElement.classList.add("dark-mode");
    document.body.classList.add("dark-mode");
    localStorage.setItem("theme", "dark");
    document.cookie = "theme=dark; path=/; max-age=31536000; SameSite=Lax";
  };

  setTheme();

  return {
    provide: {
      theme: {
        set: () => setTheme(),
        get: () => "dark" as const,
      },
    },
  };
});
