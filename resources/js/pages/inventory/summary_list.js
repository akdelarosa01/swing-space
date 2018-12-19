var items = [];

$( function() {
    check_permission('SUM_LST');
    get_dropdown_options(2,'#item_type');
    inventoryTable(items);

    $('#btn_search_type').on('click', function() {
        if ($('#item_type').val() == '') {
            msg('please select an item type.','failed');
        } else {
            searchItems($('#item_type').val());
        }
    });
});

function searchItems(item_type) {
    $('.loading').show();
    $.ajax({
        url: '../../summary-list/search-items',
        type: 'GET',
        dataType: 'JSON',
        data: {
            _token: token,
            item_type: item_type
        },
    }).done(function(data, textStatus, xhr) {
        items = data;
        inventoryTable(items);
    }).fail(function(xhr, textStatus, errorThrown) {
        msg('Inventories: '+errorThrown,textStatus);
    }).always(function() {
        $('.loading').hide();
    });
    
}

function inventoryTable(arr) {
    $('#tbl_items').dataTable().fnClearTable();
    $('#tbl_items').dataTable().fnDestroy();
    $('#tbl_items').dataTable({
        data: arr,
        ordering: false,
        columns: [
            { data: 'transaction_type'},
            { data: 'item_code'},
            { data: 'item_name'},
            { data: 'item_type'},
            { data: 'quantity'},
            { data: 'uom' },
            { data: 'trans_date'},
            { data: 'create_user'}
        ]
    });
}