import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

/*/ General loader/*/
let loader = document.querySelector('#global-loader')

// Loader tonen
function showLoader() {
    loader.style.display = 'flex';
}

// Loader verbergen
function hideLoader() {
    loader.style.display = 'none';
}

document.addEventListener('DOMContentLoaded', function () {
    // loader verbergen na Livewire updates
    window.Livewire && Livewire.hook('message.processed', () => {
        hideLoader();
    });

    // Loader bij paginawissel
    window.addEventListener('beforeunload', function () {
        showLoader();
    });
});