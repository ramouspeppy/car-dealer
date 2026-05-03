import Isotope from "isotope-layout";
import imagesLoaded from "imagesloaded";

export function autoInitIsotope() {
    document
        .querySelectorAll(".isotope-layout")
        .forEach(function (isotopeItem) {
            const layout = isotopeItem.getAttribute("data-layout") ?? "masonry";
            const filter =
                isotopeItem.getAttribute("data-default-filter") ?? "*";
            const sort =
                isotopeItem.getAttribute("data-sort") ?? "original-order";
            const container = isotopeItem.querySelector(".isotope-container");

            if (!container) return;

            let iso;

            imagesLoaded(container, function () {
                iso = new Isotope(container, {
                    itemSelector: ".isotope-item",
                    layoutMode: layout,
                    filter: filter,
                    sortBy: sort,
                });

                // Recalculate setelah AOS animasi selesai
                document.addEventListener("aos:in", () => iso.layout());
            });

            // 🔥 Loop filterBtn yang hilang
            isotopeItem
                .querySelectorAll(".isotope-filters li") // ✅ ini yang hilang
                .forEach(function (filterBtn) {
                    // ✅ filterBtn didefinisikan di sini
                    filterBtn.addEventListener("click", function () {
                        isotopeItem
                            .querySelectorAll(".isotope-filters .filter-active")
                            .forEach((el) =>
                                el.classList.remove("filter-active"),
                            );

                        this.classList.add("filter-active");

                        iso.arrange({
                            filter: this.getAttribute("data-filter"),
                        });

                        // 🔥 Tunggu animasi selesai baru layout ulang
                        iso.once("arrangeComplete", function () {
                            iso.layout();
                            setTimeout(() => {
                                if (typeof AOS !== "undefined")
                                    AOS.refreshHard();
                            }, 400);
                        });

                        iso.layout();

                        // Refresh AOS setelah layout berubah
                        setTimeout(() => {
                            if (typeof AOS !== "undefined") AOS.refreshHard();
                        }, 400);
                    });
                });
        });
}
