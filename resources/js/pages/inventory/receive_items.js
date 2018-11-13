let items = [];
let selected_items = [];

$( function() {
    makeItemsDataTable(items);
    makeSelectedItemsDataTable(selected_items);

    get_dropdown_options(2,'#item_type_srch');
    get_dropdown_options(2,'#item_type');
    get_dropdown_options(4,'#uom');
    $('#btn_add_items').on('click', function() {
        $('#receive_items_modal').modal('show');
    });

    $('#frm_items').on('submit', function(e) {
        e.preventDefault();
        $('.loading').show();

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            dataType: 'JSON',
            data: $(this).serialize(),
        }).done(function(data, textStatus, xhr) {
            if (textStatus == 'success') {
                msg(data.msg,data.status)
                clear();
            }
        }).fail(function(xhr, textStatus, errorThrown) {
            var errors = xhr.responseJSON.errors;

            if (errors == undefined) {
                msg('Received Items: '+errorThrown,textStatus);
            } else {
                showErrors(errors);
            }
        }).always( function() {
            $('.loading').hide();
            clear();
        });
    });

    $('#btn_search_type').on('click', function() {
        if ($('#item_type_srch').val() !== '') {
            searchItems($('#item_type_srch').val());
        } else {
            msg('please select an item type.','failed');
        }
    });

    $('#tbl_items_body').on('click', '.add_item', function() {
        let index = selected_items.length;

        selected_items.push({
            index: index,
            id: $(this).attr('data-id'),
            item_code: $(this).attr('data-item_code'),
            item_name: $(this).attr('data-item_name'),
            item_type: $(this).attr('data-item_type'),
            uom: $(this).attr('data-uom'),
            quantity: '',
        });

        makeSelectedItemsDataTable(selected_items);
    });

    $('#tbl_selected_body').on('click', '.remove_item', function() {
        selected_items.splice($(this).attr('data-index'), 1);

        count = 0;
        $.each(selected_items, function(i, x) {
            x.index = 
            count++;
        });

        makeSelectedItemsDataTable(selected_items);
    });

    $('#frm_selected').on('submit', function(e) {
        e.preventDefault();
        $('.loading').show();

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            dataType: 'JSON',
            data: $(this).serialize(),
        }).done(function(data, textStatus, xhr) {
            if (textStatus == 'success') {
                msg(data.msg,data.status)
                selected_items = []
                makeSelectedItemsDataTable(selected_items);
                searchItems(data.item_type)
            }
        }).fail(function(xhr, textStatus, errorThrown) {
            msg('Received Items: '+errorThrown,textStatus);
        }).always( function() {
            $('.loading').hide();
        });
    });
})

function clear() {
    $('.clear').val('');
}

function searchItems(item_type) {
    $.ajax({
        url: '../../receive-items/search-item',
        type: 'GET',
        dataType: 'JSON',
        data: {
            _token: token,
            item_type_srch: item_type
        },
    }).done(function(data, textStatus, xhr) {
        items = data;
        makeItemsDataTable(items);
    }).fail(function(xhr, textStatus, errorThrown) {
        msg('Search Items: '+errorThrown,textStatus);
    });
}

function makeItemsDataTable(arr) {
    $('#tbl_items').dataTable().fnClearTable();
    $('#tbl_items').dataTable().fnDestroy();
    $('#tbl_items').dataTable({
        data: arr,
        searching: false,
        ordering: false,
        columns: [
            {data: 'item_code'},
            {data: 'item_name'},
            {data: 'quantity'},
            {data: 'uom'},
            {data: function(x) {
                return '<button class="btn btn-sm btn-info add_item" data-id="'+x.id+'" '+
                        ' data-item_code="'+x.item_code+'" '+
                        ' data-item_name="'+x.item_name+'" '+
                        ' data-quantity="'+x.quantity+'" '+
                        ' data-item_type="'+x.item_type+'" '+
                        ' data-uom="'+x.uom+'">'+
                            '<i class="fa fa-plus"></i>'+
                        '</button>';
            }, searchable: false, orderable: false},
        ]
    });
}

function makeSelectedItemsDataTable(arr) {
    $('#tbl_selected').dataTable().fnClearTable();
    $('#tbl_selected').dataTable().fnDestroy();
    $('#tbl_selected').dataTable({
        data: arr,
        bLengthChange : false,
        scrollY: "300px",
        searching: false,
        paging: false,
        sorting: false,
        columns: [
            {data: 'item_code', searchable: false, orderable: false},
            {data: 'item_name', searchable: false, orderable: false},
            {data: 'item_type', searchable: false, orderable: false},
            {data: function(x) {
                return '<input type="hidden" name="id[]" value="'+x.id+'">'+
                        '<input type="hidden" name="selected_code[]" value="'+x.item_code+'">'+
                        '<input type="hidden" name="selected_name[]" value="'+x.item_name+'">'+
                        '<input type="hidden" name="selected_type[]" value="'+x.item_type+'">'+
                        '<input type="hidden" name="selected_uom[]" value="'+x.uom+'">'+
                        '<input type="text" class="form-control form-control-sm quantity" name="selected_quantity[]">';
            }, searchable: false, orderable: false},
            {data: function(x) {
                return '<button class="btn btn-sm btn-danger remove_item" data-index="'+x.index+'">'+
                            '<i class="fa fa-times"></i>'+
                        '</button>';
            }, searchable: false, orderable: false},
        ]
    });

    get_dropdown_options(4,'.uom');
}