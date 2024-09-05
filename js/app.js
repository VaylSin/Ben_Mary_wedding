document.addEventListener('DOMContentLoaded', () => {
    // Initialiser AOS
    AOS.init();

    window.addEventListener('scroll', function () {
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
    const presenceField = document.getElementById('acf-field_66d08675f56b6');
    const messageField = document.getElementById('acf-field_66d07b83e9b18');
    const validateMailField = document.querySelector('.acf-field--validate-email');
    validateMailField.classList.add('d-none');

    if (presenceField && messageField) {
        const toggleFields = () => {
            let nextElement = presenceField.closest('.acf-field').nextElementSibling;
            while (nextElement) {
                if (nextElement.contains(messageField)) {
                    nextElement.style.display = 'block'; // Afficher le champ de commentaire message
                } else {
                    nextElement.style.display = presenceField.value === 'non' ? 'none' : 'block'; // Masquer ou afficher les autres éléments
                }
                nextElement = nextElement.nextElementSibling;
            }
        };
        presenceField.addEventListener('change', toggleFields);

        // Initialiser l'état en fonction de la valeur actuelle
        toggleFields();
    } else {
        if (!presenceField) console.error('Presence field not found');
        if (!messageField) console.error('Message field not found');
    }


});