/**
 * Модуль для сортировки таблицы команд
 */

/**
 * Функция сортировки команд
 * @param {Array} teams - Массив команд
 * @param {string} key - Ключ для сортировки
 * @param {string} direction - Направление сортировки ('asc' или 'desc')
 * @returns {Array} Отсортированный массив команд
 */
export const sortTeams = (teams, key, direction) => {
  return [...teams].sort((a, b) => {
    let valueA = a[key];
    let valueB = b[key];

    if (key === "name") {
      return direction === "asc"
        ? valueA.localeCompare(valueB)
        : valueB.localeCompare(valueA);
    }
    return direction === "asc" ? valueA - valueB : valueB - valueA;
  });
};

/**
 * Обновление индикаторов сортировки в заголовках таблицы
 * @param {HTMLElement} teamsTable - Элемент таблицы
 * @param {Object} sortConfig - Конфигурация сортировки {key, direction}
 */
export const updateSortIndicators = (teamsTable, sortConfig) => {
  // Сброс стрелочек
  document.querySelectorAll("#teams-table th span").forEach((span) => {
    span.textContent = span.textContent.replace(/[▲▼]/g, "").trim();
  });

  // Установка стрелочек
  document.querySelectorAll("#teams-table th").forEach((th) => {
    const sortKey = th.getAttribute("data-sort");

    if (sortKey && !["index", "name", "games"].includes(sortKey)) {
      const spans = th.querySelectorAll("span");
      const isActive = sortKey === sortConfig.key;
      const indicator = isActive
        ? sortConfig.direction === "asc"
          ? " ▲"
          : " ▼"
        : " ▼";
      spans.forEach((span) => {
        span.textContent += indicator;
      });
    }
  });

  // Добавляем класс к таблице
  if (teamsTable) {
    teamsTable.classList.remove("table-asc", "table-desc");
    teamsTable.classList.add(
      sortConfig.direction === "asc" ? "table-asc" : "table-desc"
    );
  }
};

