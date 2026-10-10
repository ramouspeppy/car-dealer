import { Flip } from "gsap/Flip";
import gsap from "gsap";
import GLightbox from "glightbox";
import Swal from "sweetalert2";
import $ from "jquery";

gsap.registerPlugin(Flip);
window.swal = Swal;

export function initPhotoDeliveryPage() {
    let photoDeliveryLightbox = GLightbox({
        selector: ".photo-delivery-lightbox",
        loop: true,
        touchNavigation: true,
    });

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="_token"]').attr("content"),
        },
        data: {
            _token: $('meta[name="_token"]').attr("content"),
        },
    });

    $("#chkCheckAll").click(function () {
        $(".checkbox-delivery").prop("checked", $(this).prop("checked"));
    });

    $("#deleteAll").on("click", function (e) {
        e.preventDefault();

        if ($("input:checkbox[name=idDeliveries]:checked").length) {
            swal.fire({
                title: "Are you sure?",
                text: "Move these data to the trash!",
                icon: "question",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel!",
                reverseButtons: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    $.cardProgress("#card-photo-delivery", { dismiss: false });
                    deleteDataAll();
                } else if (result.dismiss === swal.DismissReason.cancel) {
                    swal.fire("Cancelled", "Your data is safe :)", "info");
                }
            });
        } else {
            swal.fire({
                icon: "error",
                title: "Oops...",
                text: "At least choose one data..!!",
            });
        }
    });

    function deleteDataAll() {
        const allIds = [];

        $("input:checkbox[name=idDeliveries]:checked").each(function () {
            allIds.push($(this).val());
        });

        $.ajax({
            type: "POST",
            url: window.photoDeliveryDeleteUrl,
            data: {
                _method: "DELETE",
                data: allIds,
            },
            success: function (data) {
                $.cardProgressDismiss("#card-photo-delivery");

                if (data.msg) {
                    swal.fire({
                        title: "Info!",
                        html: data.msg,
                        icon: "info",
                    });
                    return;
                }

                const state = Flip.getState(".photo-delivery-container");
                photoDeliveryLightbox.close();

                $(".checkbox-delivery:checked").each(function () {
                    $(this).closest(".photo-delivery-container").remove();
                });

                $("#chkCheckAll").prop("checked", false);

                const gallery = document.querySelector("#photo-gallery");
                if (!gallery.querySelector(".photo-delivery-container")) {
                    const emptyState = document.createElement("div");
                    emptyState.className = "col-12 photo-delivery-empty";
                    emptyState.innerHTML =
                        '<i class="fas fa-images"></i><div>Belum ada foto delivery.</div>';
                    gallery.appendChild(emptyState);
                }

                Flip.from(state, {
                    duration: 0.5,
                    ease: "power1.inOut",
                    stagger: 0.05,
                    onComplete: () => photoDeliveryLightbox.reload(),
                });
            },
            error: function () {
                swal.fire({
                    title: "Error!",
                    html: "Gagal menghapus data. Silakan coba lagi.",
                    icon: "error",
                });
            },
        });
    }
}
