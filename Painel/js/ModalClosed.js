$('#modalMessage').on('hidden.bs.modal', function (e) {
    $("#tpModal").removeClass('modal-danger')
    $("#btTpModal").removeClass('btn-outline-danger')
    $("#tpModal").removeClass('modal-warning')
    $("#btTpModal").removeClass('btn-outline-warning')
    $("#tpModal").removeClass('modal-success')
    $("#btTpModal").removeClass('btn-outline-success')
    $("#messageModal").text('')

})

$('#btTpModal').on('click', function () {
    $("#tpModal").removeClass('modal-danger')
    $("#btTpModal").removeClass('btn-outline-danger')
    $("#tpModal").removeClass('modal-warning')
    $("#btTpModal").removeClass('btn-outline-warning')
    $("#tpModal").removeClass('modal-success')
    $("#btTpModal").removeClass('btn-outline-success')
    $("#messageModal").text('')
})