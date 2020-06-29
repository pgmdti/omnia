require('../js/app.css');
require('../js/jquery.mask.js');

var table;
var arraysize;
var responsechart;


$(document).ready(function () {

    $('.js-datepicker').datepicker({
        format: 'dd/mm/yyyy'
    });

    table = $('.datatables').DataTable({
        lengthMenu: [[5, 10, 15, -1], [5, 10, 15, "Tudo"]],
        stateSave: true,
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Portuguese-Brasil.json"
        }
    });

    $('[data-toggle="tooltip"]').tooltip();

    $("#employee_form_duracao").change(function () {
        var x = $(this).val();
        var dateString = $("#employee_form_dataposse").val();
        var dateParts = dateString.split("/");
        var datebegin = new Date(dateParts[2], dateParts[1] - 1, dateParts[0]);

        x = parseInt(x) + parseInt(datebegin.getMonth());

        datebegin.setMonth(x);

        var dateEnd = datebegin.getDate().toString()+"/"+pad(datebegin.getMonth()+1)+"/"+datebegin.getFullYear().toString();
        if(isNaN(x)){
            $("#employee_form_datatermino").val(null);
        }else{
            $("#employee_form_datatermino").val(dateEnd);
        }

    });


    $("#_btn-gera-pdf-employees").on('click', function () {

        var doc = new jsPDF('landscape');
        doc.setFontSize(10);
        doc.setFontStyle('arial');
        var titletext = "LISTAGEM DE SERVIDORES, ESTAGIÁRIOS, CONTRATADOS...";

        doc.text(15,15,titletext);
        var pdfHead = headerRows($("#_table_employees thead tr th"));
        var count = arraysize;
        var pdfBody = [];

        table.rows().iterator('row', function (context, index) {
            var $data = $(this.row(index).node());
            var $columns = $data.find('td');
            var rowBody = {};
            $.each($columns, function (i, item) {
                if(i < count){
                    rowBody[i] = item.innerHTML;
                }
            });
            pdfBody.push(rowBody);
        });

        doc.autoTable({
            head: pdfHead,
            body: pdfBody,
            startY: 20,
            /* apply styling to table body */
            bodyStyles: {
                valign: 'top'
            },
            /* apply global styling */
            styles: {
                cellWidth: 'wrap',
                rowPageBreak: 'auto',
                halign: 'left'
            },
            /* apply styling specific to table columns */
            columnStyles: {
                2: {
                    cellWidth: 'auto'
                },
                3: {
                    cellWidth: 'auto'
                },
                4: {
                    cellWidth: 'auto'
                },
                5: {
                    cellWidth: 'auto'
                }
            }
        });

        doc.save('listagem-de-pessoal.pdf');
    });

    $('.btn').click(function(e){
        preloadActive();
        setInterval(function () {
            preloadDeActive();
        }, 1000);
    });

    $('.dropdown-menu li a').click(function(e){
        preloadActive();
        setInterval(function () {
            preloadDeActive();
        }, 1000);
    });

});


function preloadActive(){
    $("#modalajaxloader").removeClass('hidden');
};

function preloadDeActive(){
    $("#modalajaxloader").addClass('hidden');
};

function headerRows(table) {

    var header = [];
    var row = {};
    var index = 0;
    $(table).each(function () {
        if($(this).text() != '#'){
            row[index] = $(this).text();
            index++;
        }
    });
    arraysize = index;
    header.push(row);

    return header;
};


function pad(s) { return (s < 10) ? '0' + s : s; }


$("#esp_form_filter").on("submit", function (e) {

    e.preventDefault();

    $.ajax({
        type: "POST",
        url: $(this).attr("action"),
        dataType: "json",
        data: $(this).serialize(),
        success: function (response) {
            preloadDeActive();
            responsechart = response;
            $("#div_partial").html(response);
        }
    });

});

$(window).resize(function () {
    $("#div_partial").html(responsechart);
});

$("#esp_type_filter").change(function () {
    var filtertype = $(this).val();
    var urlpath = $(this).attr('base-url');
    var formValues = $("#esp_value_filter");
    formValues.addClass("loading");

    if(filtertype != 9){
        $.ajax({
            url: urlpath,
            type: "GET",
            data: {_filterType:filtertype},
            success: function (result) {

                formValues.empty().html(' ');
                formValues.append('<option value="0">Todos</option>');
                $.each(result, function (i, item) {
                    formValues.append('<option value="'+item.id+'">'+item.descricao+'</option>');
                });
                formValues.removeClass("loading");
            }
        });
    }else{
        formValues.empty().html(' ');
        formValues.append('<option value="0">Todos</option>');
        formValues.removeClass("loading");
    }
});


$("#esp_type_filter_analista").change(function () {
    var filtertype = $(this).val();
    var urlpath = $(this).attr('base-url');
    var formValues = $("#esp_value_filter");
    formValues.addClass("loading");
    $.ajax({
        url: urlpath,
        type: "GET",
        data: {_filterType:filtertype},
        success: function (result) {

            formValues.empty().html(' ');

            formValues.append('<option value="0">Todos</option>');
            $.each(result, function (i, item) {
                formValues.append('<option value="'+item.id+'">'+item.descricao+'</option>');
            });
            formValues.removeClass("loading");
        }
    });

});

$("#employee_form_uf").change(function () {
    var ufSelector = $(this).val();
    var urlpath = routeCidadesPorEstado;
    var cidadeSelector = $("#employee_form_cidade");
    cidadeSelector.addClass("loading");

    $.ajax({
        url: urlpath,
        type: "GET",
        dataType: "JSON",
        data: {uf:ufSelector},
        success: function (cidades) {

            cidadeSelector.html('');
            cidadeSelector.append('<option value>Selecione uma cidade...</option>');
            $.each(cidades, function (i, item) {
                cidadeSelector.append('<option value="'+item.codigo+'">'+item.nome+'</option>');
            });
            cidadeSelector.removeClass("loading");
        }
    });
});

$("#employee_form_ufnatu").change(function () {
    var ufSelector = $(this).val();
    var urlpath = routeCidadesPorEstado;
    var cidadeSelector = $("#employee_form_naturalidade");
    cidadeSelector.addClass("loading");

    $.ajax({
        url: urlpath,
        type: "GET",
        dataType: "JSON",
        data: {uf:ufSelector},
        success: function (cidades) {

            cidadeSelector.html('');
            cidadeSelector.append('<option value>Selecione uma cidade...</option>');
            $.each(cidades, function (i, item) {
                cidadeSelector.append('<option value="'+item.codigo+'">'+item.nome+'</option>');
            });
            cidadeSelector.removeClass("loading");
        }
    });
});



$("#form_act_new").on("submit", function (e) {

    e.preventDefault();

    var form = $(this);

    $.ajax({
        type: "POST",
        url: $("#url-action-form").val(),
        dataType: "json",
        data: $(this).serialize(),
        success: function (response) {
            preloadDeActive();
            var codigomsg = response.data;
            console.log("resposta = "+codigomsg);
            if(codigomsg == '0'){
                bootbox.alert("Ato salvo com sucesso!");
                form.trigger("reset");
                setFocus($("input[id=form_numero]"));

            }else if (codigomsg == '1'){

                bootbox.confirm("Já existe ato cadastrado para este processo! Deseja salvar?", function(result)
                {
                    if(result){
                        $("#save-action-form").val(1);
                        $("#form_act_new").submit();
                    }
                });

            }else{
                bootbox.alert("Data de emissão do Ato não permitida. Prazo de registro encerrado!");
            }


        }
    });


});

function setFocus(element) {
    setTimeout(function () {
        element.focus()
    }, 2000);

};


function openPDFDocument(element){
    var url = element.attr('href');
    var left  = ($(window).width()/2)-(900/2),
        top   = ($(window).height()/2)-(600/2),
        popup = window.open ("pdfviewer.html.twig?url="+url, "Visualizar PDF", "width=900, height=600, top="+top+", left="+left);
        popup.focus();
};


/*

var $estado = $('#employee_form_uf');
// When sport gets selected ...
$estado.change(function() {
    // ... retrieve the corresponding form.
    var $form = $(this).closest('form');
    // Simulate form data, but only include the selected sport value.
    var data = {};
    data[$estado.attr('name')] = $estado.val();
    console.log($estado.val());
    console.log($form.attr('action'));
    // Submit data via AJAX to the form's action path.
    $.ajax({
        url : $form.attr('action'),
        type: $form.attr('method'),
        data : data,
        success: function(html) {
            // Replace current position field ...
            $('#employee_form_cidade').replaceWith(
                // ... with the returned one from the AJAX response.
                $(html).find('#employee_form_cidade')
            );
            // Position field now displays the appropriate positions.
        }
    });
});

*/