/* ========================================
   DOCUMENT READY
======================================== */

document.addEventListener("DOMContentLoaded", function () {
  initClock();

  initTooltip();

  initPopover();
});

/* ========================================
   LIVE CLOCK
======================================== */

function initClock() {
  const clock = document.getElementById("liveClock");

  if (!clock) return;

  function updateClock() {
    const now = new Date();

    const hours = String(now.getHours()).padStart(2, "0");

    const minutes = String(now.getMinutes()).padStart(2, "0");

    clock.textContent = hours + ":" + minutes + " WIB";
  }

  updateClock();

  setInterval(updateClock, 1000);
}

/* ========================================
   BOOTSTRAP TOOLTIP
======================================== */

function initTooltip() {
  const tooltipTriggerList = [].slice.call(
    document.querySelectorAll('[data-bs-toggle="tooltip"]'),
  );

  tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl);
  });
}

/* ========================================
   BOOTSTRAP POPOVER
======================================== */

function initPopover() {
  const popoverTriggerList = [].slice.call(
    document.querySelectorAll('[data-bs-toggle="popover"]'),
  );

  popoverTriggerList.map(function (popoverTriggerEl) {
    return new bootstrap.Popover(popoverTriggerEl);
  });
}

/* ========================================
   GLOBAL ALERT
======================================== */

function showAlert(message, type = "success") {
  const alertBox = document.createElement("div");

  alertBox.className = `alert alert-${type} shadow-sm position-fixed top-0 end-0 m-4`;

  alertBox.style.zIndex = "9999";

  alertBox.innerHTML = `
        ${message}
    `;

  document.body.appendChild(alertBox);

  setTimeout(() => {
    alertBox.remove();
  }, 3000);
}

/* ========================================
   CONFIRM DELETE
======================================== */

function confirmDelete(message = "Yakin ingin menghapus data?") {
  return confirm(message);
}

/* ========================================
   CLOSE SIDEBAR MOBILE
======================================== */

window.addEventListener("resize", function () {
  const sidebar = document.getElementById("sidebar-wrapper");

  if (!sidebar) return;

  if (window.innerWidth > 768) {
    sidebar.classList.remove("active");
  }
});
