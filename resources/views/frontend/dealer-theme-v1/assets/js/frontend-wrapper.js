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
import { autoInit } from "./auto-init";

document.addEventListener("DOMContentLoaded", () => {
    initAOS();
    initGlightbox();
    initSwipers();
    autoInitTyped();
    autoInitPureCounter();
    autoInitIsotope();
    initDatepickers();
    autoInit();
});

require("./my-utils.js");
require("./main.js");
