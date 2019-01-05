var items = [];

$( function() {
    check_permission('INV_LST');
    checkAllCheckboxesInTable('.check_all_items','.check_item');
    get_dropdown_options(2,'#item_type');
    get_dropdown_options(2,'#item_type_export');
	inventoryTable(items);

    $('#btn_search_type').on('click', function() {
        if ($('#item_type').val() == '') {
            msg('please select an item type.','failed');
        } else {
            searchItems($('#item_type').val());
        }
    });

    $('#btn_export').on('click', function() {
        $('#export_modal').modal('show');
    });

    $('#btn_export_files').on('click', function() {
        var ExportFileURL = '../../inventory-files?_token='+token+
            '&&item_type_export='+$('#item_type_export').val()+
            '&&file_type='+$('#file_type').val();

        if ($('#file_type').val() == 'PDF') {
            window.open(ExportFileURL,'_tab');
        } else {
            window.location.href = ExportFileURL;
        }
        
    });

    $('#btn_delete').on('click', function() {
        var chkArray = [];
        $(".check_item:checked").each(function() {
            chkArray.push($(this).val());
        });

        if (chkArray.length > 0) {
            confirm('Delete Item','Do you want to delete this item/s?',chkArray);
        } else {
            msg("Please select at least 1 item.",'failed');
        }

        $('.check_all_items').prop('checked',false);
    });

    $('#btn_confirm').on('click', function() {
        $('#confirm_modal').modal('hide');
        $('.loading').show();
        $.ajax({
            url: '../../inventory-list/delete',
            type: 'POST',
            dataType: 'JSON',
            data: {
                _token: token,
                id: $('#confirm_id').val()
            },
        }).done(function(data, textStatus, xhr) {
            if (textStatus == 'success') {
                msg(data.msg,data.status);
                inventoryTable(data.items);
            }
            
        }).fail(function(xhr, textStatus, errorThrown) {
            msg('Inventories: '+errorThrown,textStatus);
        }).always(function() {
            $('.loading').hide();
        });
    });
});

function searchItems(item_type) {
    $('.loading').show();
    $.ajax({
        url: '../../inventory-list/search-items',
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
        columns: [
            { data: function(x) {
                return '<input type="checkbox" class="check_item" value="'+x.id+'">';
            }, searchable: false, orderable: false },
            { data: 'item_code' },
            { data: 'item_name' },
            { data: 'item_type' },
            { data: 'quantity' },
            { data: 'minimum_stock' },
            { data: 'uom' }
        ],
        createdRow: function (row, data, dataIndex) {
            if (data.quantity <= data.minimum_stock) {
                $(row).css('background-color', '#ff6266');
                $(row).css('color', '#fff');
            }
        }
    });
}