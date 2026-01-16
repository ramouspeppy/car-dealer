export async function autoInitIsotope() {
    const isotopeLayouts = document.querySelectorAll('.isotope-layout');
    if (!isotopeLayouts.length) return;

    const {
        default: Isotope
    } = await import('isotope-layout');
    const imagesLoaded = (await import('imagesloaded')).default;

    isotopeLayouts.forEach((layoutEl) => {
        let layoutMode = layoutEl.getAttribute('data-layout') ?? 'masonry';
        let filter = layoutEl.getAttribute('data-default-filter') ?? '*';
        let sort = layoutEl.getAttribute('data-sort') ?? 'original-order';

        let initIsotope;

        imagesLoaded(layoutEl.querySelector('.isotope-container'), function () {
            initIsotope = new Isotope(layoutEl.querySelector('.isotope-container'), {
                itemSelector: '.isotope-item',
                layoutMode: layoutMode,
                filter: filter,
                sortBy: sort
            });
        });

        layoutEl.querySelectorAll('.isotope-filters li').forEach((filterEl) => {
            filterEl.addEventListener('click', function () {
                layoutEl.querySelector('.isotope-filters .filter-active').classList.remove('filter-active');
                this.classList.add('filter-active');
                initIsotope.arrange({
                    filter: this.getAttribute('data-filter')
                });
            });
        });
    });

    console.info('✅ Isotope initialized for ${isotopeLayouts.length} layout(s)');
}
