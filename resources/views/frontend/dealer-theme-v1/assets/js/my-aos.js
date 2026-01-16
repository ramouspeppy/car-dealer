import AOS from 'aos';

export function initAOS(config = {}) {
    AOS.init({
        duration: 600,
        once: true,
        easing: 'ease-in-out',
        mirror: false,
    });
    console.info('AOS initialized');
}
