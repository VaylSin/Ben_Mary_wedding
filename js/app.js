document.addEventListener('DOMContentLoaded', () => {
    AOS.init();
     window.addEventListener('scroll', function() {
         var mainNavigation = document.querySelector('.main-navigation');
         if (window.scrollY > 150) {
            mainNavigation.classList.add('sticky_menu');
        } else {
            mainNavigation.classList.remove('sticky_menu');
        }
    });
});

