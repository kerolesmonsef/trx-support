$(document).ready(function () {
    const max_chars = 100;
    const descriptionObject = $(".complain-description");

    $(".description-char-count").text(max_chars - descriptionObject.val().length);
    descriptionObject.on("input", function () {
        const current_allowed_length = max_chars - $(this).val().length;
        $(".description-char-count").text(current_allowed_length);
        if (current_allowed_length <= 1) {
            $(this).val($(this).val().slice(0, max_chars));
        }
    });
});
$(".copy").click(function () {
    let code = $(this).parent().find(".code").text();
    navigator.clipboard.writeText(code);
    Swal.fire({
        toast: true,
        icon: 'success',
        title: 'تم النسخ بنجاح',
        animation: false,
        position: 'bottom-left',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true
    })
});

$('a').click(function (event) {
    event.preventDefault(); // Prevent the default behavior of the <a> tag

    // Get the URL from the <a> tag's href attribute
    const url = $(this).attr('href');

    Swal.fire({
        title: 'هل انت متاكد?',
        text: 'سيتم نقلك الى صفحة ثاني هل ترغب في متابع',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'نعم!',
        cancelButtonText: 'لا الغاء!',
        reverseButtons: true
    }).then((result) => {
        // If user confirms, proceed with the action
        if (result.isConfirmed) {
            window.location.href = url;
        }
    });

});
