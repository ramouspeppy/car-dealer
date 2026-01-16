import GLightbox from 'glightbox';

export function initGlightbox(config = {}) {
    const lightbox = GLightbox({
        selector: '.glightbox',
        ...config
    });
    console.info('✅ Glightbox initialized (modular)');
    return lightbox;
}
