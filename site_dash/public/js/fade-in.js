function observeElements() {
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
            }
        });
    }, {
        threshold: 0.1
    });

    document.querySelectorAll('.fade-in').forEach(element => {
        observer.observe(element);
    });
}
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.hero-section .fade-in').forEach(el => {
        el.classList.add('visible');
    });
    observeElements();
});
window.addEventListener('scroll', () => {
    observeElements();
}, { passive: true });