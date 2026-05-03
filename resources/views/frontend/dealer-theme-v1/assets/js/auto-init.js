import $ from "jquery";
import { initSelect2, resetSelect2 } from "./my-select2"; // 🔥 static
import { initSelectric, resetSelectric } from "./my-selectric"; // 🔥 static

let _resetSelectric = null;
let _resetSelect2 = null;

export function autoInit() {
    const select2Els = $(".select2").not("[data-in-modal]");
    const select2Tags = $(".select2-tags").not("[data-in-modal]");
    const selectricEls = $(".selectric");

    if (select2Els.length || select2Tags.length) {
        _resetSelect2 = resetSelect2;

        const baseConfig = (el) => ({
            placeholder: $(el).data("placeholder") || "",
        });

        select2Els.each(function () {
            initSelect2(this, baseConfig(this));
        });

        select2Tags.each(function () {
            initSelect2(this, {
                ...baseConfig(this),
                tags: true,
                tokenSeparators: [","],
                allowClear: true,
            });
        });
    }

    if (selectricEls.length) {
        _resetSelectric = resetSelectric;
        initSelectric(selectricEls, {});
    }
}

export function initSelect2InModal(modalEl) {
    const modal$ = $(modalEl);

    _resetSelect2 = resetSelect2;

    modal$.find("select.select2").each(function () {
        initSelect2(this, {
            placeholder: $(this).data("placeholder") || "",
            dropdownParent: modal$,
        });
    });

    modal$.find("select.select2-tags").each(function () {
        initSelect2(this, {
            placeholder: $(this).data("placeholder") || "",
            dropdownParent: modal$,
            tags: true,
            tokenSeparators: [","],
            allowClear: true,
        });
    });
}

export function resetAllSelects(formEl) {
    const form = $(formEl);

    if (_resetSelect2) {
        form.find("select.select2, select.select2-tags").each(function () {
            _resetSelect2(this);
        });
    }

    if (_resetSelectric) {
        form.find("select.selectric").each(function () {
            _resetSelectric(this);
        });
    }
}
