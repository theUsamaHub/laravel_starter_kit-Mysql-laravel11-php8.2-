import Alpine from 'alpinejs';
import * as bootstrap from 'bootstrap';

// Make Alpine available globally
window.Alpine = Alpine;
Alpine.start();

// Bootstrap Toast auto-dismiss
document.addEventListener('DOMContentLoaded', function () {
    const toastElList = document.querySelectorAll('.toast');
    toastElList.forEach(function (toastEl) {
        const toast = new bootstrap.Toast(toastEl);
        toast.show();
    });

    // Enable Bootstrap tooltips
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    tooltipTriggerList.forEach(function (tooltipTriggerEl) {
        new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Enable Bootstrap popovers
    const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]');
    popoverTriggerList.forEach(function (popoverTriggerEl) {
        new bootstrap.Popover(popoverTriggerEl);
    });
});
