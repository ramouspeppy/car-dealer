import $ from "jquery";
import Swal from "sweetalert2";

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
// Floating WA Scroll Animation
const floatingWa = document.querySelector(".floating-wa");
let lastScrollY = window.scrollY;
let scrollTimer = null;

window.addEventListener("scroll", function () {
    const currentScrollY = window.scrollY;

    // Matikan heartbeat saat transisi
    floatingWa.style.animation = "none";

    if (currentScrollY > lastScrollY) {
        floatingWa.classList.add("scrolled");
    } else {
        floatingWa.classList.remove("scrolled");
    }

    lastScrollY = currentScrollY;

    // Kembalikan heartbeat setelah scroll berhenti
    clearTimeout(scrollTimer);
    scrollTimer = setTimeout(() => {
        if (!floatingWa.matches(":hover")) {
            floatingWa.style.animation = "";
        }
    }, 800);
});

// show tombol Modal Konsultasi
$("#btn-konsultasi").on("click", function () {
    $("#consultationModal").modal("show");
});
(function () {
    const STORAGE_KEY = "consult_modal_last_closed";
    const COOLDOWN_MS = 10 * 60 * 1000; // 10 menit
    const SHOW_DELAY_MS = 5000; // 5 detik

    let countdownTimer = null; // 🔥 simpan referensi timer

    function canShowModal() {
        const lastClosed = localStorage.getItem(STORAGE_KEY);
        if (!lastClosed) return true;
        const diff = Date.now() - parseInt(lastClosed);
        return diff > COOLDOWN_MS;
    }

    function startCooldown() {
        // 🔥 Simpan waktu tutup & jadwalkan tampil ulang
        localStorage.setItem(STORAGE_KEY, Date.now());

        // Bersihkan timer sebelumnya jika ada
        if (countdownTimer) clearTimeout(countdownTimer);

        // Jadwalkan tampil ulang setelah cooldown habis
        countdownTimer = setTimeout(() => {
            if (canShowModal()) {
                const modalEl = document.getElementById("consultationModal");
                if (!modalEl) return;
                bootstrap.Modal.getOrCreateInstance(modalEl).show();
            }
        }, COOLDOWN_MS);
    }

    function initModal() {
        const modalEl = document.getElementById("consultationModal");
        if (!modalEl) return;

        // 🔥 Gunakan static backdrop agar klik luar tidak langsung dismiss
        const modal = new bootstrap.Modal(modalEl, {
            backdrop: "static", // klik luar tidak tutup modal
            keyboard: false, // ESC tidak tutup modal
        });

        // 🔥 Tangani klik backdrop manual — jalankan cooldown
        modalEl.addEventListener("mousedown", function (e) {
            if (e.target === modalEl) {
                // User klik di luar area modal content
                modal.hide();
                startCooldown();
            }
        });

        // 🔥 Tangani btn-close — jalankan cooldown yang sama
        modalEl
            .querySelectorAll('[data-bs-dismiss="modal"], .btn-close')
            .forEach((btn) => {
                btn.addEventListener("click", function () {
                    startCooldown();
                });
            });

        // Fix ARIA error saat modal tertutup
        modalEl.addEventListener("hidden.bs.modal", function () {
            document.activeElement.blur();
        });

        // Tampilkan jika boleh
        if (canShowModal()) {
            setTimeout(() => {
                modal.show();
            }, SHOW_DELAY_MS);
        }
    }

    document.addEventListener("DOMContentLoaded", initModal);
})();

// Render bintang rating
document.addEventListener("DOMContentLoaded", () => {
    const starDivs = document.querySelectorAll(".stars");

    starDivs.forEach((starsContainer) => {
        const rating = parseFloat(starsContainer.dataset.value) || 0; // ambil value dari DB
        starsContainer.innerHTML = ""; // reset isi div

        // loop 1-5 bintang
        for (let i = 1; i <= 5; i++) {
            let star = document.createElement("i");
            star.classList.add("bi");

            if (i <= Math.floor(rating)) {
                // bintang penuh
                star.classList.add("bi-star-fill", "active");
            } else if (i - rating <= 0.5 && rating % 1 !== 0) {
                // bintang setengah
                star.classList.add("bi-star-half", "active");
            } else {
                // bintang kosong
                star.classList.add("bi-star");
            }

            starsContainer.appendChild(star);
        }
    });
});

//
