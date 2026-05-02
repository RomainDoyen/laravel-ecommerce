(function () {
  "use strict";

  const THEME_KEY = "laravel-ecommerce-docs-theme";

  function getStoredTheme() {
    return localStorage.getItem(THEME_KEY);
  }

  function applyTheme(theme) {
    document.documentElement.setAttribute("data-theme", theme);
    localStorage.setItem(THEME_KEY, theme);
    const btn = document.getElementById("theme-toggle");
    if (btn) {
      btn.setAttribute("aria-label", theme === "light" ? "Thème sombre" : "Thème clair");
      btn.textContent = theme === "light" ? "🌙" : "☀️";
    }
  }

  function initTheme() {
    const stored = getStoredTheme();
    const prefersDark = window.matchMedia("(prefers-color-scheme: dark)").matches;
    applyTheme(stored || (prefersDark ? "dark" : "light"));
  }

  document.getElementById("theme-toggle")?.addEventListener("click", function () {
    const current = document.documentElement.getAttribute("data-theme") || "dark";
    applyTheme(current === "light" ? "dark" : "light");
  });

  initTheme();

  /* Menu mobile */
  const sidebar = document.getElementById("sidebar");
  const menuToggle = document.getElementById("menu-toggle");

  menuToggle?.addEventListener("click", function () {
    sidebar?.classList.toggle("is-open");
    const open = sidebar?.classList.contains("is-open");
    menuToggle.setAttribute("aria-expanded", open ? "true" : "false");
  });

  document.querySelectorAll("#sidebar a[href^='#']").forEach(function (link) {
    link.addEventListener("click", function () {
      if (window.innerWidth <= 960) {
        sidebar?.classList.remove("is-open");
        menuToggle?.setAttribute("aria-expanded", "false");
      }
    });
  });

  /* Scroll spy — lien actif */
  const sections = document.querySelectorAll("section.doc-section[id]");
  const navLinks = document.querySelectorAll("#sidebar .nav-list a[href^='#']");

  function updateActiveNav() {
    const scrollY = window.scrollY + 120;
    let current = "";
    sections.forEach(function (section) {
      const top = section.offsetTop;
      const h = section.offsetHeight;
      if (scrollY >= top && scrollY < top + h) {
        current = section.getAttribute("id") || "";
      }
    });
    navLinks.forEach(function (link) {
      const href = link.getAttribute("href");
      link.classList.toggle("is-active", href === "#" + current);
    });
  }

  window.addEventListener("scroll", updateActiveNav, { passive: true });
  updateActiveNav();

  /* Recherche dans la nav */
  const searchInput = document.getElementById("doc-search");
  searchInput?.addEventListener("input", function () {
    const q = this.value.trim().toLowerCase();
    document.querySelectorAll("#sidebar .nav-list li").forEach(function (li) {
      const text = li.textContent?.toLowerCase() || "";
      li.classList.toggle("hidden", q !== "" && !text.includes(q));
    });
    document.querySelectorAll("#sidebar .nav-section").forEach(function (header) {
      const next = header.nextElementSibling;
      if (!next || !next.classList.contains("nav-list")) return;
      const anyVisible = Array.from(next.querySelectorAll("li")).some(function (li) {
        return !li.classList.contains("hidden");
      });
      header.classList.toggle("hidden", q !== "" && !anyVisible);
    });
  });
})();
