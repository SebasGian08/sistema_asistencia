var OnSuccessChangePassword, OnFailureChangePassword;
$(function(){

    const $modal = $("#modalMantenimientoChangePassword"), $form = $("form#changePassword");

    OnSuccessChangePassword = (data) => onSuccessForm(data, $form, $modal);
    OnFailureChangePassword = () => onFailureForm();
});
