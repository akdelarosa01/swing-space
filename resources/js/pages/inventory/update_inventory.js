var items = [];

$( function() {
    check_permission('UPD_INV');
    get_dropdown_options(2,'#item_type');
	inventoryTable(items);

    $('#btn_search_type').on('click', function() {
        if ($('#item_type').val() == '') {
            msg('please select an item type.','failed');
        } else {
            searchItems($('#item_type').val());
        }
    });

    $('#frm_update').on('submit', function(e) {
        e.preventDefault();

        if (items.length > 0) {
            $('.loading').show();

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                dataType: 'JSON',
                data: $(this).serialize(),
            }).done(function(data, textStatus, xhr) {
                if (textStatus == 'success') {
                    msg(data.msg,data.status)
                    searchItems(data.item_type);
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
            });
        } else {
            msg('Please search an item type first.','failed');
        }
    });
});

function searchItems(item_type) {
    $('.loading').show();
    $.ajax({
        url: '../../update-inventory/search-items',
        type: 'GET',
        dataType: 'JSON',
        data: {
            _token: token,
            item_type: item_type
        },
    }).done(function(data, textStatus, xhr) {
        items = data;
        inventoryTable(data);
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
        columns: [
            { data: 'item_code' },
            { data: 'item_name' },
            { data: 'item_type' },
            { data: 'quantity' },
            { data: 'minimum_stock' },
            { data: 'uom' },
            { data: function(x) {
                return '<input type="number" class="form-control form-control-sm" name="new_qty[]" maxlength="3" min="1" required>'+
                        '<input type="hidden" name="id[]" value="'+x.id+'">'+
                        '<input type="hidden" name="item_code[]" value="'+x.item_code+'">'+
                        '<input type="hidden" name="item_name[]" value="'+x.item_name+'">'+
                        '<input type="hidden" name="item_type[]" value="'+x.item_type+'">'+
                        '<input type="hidden" name="quantity[]" value="'+x.quantity+'">'+
                        '<input type="hidden" name="minimum_stock[]" value="'+x.minimum_stock+'">'+
                        '<input type="hidden" name="uom[]" value="'+x.uom+'">';
            }}
        ],
        createdRow: function (row, data, dataIndex) {
            if (data.quantity <= data.minimum_stock) {
                $(row).css('background-color', '#ff6266');
                $(row).css('color', '#fff');
            }
        }
    });
}