import $ from "jquery";

export function autoInit() {
    // --- Select2 ---
    const select2Els = $(".select2");
    if (select2Els.length) {
        import("./my-select2").then(({ initSelect2 }) => {
            select2Els.each(function () {
                initSelect2(this, {
                    placeholder: $(this).data("placeholder") || "",
                });
            });
        });
    }

    // --- Select2 with Tags ---
    const select2Tags = $(".select2-tags");
    if (select2Tags.length) {
        import("./my-select2").then(({ initSelect2 }) => {
            select2Tags.each(function () {
                initSelect2(this, {
                    tags: true,
                    tokenSeparators: [","],
                    placeholder: $(this).data("placeholder") || "",
                    allowClear: true,
                });
            });
        });
    }

    // --- Selectric ---
    const selectricEls = $(".selectric");
    if (selectricEls.length) {
        import("./my-selectric").then(({ initSelectric }) => {
            selectricEls.each(function () {
                initSelectric(this);
            });
        });
    }

    // --- Tempus Dominus ---
    const tempusEls = document.querySelectorAll("[data-tempus]");
    if (tempusEls.length) {
        import("./my-datetimepicker").then(({ initTempus }) => {
            tempusEls.forEach((el) => {
                const format = el.dataset.format || "YYYY-MM-DD HH:mm:ss";
                initTempus(el, format);
            });
        });
    }

    // --- jQuery Mask ---
    const maskList = {
        ".mask-price": {
            pattern: "000.000.000.000.000",
            reverse: true,
        },
        ".mask-ktp": {
            pattern: "0000000000000000",
        },
        ".mask-hp": {
            pattern: "0000-0000-0000",
        },
        ".mask-phone": {
            pattern: "(000) 0000-0000",
        },
        ".mask-npwp": {
            pattern: "00.000.000.0-000.000",
        },
        ".mask-rekening": {
            pattern: "0000000000000000",
        },
        ".mask-date": {
            pattern: "00-00-0000",
        },
        ".mask-time": {
            pattern: "00:00",
        },
        ".mask-kodepos": {
            pattern: "00000",
        },
        ".mask-sim": {
            pattern: "000000000000",
        },
        ".mask-passport": {
            pattern: "A0000000",
        },
        ".mask-year": {
            pattern: "0000",
        },
    };

    Object.entries(maskList).forEach(([cls, cfg]) => {
        if (document.querySelector(cls)) {
            import("./my-mask").then(({ initMask }) => {
                document.querySelectorAll(cls).forEach((el) => {
                    initMask(el, cfg);
                });
            });
        }
    });
}
