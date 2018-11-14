/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 68);
/******/ })
/************************************************************************/
/******/ ({

/***/ 68:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(69);


/***/ }),

/***/ 69:
/***/ (function(module, exports) {

var products = [];
var for_sale = [];

$(function () {
    get_dropdown_options(3, '#prod_type');
    get_dropdown_options(5, '#variants');
    checkAllCheckboxesInTable('.check_all_products', '.check_product');
    getProducts();

    getProductsByType('');

    $('#btn_add_products').on('click', function () {
        $('#add_product_modal').modal('show');
    });

    $('#frm_products').on('submit', function (e) {
        e.preventDefault();
        $('.loading').show();

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            dataType: 'JSON',
            data: $(this).serialize()
        }).done(function (data, textStatus, xhr) {
            if (textStatus == 'success') {
                msg(data.msg, data.status);
                makeProductsDataTable(data.products);
                clear();
            }
        }).fail(function (xhr, textStatus, errorThrown) {
            var errors = xhr.responseJSON.errors;

            if (errors == undefined) {
                msg('Products: ' + errorThrown, textStatus);
            } else {
                showErrors(errors);
            }
        }).always(function () {
            $('.loading').hide();
        });
    });

    $('#tbl_products_body').on('click', '.edit', function () {
        $('#prod_name').val($(this).attr('data-prod_name'));
        $('#prod_type').val($(this).attr('data-prod_type'));
        $('#variants').val($(this).attr('data-variants'));
        $('#price').val($(this).attr('data-price'));
        $('#description').val($(this).attr('data-description'));
        $('#id').val($(this).attr('data-id'));
    });

    $('#btn_delete').on('click', function () {
        var chkArray = [];
        $(".check_product:checked").each(function () {
            chkArray.push($(this).val());
        });

        if (chkArray.length > 0) {
            confirm('Delete Product', 'Do you want to delete this product/s?', chkArray);
        } else {
            msg("Please select at least 1 item.", 'failed');
        }

        $('.check_all_products').prop('checked', false);
    });

    $('#btn_confirm').on('click', function () {
        $.ajax({
            url: '../../add-products/delete',
            type: 'POST',
            dataType: 'JSON',
            data: {
                _token: token,
                id: $('#confirm_id').val()
            }
        }).done(function (data, textStatus, xhr) {
            if (textStatus == 'success') {
                $('#confirm_modal').modal('hide');
                msg(data.msg, data.status);
                makeProductsDataTable(data.products);
            }
        }).fail(function (xhr, textStatus, errorThrown) {
            console.log("error");
        }).always(function () {
            console.log("complete");
        });
    });

    $('#tbl_availables_body').on('click', '.btn_add', function () {
        var index = for_sale.length;

        for_sale.push({
            index: index,
            id: $(this).attr('data-id'),
            prod_code: $(this).attr('data-prod_code'),
            prod_name: $(this).attr('data-prod_name'),
            prod_type: $(this).attr('data-prod_type'),
            variants: $(this).attr('data-variants'),
            price: $(this).attr('data-price'),
            target_qty: $(this).attr('data-target_qty'),
            quantity: $(this).attr('data-quantity')
        });

        makeSelectedDataTable(for_sale);
    });

    $('#tbl_selected_body').on('click', '.btn_remove', function () {
        for_sale.splice($(this).attr('data-index'), 1);

        count = 0;
        $.each(for_sale, function (i, x) {
            x.index = count++;
        });

        makeSelectedDataTable(for_sale);
    });

    $('#frm_set_qty').on('submit', function (e) {
        e.preventDefault();
        $('.loading').show();

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            dataType: 'JSON',
            data: $(this).serialize()
        }).done(function (data, textStatus, xhr) {
            if (textStatus == 'success') {
                msg(data.msg, data.status);
                makeAvailablesDataTable(data.products);
                for_sale = [];
                makeSelectedDataTable(for_sale);
                clear();
            }
        }).fail(function (xhr, textStatus, errorThrown) {
            msg('Products: ' + errorThrown, textStatus);
        }).always(function () {
            $('.loading').hide();
        });
    });
});

function clear() {
    $('.clear').val('');
}

function getProducts() {
    $('.loading').show();
    $.ajax({
        url: '../../add-products/show',
        type: 'GET',
        dataType: 'JSON',
        data: {
            _token: token
        }
    }).done(function (data, textStatus, xhr) {
        products = data;
        makeProductsDataTable(products);
    }).fail(function (xhr, textStatus, errorThrown) {
        msg('Products : ' + errorThrown, textStatus);
    }).always(function () {
        $('.loading').hide();
    });
}

function makeProductsDataTable(arr) {
    $('#tbl_products').dataTable().fnClearTable();
    $('#tbl_products').dataTable().fnDestroy();
    $('#tbl_products').dataTable({
        data: arr,
        columns: [{ data: function data(x) {
                return '<input type="checkbox" class="check_product" value="' + x.id + '">';
            }, searchable: false, orderable: false }, { data: 'prod_code' }, { data: 'prod_name' }, { data: 'prod_type' }, { data: 'variants' }, { data: 'price' }, { data: 'description' }, { data: function data(x) {

                return '<button type="button" class="btn btn-sm btn-info edit" data-id="' + x.id + '"' + 'data-prod_code="' + x.prod_code + '"' + 'data-prod_name="' + x.prod_name + '"' + 'data-prod_type="' + x.prod_type + '"' + 'data-variants="' + x.variants + '"' + 'data-price="' + x.price + '"' + 'data-description="' + x.description + '"' + '>' + '<i class="fa fa-edit"></i>' + '</button>';
            }, searchable: false, orderable: false }]
        // createdRow: function (row, data, dataIndex) {
        //     if (data.disabled > 0) {
        //         $(row).css('background-color', '#ff6266');
        //         $(row).css('color', '#fff');
        //     }
        // }
    });
}

function getProductsByType(type) {
    $.ajax({
        url: '../../add-products/search',
        type: 'GET',
        dataType: 'JSON',
        data: {
            _token: token,
            type: type
        }
    }).done(function (data, textStatus, xhr) {
        makeAvailablesDataTable(data);
    }).fail(function (xhr, textStatus, errorThrown) {
        msg('Products : ' + errorThrown, textStatus);
    });
}

function makeAvailablesDataTable(arr) {
    $('#tbl_availables').dataTable().fnClearTable();
    $('#tbl_availables').dataTable().fnDestroy();
    $('#tbl_availables').dataTable({
        data: arr,
        sorting: false,
        searching: false,
        columns: [{ data: 'prod_code', orderable: false }, { data: 'prod_name', orderable: false }, { data: 'variants', orderable: false }, { data: 'price', orderable: false }, { data: 'target_qty', orderable: false }, { data: 'quantity', orderable: false }, { data: function data(x) {

                return '<button type="button" class="btn btn-sm btn-info btn_add" data-id="' + x.id + '"' + 'data-prod_code="' + x.prod_code + '"' + 'data-prod_name="' + x.prod_name + '"' + 'data-prod_type="' + x.prod_type + '"' + 'data-variants="' + x.variants + '"' + 'data-price="' + x.price + '"' + 'data-target_qty="' + x.target_qty + '"' + 'data-quantity="' + x.quantity + '"' + '>' + '<i class="fa fa-plus"></i>' + '</button>';
            }, searchable: false, orderable: false }]
        // createdRow: function (row, data, dataIndex) {
        //     if (data.disabled > 0) {
        //         $(row).css('background-color', '#ff6266');
        //         $(row).css('color', '#fff');
        //     }
        // }
    });
}

function makeSelectedDataTable(arr) {
    $('#tbl_selected').dataTable().fnClearTable();
    $('#tbl_selected').dataTable().fnDestroy();
    $('#tbl_selected').dataTable({
        data: arr,
        sorting: false,
        searching: false,
        columns: [{ data: 'prod_code', orderable: false }, { data: 'prod_name', orderable: false }, { data: 'variants', orderable: false }, { data: 'price', orderable: false }, { data: function data(x) {
                return '<input type="number" class="form-control form-control-sm qunatity" name="target_qty[]" value="' + x.target_qty + '" required>';
            }, orderable: false }, { data: function data(x) {
                return '<input type="number" class="form-control form-control-sm qunatity" name="quantity[]" value="' + x.quantity + '" required>';
            }, orderable: false }, { data: function data(x) {
                return '<input type="hidden" name="prod_code[]" value="' + x.prod_code + '">' + '<input type="hidden" name="prod_name[]" value="' + x.prod_name + '">' + '<input type="hidden" name="prod_type[]" value="' + x.prod_type + '">' + '<input type="hidden" name="variants[]" value="' + x.variants + '">' + '<input type="hidden" name="price[]" value="' + x.price + '">' + '<input type="hidden" name="ids[]" value="' + x.id + '">' + '<button type="button" class="btn btn-sm btn-danger btn_remove" data-index="' + x.index + '">' + '<i class="fa fa-times"></i>' + '</button>';
            }, searchable: false, orderable: false }]
    });
}

/***/ })

/******/ });