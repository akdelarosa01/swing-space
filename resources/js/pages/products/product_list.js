var products = [];

$( function() {
    check_permission('PRD_LST');
    get_dropdown_options(3,'#prod_type_export');
	getProducts();

    $('#btn_export').on('click', function() {
        $('#export_modal').modal('show');
    });

    $('#btn_export_files').on('click', function() {
        var ExportFileURL = '../../product-files?_token='+token+
            '&&prod_type_export='+$('#prod_type_export').val()+
            '&&file_type='+$('#file_type').val();

        if ($('#file_type').val() == 'PDF') {
            window.open(ExportFileURL,'_tab');
        } else {
            window.location.href = ExportFileURL;
        }
        
    });
});

function getProducts() {
    $('.loading').show();
    $.ajax({
        url: '../../product-list/show',
        type: 'GET',
        dataType: 'JSON',
        data: {
            _token: token
        },
    }).done(function(data, textStatus, xhr) {
        products = data;
        makeProductsDataTable(products);
    }).fail(function(xhr, textStatus, errorThrown) {
        msg('Products : '+errorThrown,textStatus);
    }).always(function() {
        $('.loading').hide();
    }); 
}

function makeProductsDataTable(arr) {
    $('#tbl_products').dataTable().fnClearTable();
    $('#tbl_products').dataTable().fnDestroy();
    $('#tbl_products').dataTable({
        data: arr,
        columns: [
            { data: 'prod_code' },
            { data: 'prod_name' },
            { data: 'description' },
            { data: 'prod_type' },
            { data: 'price' },
            { data: 'variants' },
            { data: 'quantity' },
            { data: 'updated_at' },
        ]
    });
}