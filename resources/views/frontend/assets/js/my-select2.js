import $ from "jquery";
import "select2"; // 🔥 static import, tidak jadi chunk terpisah

export function initSelect2(element, config = {}) {
    const el = $(element);
    if (!el.length) return;

    if (el.data("select2")) {
        el.select2("destroy");
    }

    el.select2(config);
    console.info("✅ Select2 initialized");
}

export function resetSelect2(element) {
    const el = $(element);
    if (!el.length) return;

    if (el.data("select2")) {
        el.val(null).trigger("change");
    }
}
