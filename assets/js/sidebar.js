/* ========================================
   SIDEBAR MODULE
======================================== */

document.addEventListener("DOMContentLoaded", function () {
  initSidebarToggle();

  initSidebarActive();

  initSidebarMobileClose();
});

/* ========================================
   TOGGLE SIDEBAR
======================================== */

function initSidebarToggle() {
  const toggleButton = document.getElementById("menu-toggle");

  const sidebar = document.getElementById("sidebar-wrapper");

  const content = document.querySelector(".content-wrapper");

  if (!toggleButton || !sidebar || !content) return;

  toggleButton.addEventListener("click", function () {
    /* MOBILE */
    if (window.innerWidth <= 768) {
      sidebar.classList.toggle("active");
    } else {

    /* DESKTOP */
      sidebar.classList.toggle("collapsed");

      content.classList.toggle("expanded");
    }
  });
}

/* ========================================
   ACTIVE MENU DETECTOR
======================================== */

function initSidebarActive() {
  const currentUrl = window.location.href;

  const navLinks = document.querySelectorAll(".sidebar-premium .nav-link");

  navLinks.forEach((link) => {
    if (link.href === currentUrl) {
      link.classList.add("active");
    }
  });
}

/* ========================================
   CLOSE MOBILE SIDEBAR
======================================== */

function initSidebarMobileClose() {
  const sidebar = document.getElementById("sidebar-wrapper");

  const navLinks = document.querySelectorAll(".sidebar-premium .nav-link");

  if (!sidebar) return;

  navLinks.forEach((link) => {
    link.addEventListener("click", function () {
      if (window.innerWidth <= 768) {
        sidebar.classList.remove("active");
      }
    });
  });
}

/* ========================================
   AUTO RESET SIDEBAR
======================================== */

window.addEventListener("resize", function () {
  const sidebar = document.getElementById("sidebar-wrapper");

  const content = document.querySelector(".content-wrapper");

  if (!sidebar || !content) return;

  if (window.innerWidth > 768) {
    sidebar.classList.remove("active");
  } else {
    sidebar.classList.remove("collapsed");

    content.classList.remove("expanded");
  }
});
