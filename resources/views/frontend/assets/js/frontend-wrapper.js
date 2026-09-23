import "bootstrap5/dist/js/bootstrap.bundle.min.js";
import { initAOS } from "./my-aos";
import { initGlightbox } from "./my-glightbox";
import { initSwipers } from "./my-swiper";
import { autoInitTyped } from "./my-typed";
import { autoInitPureCounter } from "./my-purecounter";
import { autoInitIsotope } from "./my-isotope";
import { initDatepickers } from "./my-mcdatepicker";
import { cardProgress, cardProgressDismiss } from "./my-card-progress";
import { swalGlass } from "./my-swal";
import { autoInit, resetAllSelects, initSelect2InModal } from "./auto-init"; // 🔥 tambah import
import Masonry from "masonry-layout";
import imagesLoaded from "imagesloaded";

document.addEventListener("DOMContentLoaded", () => {
    initAOS();
    initGlightbox();
    initSwipers();
    autoInitTyped();
    autoInitPureCounter();
    autoInitIsotope();
    initDatepickers();
    autoInit();

    window.resetAllSelects = resetAllSelects;
    // window.Masonry = Masonry;
    window.imagesLoaded = imagesLoaded;

    // 🔥 Init Select2 di dalam modal saat modal tampil
    document.querySelectorAll(".modal").forEach((modalEl) => {
        modalEl.addEventListener("shown.bs.modal", function () {
            initSelect2InModal(this);
        });
    });
});

require("./my-utils.js");
require("./main.js");
