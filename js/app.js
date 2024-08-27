document.addEventListener('DOMContentLoaded', () => {
    AOS.init();
    window.addEventListener('scroll', function() {
        const mainNavigation = document.querySelector('.main-navigation');
        const scrolled = window.scrollY;
        const header = document.querySelector('header');

        // Ajuster la position de l'image de fond pour l'effet de parallaxe
        header.style.backgroundPositionY = -(scrolled * 0.5) + 'px';

        // Ajuster l'opacité pour l'effet de fondu
        const maxScroll = 600; // Ajustez cette valeur selon vos besoins
        const opacity = 1 - Math.min((scrolled / 1.5) / maxScroll, 1);
        header.style.opacity = opacity;

        // Ajouter ou supprimer la classe sticky_menu
        if (scrolled > 150) {
            mainNavigation.classList.add('sticky_menu');
        } else {
            mainNavigation.classList.remove('sticky_menu');
        }
    });
});