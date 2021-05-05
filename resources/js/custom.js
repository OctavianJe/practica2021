//CUSTOM JS
$('#edit-modal').on('shown.bs.modal', function (event) {
    let button = $(event.relatedTarget) // Button that triggered the modal
    let user = button.data('user');

    let modal = $(this);

    modal.find('#editId').val(user.id);
    modal.find('#editName').text(user.name);
    modal.find('#editRole').val(user.role);
})