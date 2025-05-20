$(document).ready(function () {
    var currentUrl = location.href;

    $('nav a').each(function () {
        if (this.href === currentUrl) {
            $(this).addClass('active');
        }
    });
});

const observer = new IntersectionObserver(entries => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            const imagem = document.querySelector('.decorative-img');
            imagem.style.opacity = 1;
        }
    });
}, {
    threshold: 0.5
});
observer.observe(document.getElementById('start'));

// Aguarde o carregamento completo da página
window.addEventListener('load', function () {
    // Oculta o modal de loading
    const loadingModal = document.getElementById('loadingModal');
    if (loadingModal) {
        loadingModal.style.display = 'none';
    }
});