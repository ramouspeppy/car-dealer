import $ from "jquery";
import Swal from "sweetalert2";

/* ================================
   Card Progress Controller
   ================================ */
export function cardProgress(card) {
    const $card = $(card);
    $card.addClass("card-progress");
}

export function cardProgressDismiss(card, callback) {
    const $card = $(card);
    $card.removeClass("card-progress");
    $card.find(".card-progress-dismiss").remove();
    if (callback) callback.call(this, $card);
}

/* ================================
   SweetAlert - Glass Style
   ================================ */
export function swalGlass({
    title = "",
    text = "",
    html = "",
    icon = "info",
    confirmButtonText = "Oke",
    cancelButtonText = "Batal",
    showCancelButton = false,
} = {}) {
    return Swal.fire({
        title,
        text,
        html,
        icon,
        confirmButtonText,
        cancelButtonText,
        showCancelButton,
        reverseButtons: true,
        customClass: {
            popup: "swal-glass-popup",
            title: "swal-glass-title",
            content: "swal-glass-text",
            cancelButton: "swal-glass-btn-cancel",
            confirmButton: "swal-glass-btn-confirm",
            icon: "swal-glass-icon",
        },
        buttonsStyling: false,
    });
}
