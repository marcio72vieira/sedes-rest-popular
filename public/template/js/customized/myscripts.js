
$(function(){
    // Configurações do DataTable
    $('#dataTable, #dataTable2').dataTable({
        "ordering": true,
        "order": [[ 0, "desc" ]],
        /*
        Escondendo uma coluna específica
        "columnDefs": [
            {
                "targets": [ 2 ],
                "visible": false
            }
        ],
        */
        language: {
            "lengthMenu": "Mostrar _MENU_ registos",
            "search": "Procurar:",
            "info": "Mostrando os registros _START_ a _END_ num total de _TOTAL_",
            "paginate": {
                "first": "Primeiro",
                "previous": "Anterior",
                "next": "Seguinte",
                "last": "Último"
            },
            "zeroRecords": "Não foram encontrados resultados",
        }
    });

    // Configuraçoes jquerymask
    $('.phone').mask('(00) 00000-0000');
    $('#telefone').mask('(00) 00000-0000');
    $('#cpf').mask('000.000.000-00');
    $('#cep').mask('00000-000');
    $('#cnpj').mask('00.000.000/0000-00', {reverse: true});



    // MASK
    var cellMaskBehavior = function (val) {
        return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
    },
    cellOptions = {
        onKeyPress: function(val, e, field, options) {
            field.mask(cellMaskBehavior.apply({}, arguments), options);
        }
    };

    $('.mask-cell').mask(cellMaskBehavior, cellOptions);
    $('.mask-phone').mask('(00) 0000-0000');
    $(".mask-date").mask('00/00/0000');
    $(".mask-datetime").mask('00/00/0000 00:00');
    $(".mask-month").mask('00/0000', {reverse: true});
    $(".mask-doc").mask('000.000.000-00', {reverse: true});
    $(".mask-cnpj").mask('00.000.000/0000-00', {reverse: true});
    $(".mask-zipcode").mask('00000-000', {reverse: true});
    $(".mask-money").mask('R$ 000.000.000.000.000,00', {reverse: true, placeholder: "R$ 0,00"});


});



