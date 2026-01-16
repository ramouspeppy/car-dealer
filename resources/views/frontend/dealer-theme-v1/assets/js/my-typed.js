import Typed from 'typed.js';

export function autoInitTyped() {
    const typedEls = document.querySelectorAll('.typed');
    if (!typedEls.length) return;

    typedEls.forEach((el) => {
        let typedStrings = el.getAttribute('data-typed-items');
        if (!typedStrings) return;

        let stringsArray = typedStrings.split(',').map(item => item.trim());

        new Typed(el, {
            strings: stringsArray,
            loop: true,
            typeSpeed: 100,
            backSpeed: 50,
            backDelay: 2000
        });
    });

    console.info(`✅ Typed.js initialized for ${typedEls.length} element(s)`);
}
