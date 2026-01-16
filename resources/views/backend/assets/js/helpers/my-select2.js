import $ from 'jquery';

export async function initSelect2(selector, config = {}) {
    await import('select2'); // lazy load
    const el = $(selector);
    if (!el.length) return;

    el.select2(config);
}
