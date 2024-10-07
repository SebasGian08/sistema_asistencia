$(function () {
    const $table = $("#tableEmpleado");

    var $datatableEmpleado = $table.DataTable({
        columnDefs: [
            {
                defaultContent: "-",
                targets: "_all",
            },
        ],
        stripeClasses: ["odd-row", "even-row"],
        lengthChange: true,
        lengthMenu: [
            [10, 10, 20, 50, -1],
            [10, 10, 20, 50, "Todo"],
        ],
        info: false,
        ajax: {
            url: "/auth/empleado/list_all",
            data: function (s) {
                // Aquí puedes añadir parámetros adicionales si es necesario
            },
        },
        columns: [
            {
                title: "N°",
                data: null,
                render: function (data, type, row, meta) {
                    return meta.row + 1; // Número de fila
                },
            },
            { title: "Nombre", data: "nombre", class: "text-center" },
            { title: "Apellido", data: "apellido", class: "text-center" },
            { title: "DNI", data: "dni", class: "text-center" },
            { title: "Teléfono", data: "tel", class: "text-center" },
            { title: "Email", data: "email", class: "text-center" },
            { title: "Cargo", data: "cargo.nombre", class: "text-center" }, // Mostrar el nombre del cargo
            {
                title: "Estado",
                data: "estado",
                render: function (data) {
                    return data === 1 || data === "1"
                        ? "<span class='estado-activo'>Activo</span>"
                        : "<span class='estado-inactivo'>Inactivo</span>";
                },
            },
            {
                data: null,
                render: function (data) {
                    return (
                        '<div class="btn-group">' +
                        '<a href="javascript:void(0)" class="btn-update btn btn-primary" idDato="' +
                        data.id +
                        '" style="margin-right: 5px;"><i class="fa fa-edit"></i></a>' +
                        '<a href="javascript:void(0)" class="btn-delete btn btn-danger" idDato="' +
                        data.id +
                        '" style="margin-right: 5px;"><i class="fa fa-trash"></i></a>' +
                        '<a href="javascript:void(0)" class="btn-generate-barcode btn btn-info" idDato="' +
                        data.id +
                        '"><i class="fa fa-barcode"></i></a>' +
                        "</div>"
                    );
                },
            },
        ],
    });

    $table.on("click", ".btn-generate-barcode", function () {
        var id = $(this).attr("idDato");
        var empleado = $datatableEmpleado.row($(this).parents("tr")).data();

        // Mostrar detalles del empleado
        $("#employeeDetails").html(`
        <p><strong>Nombre:</strong> ${empleado.nombre} ${empleado.apellido}</p>
        <p><strong>DNI:</strong> ${empleado.dni}</p>
    `);

        // Generar el código de barras con el DNI del empleado
        var barcodeValue = empleado.dni; // O el campo que desees usar
        JsBarcode(".barcode", barcodeValue, {
            height: 100,
            displayValue: true,
        });

        // Mostrar el modal
        $("#barcodeModal").modal("show");
    });

    $(document).on("click", "#printBarcodeBtn", function () {
        // Obtener solo el contenido del código de barras
        var printContent = $("#barcodeModal").find(".barcode")[0].outerHTML; // Solo el SVG del código de barras

        // Abrir una nueva ventana para imprimir
        var win = window.open("", "", "height=400,width=600");

        win.document.write(
            "<html><head><title>Imprimir Código de Barras</title>"
        );
        win.document.write("<style>");
        win.document.write(
            "body { margin: 0; display: flex; justify-content: center; align-items: center; height: 100vh; }"
        ); // Centrar contenido
        win.document.write(".barcode { width: 100%; height: auto; }"); // Asegurar que el SVG ocupe el 100% del ancho
        win.document.write("</style>");
        win.document.write("</head><body>");
        win.document.write(printContent); // Solo imprime el contenido del código de barras
        win.document.write("</body></html>");

        win.document.close();
        win.print();

        // Cierra el modal después de imprimir
        $("#barcodeModal").modal("hide");
    });

    /* Para abrir modal y editar */
    $table.on("click", ".btn-update", function () {
        const id = $datatableEmpleado.row($(this).parents("tr")).data().id;
        invocarModalView(id);
    });

    function invocarModalView(id) {
        invocarModal(
            `/auth/empleado/partialView/${id ? id : 0}`,
            function ($modal) {
                if ($modal.attr("data-reload") === "true")
                    $datatableEmpleado.ajax.reload(null, false);
            }
        );
    }

    $table.on("click", ".btn-delete", function () {
        const id = $(this).attr("idDato");
        const formData = new FormData();
        formData.append("_token", $("input[name=_token]").val());
        formData.append("id", id);
        confirmAjax(
            `/auth/empleado/delete`,
            formData,
            "POST",
            null,
            null,
            function () {
                $datatableEmpleado.ajax.reload(null, false);
            }
        );
    });
});
