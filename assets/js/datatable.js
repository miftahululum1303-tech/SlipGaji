/* ========================================
   DATATABLE MODULE
======================================== */

document.addEventListener("DOMContentLoaded", function () {
  initDataTables();
});

/* ========================================
   INIT DATATABLES
======================================== */

function initDataTables() {
  if (typeof $.fn.DataTable === "undefined") return;

  const tables = document.querySelectorAll(".datatable");

  tables.forEach((table) => {
    // Hindari double initialization
    if ($.fn.DataTable.isDataTable(table)) {
      $(table).DataTable().destroy();
    }

    $(table).DataTable({
      responsive: false,

      autoWidth: false,

      processing: true,

      pageLength: 10,

      lengthMenu: [
        [10, 25, 50, 100],
        [10, 25, 50, 100],
      ],

      language: {
        url: "//cdn.datatables.net/plug-ins/1.13.4/i18n/id.json",
      },

      columnDefs: [
        {
          targets: "no-sort",
          orderable: false,
        },
      ],

      drawCallback: function () {
        rebindModalButtons();
      },
    });
  });
}

/* ========================================
   REBIND MODAL BUTTON
======================================== */

function rebindModalButtons() {
  const modalButtons = document.querySelectorAll('[data-bs-toggle="modal"]');

  modalButtons.forEach((button) => {
    button.addEventListener("click", function () {
      const target = this.getAttribute("data-bs-target");

      const modalElement = document.querySelector(target);

      if (!modalElement) return;

      const modal = new bootstrap.Modal(modalElement);

      modal.show();
    });
  });
}

/* ========================================
   RELOAD DATATABLE
======================================== */

function reloadDataTable(selector) {
  const table = $(selector).DataTable();

  if (table) {
    table.ajax.reload(null, false);
  }
}

/* ========================================
   DESTROY DATATABLE
======================================== */

function destroyDataTable(selector) {
  if ($.fn.DataTable.isDataTable(selector)) {
    $(selector).DataTable().destroy();
  }
}
