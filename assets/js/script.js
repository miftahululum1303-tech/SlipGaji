<?php
header("Content-type: application/javascript");
?>

$(document).ready(function() {
    // Tooltip Initialization
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });

    // Otomatis menutup sidebar di layar mobile saat menu diklik
    if ($(window).width() < 768) {
        $('.nav-link:not(.dropdown-toggle)').click(function() {
            $('#sidebar').removeClass('active');
        });
    }

    // Fungsi Global Notifikasi (SweetAlert-ready jika nanti ditambahkan)
    window.showToast = function(message, type = 'success') {
        console.log("Notification: " + message);
        // Implementasi toast bootstrap bisa diletakkan di sini
    };
});