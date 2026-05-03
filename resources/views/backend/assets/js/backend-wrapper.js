require("./bootstrap");

// put your lib here =========================

// Star
require("bootstrap-star-rating/js/star-rating");
require("bootstrap-star-rating/themes/krajee-fas/theme");

// Dropzone
window.Dropzone = require("../lib/dropzone/dropzone.min");
// then you need to disabled the autoDiscover behaviour here:

// Datatables
var dt = require("datatables.net");
require("datatables.net-select-bs4");
require("../lib/datatables-checkboxes/dataTables.checkboxes");

// sweetalert2
import Swal from "sweetalert2";
window.swal = Swal;

import Chocolat from "chocolat";
window.chocolat = Chocolat;

// selectric
// require('../lib/selectric/jquery.selectric');

// jasny bootstrap
require("../lib/jasny-bootstrap/js/jasny-bootstrap");



// app js
require("./backendApp/nicescroll");
require("./backendApp/stisla");
require("./backendApp/scripts");

// REFACTOR====================

// codemirror
import $ from "jquery";
import { myCodeMirror } from "./helpers/my-codemirror";
window.$.myCodeMirror = myCodeMirror;

// tinymce
import { myTinyMce, myTinyMceLite } from "./helpers/my-tinymce";
window.$.myTinyMce = myTinyMce;
window.$.myTinyMceLite = myTinyMceLite;

import { autoInit } from "./helpers/auto-init";

document.addEventListener("DOMContentLoaded", () => {
    autoInit();
});

// my js
require("./backend");
