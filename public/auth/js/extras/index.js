var $dataTableExtras, $dataTable;
$(function () {
    const $table = $("#tableExtras");

    $dataTableExtras = $table.DataTable({
        stripeClasses: ["odd-row", "even-row"],
        lengthChange: true,
        lengthMenu: [
            [50, 100, 200, 500, -1],
            [50, 100, 200, 500, "Todo"],
        ],
        info: false,
        buttons: [],
        ajax: {
            url: "/auth/extras/list_all",
        },
        columns: [
            { title: "ID", data: "id", className: "text-center" },
            { title: "DNI ", data: "dni" },
            {
                title: "Nombres y Apellidos",
                data: "empleado", // Aquí estamos pasando el objeto empleado
                className: "text-center",
                render: function (data) {
                    return data ? `${data.nombre} ${data.apellido}` : "-";
                },
            },
            { title: "Horas ", data: "horas" },
            { title: "Minutos ", data: "minutos" },
            /* { title: "Documento ", data: "documento" }, */
            {
                title: "Estado",
                data: "estado",
                className: "text-center",
                render: function (data) {
                    let statusText;
                    let statusClass;

                    switch (data) {
                        case 0:
                            statusText = "Pendiente";
                            statusClass = "badge badge-warning"; // Color amarillo
                            break;
                        case 1:
                            statusText = "Aprobada";
                            statusClass = "badge badge-success"; // Color verde
                            break;
                        case 2:
                            statusText = "Rechazado";
                            statusClass = "badge badge-danger"; // Color rojo
                            break;
                        default:
                            statusText = "Desconocido";
                            statusClass = "badge badge-secondary"; // Color gris
                            break;
                    }

                    return `<span class="${statusClass}">${statusText}</span>`;
                },
            },
            { title: "Fecha ", data: "created_at" },

            {
                data: null,
                defaultContent:
                    "<button type='button' class='btn btn-secondary btn-xs btn-update' data-toggle='tooltip' title='Actualizar'><i class='fa fa-pencil'></i></button>",
                orderable: false,
                searchable: false,
                width: "26px",
            },
            {
                data: null,
                defaultContent:
                    "<button type='button' class='btn btn-danger btn-xs btn-delete' data-toggle='tooltip' title='Eliminar'><i class='fa fa-trash'></i></button>",
                orderable: false,
                searchable: false,
                width: "26px",
            },
        ],
    });

    $table.on("click", ".btn-update", function () {
        const id = $dataTableExtras.row($(this).parents("tr")).data().id;
        invocarModalView(id);
    });

    $table.on("click", ".btn-delete", function () {
        const id = $dataTableExtras.row($(this).parents("tr")).data().id;
        const formData = new FormData();
        formData.append("_token", $("input[name=_token]").val());
        formData.append("id", id);
        confirmAjax(
            `/auth/extras/delete`,
            formData,
            "POST",
            null,
            null,
            function () {
                $dataTableCargo.ajax.reload(null, false);
            }
        );
    });

   /*  $("#modalRegistrarCargo").on("click", function () {
        invocarModalView();
    }); */

    function invocarModalView(id) {
        invocarModal(
            `/auth/extras/partialView/${id ? id : 0}`,
            function ($modal) {
                if ($modal.attr("data-reload") === "true")
                    $dataTableExtras.ajax.reload(null, false);
            }
        );
    }
});
