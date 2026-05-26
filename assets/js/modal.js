/* ========================================
   MODAL MODULE
======================================== */

document.addEventListener("DOMContentLoaded", function () {
  initModalFocus();

  initModalCleanup();

  initDeleteModal();
});

/* ========================================
   AUTO FOCUS INPUT
======================================== */

function initModalFocus() {
  const modals = document.querySelectorAll(".modal");

  modals.forEach((modal) => {
    modal.addEventListener("shown.bs.modal", function () {
      const input = modal.querySelector(
        "input:not([type=hidden]), textarea, select",
      );

      if (input) {
        input.focus();
      }
    });
  });
}

/* ========================================
   CLEANUP BACKDROP
======================================== */

function initModalCleanup() {
  document.addEventListener("hidden.bs.modal", function () {
    document.body.classList.remove("modal-open");

    const backdrops = document.querySelectorAll(".modal-backdrop");

    backdrops.forEach((backdrop) => {
      backdrop.remove();
    });
  });
}

/* ========================================
   DELETE CONFIRMATION
======================================== */

function initDeleteModal() {
  const deleteButtons = document.querySelectorAll("[data-delete]");

  deleteButtons.forEach((button) => {
    button.addEventListener("click", function (e) {
      const message = this.dataset.message || "Yakin ingin menghapus data ini?";

      if (!confirm(message)) {
        e.preventDefault();
      }
    });
  });
}

/* ========================================
   OPEN MODAL BY ID
======================================== */

function openModal(modalId) {
  const modalElement = document.getElementById(modalId);

  if (!modalElement) return;

  const modal = new bootstrap.Modal(modalElement);

  modal.show();
}

/* ========================================
   CLOSE MODAL BY ID
======================================== */

function closeModal(modalId) {
  const modalElement = document.getElementById(modalId);

  if (!modalElement) return;

  const modal = bootstrap.Modal.getInstance(modalElement);

  if (modal) {
    modal.hide();
  }
}

/* ========================================
   AUTO MODAL FROM SESSION
======================================== */

function autoOpenModal(modalId) {
  if (!modalId) return;

  const modalElement = document.getElementById(modalId);

  if (!modalElement) return;

  const modal = new bootstrap.Modal(modalElement);

  modal.show();
}
