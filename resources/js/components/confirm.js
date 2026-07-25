export async function confirmAction(
    title,
    text,
    confirmButtonText = 'Yes'
) {

    const result = await Swal.fire({

        title,

        text,

        icon: 'warning',

        showCancelButton: true,

        confirmButtonColor: '#dc3545',

        cancelButtonColor: '#6c757d',

        confirmButtonText,

        cancelButtonText: 'Cancel',

    });

    return result.isConfirmed;

}