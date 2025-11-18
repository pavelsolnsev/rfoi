/**
 * Модуль переключения темы (темная/светлая)
 */
(function() {
  'use strict';
  
  const themeToggle = document.querySelector(".caption-content-icon img");

  if (!themeToggle) {
    return;
  }

  // Восстановление темы из localStorage
  const savedTheme = localStorage.getItem("theme");
  if (savedTheme) {
    document.body.setAttribute("data-theme", savedTheme);
    updateThemeIcon(savedTheme === "dark");
  }

  themeToggle.addEventListener("click", () => {
    const body = document.body;
    const isDark = body.getAttribute("data-theme") === "dark";
    const newTheme = isDark ? "light" : "dark";

    body.setAttribute("data-theme", newTheme);
    localStorage.setItem("theme", newTheme);
    updateThemeIcon(!isDark);
  });

  function updateThemeIcon(isDark) {
    themeToggle.src = isDark ? "img/main/light.svg" : "img/main/dark.svg";
  }
})();

/**
 * Анимация стрелки указателя в ссылках
 */
(function() {
  'use strict';
  
  // Обертываем эмодзи стрелки в span для анимации
  const links = document.querySelectorAll('.caption-link a');
  
  links.forEach(link => {
    const text = link.textContent;
    // Проверяем, есть ли эмодзи стрелки в тексте
    if (text.includes('👉')) {
      // Заменяем эмодзи на span с классом
      link.innerHTML = text.replace('👉', '<span class="pointing-arrow">👉</span>');
    }
  });
})();



