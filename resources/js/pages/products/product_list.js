var products = [];

$( function() {
	getProducts();
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
            { data: 'target_qty' },
            { data: 'quantity' },
        ]
    });
}