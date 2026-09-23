import Swal from "sweetalert2";

/**
 * SweetAlert dengan style glass custom
 * @param {Object} options
 */
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
window.swalGlass = swalGlass;
