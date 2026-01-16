export async function autoInitPureCounter() {
    const counterEls = document.querySelectorAll('.purecounter');
    console.log('[PureCounter] found', counterEls.length, 'element(s)');
    if (!counterEls.length) return;

    const { default: PureCounter } = await import('@srexi/purecounterjs');
    new PureCounter();

    console.info(`✅ PureCounter initialized`);
}