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
    // Loader bij Fetch-aanroepen
    document.querySelectorAll('[data-fetch]').forEach(button => {
        button.addEventListener('click', function () {
            showLoader();

            fetch('/data')
                .then(response => response.text())
                .then(data => {
                    document.getElementById('result').innerHTML = data;
                })
                .catch(error => console.error('Fout:', error))
                .finally(() => {
                    hideLoader();
                });
        });
    });

    // loader verbergen na Livewire updates
    window.Livewire && Livewire.hook('message.processed', () => {
        hideLoader();
    });

    // Loader bij paginawissel
    window.addEventListener('beforeunload', function () {
        showLoader();
    });
});