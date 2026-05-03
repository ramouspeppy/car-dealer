import $ from "jquery";

let selectricLoaded = false;

export async function initSelectric(elements, config = {}) {
    if (!selectricLoaded) {
        await import("jquery-selectric");
        selectricLoaded = true;
    }

    const el = $(elements);
    if (!el.length) return;

    el.each(function () {
        if ($(this).data("selectric")) {
            $(this).selectric("destroy");
        }
        $(this).selectric(config);
    });

    console.info("✅ Selectric initialized");
}

// 🔥 TAMBAH INI
export function resetSelectric(elements) {
    const el = $(elements);
    if (!el.length) return;

    el.each(function () {
        $(this).prop("selectedIndex", 0);
        if ($(this).data("selectric")) {
            $(this).selectric("refresh");
        }
    });
}
