$(function(){

    const $clasificacion_id = $("#clasificacion_id"), $count_postulantes = $("#count_postulantes"),
    $count_evaluados = $("#count_evaluados"), $count_seleccionados = $("#count_seleccionados"), $count_aceptados = $("#count_aceptados"), $count_descartados = $("#count_descartados");
    $('#modalAdvertencia').modal('show');
    
    $clasificacion_id.on("change", function(){
        const formData = new FormData();
        formData.append("_token", $("input[name=_token]").val());
        formData.append("alumno_id", POSTULANTE);
        formData.append("aviso_id", AVISO);
        formData.append("estado_id", $(this).val());
        actionAjax("/empresa/avisos/alumno/clasificar", formData, "POST", function(data){
            if(data.Success){
                $count_postulantes.text(data.postulados);
                $count_evaluados.text(data.evaluados);
                $count_seleccionados.text(data.seleccionados);
                $count_aceptados.text(data.aceptados);
                $count_descartados.text(data.descartados);
                toastr.success(data.Message ? data.Message : "Guardado Correctamente", data.Title ? data.Title : "Éxito");
            }else{
                toastr.error(data.Message ? data.Message : "Algo Salio mal", data.Title ? data.Title : "Error");
            }
        });

    });

});
