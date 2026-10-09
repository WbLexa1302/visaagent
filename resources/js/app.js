import './bootstrap';
import Alpine from 'alpinejs'; // Impor Alpine
import Swiper from 'swiper';
import { Navigation, Pagination, Autoplay, Mousewheel } from 'swiper/modules';

// Impor CSS Swiper
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';

// Impor AOS
import AOS from 'aos';
import 'aos/dist/aos.css';

// Inisialisasi Alpine
window.Alpine = Alpine;
Alpine.start();

document.addEventListener('DOMContentLoaded', () => {

    // 1. Inisialisasi AOS
    AOS.init({
        duration: 1000,
        once: true,
        offset: 200,
        easing: 'ease-out-back',
    });

    // 2. Inisialisasi Swiper Utama (Horizontal)
    new Swiper('.swiper', {
        modules: [Navigation, Pagination, Autoplay],
        loop: true,
        spaceBetween: 30,
        centeredSlides: true,
        autoplay: {
            delay: 3000,
            disableOnInteraction: false,
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        breakpoints: {
            320: { slidesPerView: 1 },
            768: { slidesPerView: 3 }
        }
    });

    // 3. Inisialisasi Swiper Testimonial (Vertikal)
    new Swiper('.testimonial-swiper', {
        modules: [Navigation, Pagination, Autoplay, Mousewheel],
        direction: 'vertical',
        loop: true,
        speed: 1000,
        autoplay: {
            delay: 4000,
            disableOnInteraction: false,
        },
        navigation: {
            nextEl: '.testi-next',
            prevEl: '.testi-prev',
        },
        mousewheel: true,
    });
});
