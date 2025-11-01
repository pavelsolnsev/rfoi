const themeToggle = document.querySelector(".caption-content-icon img");

if (themeToggle) {
  themeToggle.addEventListener("click", () => {
    const body = document.body;
    const isDark = body.getAttribute("data-theme") === "dark";

    if (isDark) {
      body.setAttribute("data-theme", "light");
      themeToggle.src = "img/main/dark.svg";
    } else {
      body.setAttribute("data-theme", "dark");
      themeToggle.src = "img/main/light.svg";
    }
  });
}



