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
/******/ 	return __webpack_require__(__webpack_require__.s = 50);
/******/ })
/************************************************************************/
/******/ ({

/***/ 50:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(51);


/***/ }),

/***/ 51:
/***/ (function(module, exports) {

$(function () {
    getSoldProducts();
    getSales();
    checkAllCheckboxesInTable('.check_all_products', '.check_product');
    checkAllCheckboxesInTable('.check_all_sales', '.check_sale');

    $('#btn_delete_products').on('click', function () {
        var ids = [];
        var msgs = 'Do you want to delete this Sold Product?';

        $('#tbl_products_body').find('.check_product:checked').each(function (index, el) {
            ids.push($(this).val());
        });

        if (ids.length > 1) {
            msgs = 'Do you want to delete these Sold Products?';
        }

        if (ids.length > 0) {
            bootbox.confirm({
                message: msgs,
                buttons: {
                    confirm: {
                        label: 'Yes',
                        className: 'btn-danger'
                    },
                    cancel: {
                        label: 'Cancel',
                        className: 'btn-secondary'
                    }
                },
                callback: function callback(result) {
                    if (result) {
                        $('.loading').show();
                        $.ajax({
                            url: '/admin/wrong-sales-deletion/delete-sold-products',
                            type: 'POST',
                            dataType: 'JSON',
                            data: {
                                _token: token,
                                ids: ids
                            }
                        }).done(function (data, textStatus, xhr) {
                            clear('.clear');
                            getSoldProducts();
                            msg(data.msg, data.status);
                        }).fail(function (xhr, textStatus, errorThrown) {
                            msg('Delete Sold Products: ' + errorThrown, 'error');
                        }).always(function () {
                            $('.loading').hide();
                        });
                    }
                }
            });
        } else {
            msg('Please select at least 1 data.', 'failed');
        }
    });

    $('#btn_delete_sales').on('click', function () {
        var ids = [];
        var msgs = 'Do you want to delete this Sale?';

        $('#tbl_sales_body').find('.check_sale:checked').each(function (index, el) {
            ids.push($(this).val());
        });

        if (ids.length > 1) {
            msgs = 'Do you want to delete these Sales?';
        }

        if (ids.length > 0) {
            bootbox.confirm({
                message: msgs,
                buttons: {
                    confirm: {
                        label: 'Yes',
                        className: 'btn-danger'
                    },
                    cancel: {
                        label: 'Cancel',
                        className: 'btn-secondary'
                    }
                },
                callback: function callback(result) {
                    if (result) {
                        $('.loading').show();
                        $.ajax({
                            url: '/admin/wrong-sales-deletion/delete-sales',
                            type: 'POST',
                            dataType: 'JSON',
                            data: {
                                _token: token,
                                ids: ids
                            }
                        }).done(function (data, textStatus, xhr) {
                            clear('.clear');
                            getSales();
                            msg(data.msg, data.status);
                        }).fail(function (xhr, textStatus, errorThrown) {
                            msg('Delete Sales: ' + errorThrown, 'error');
                        }).always(function () {
                            $('.loading').hide();
                        });
                    }
                }
            });
        } else {
            msg('Please select at least 1 data.', 'failed');
        }
    });
});

function getSoldProducts() {
    $('.loading').show();
    $.ajax({
        url: '/admin/wrong-sales-deletion/get-sold-products',
        type: 'GET',
        dataType: 'JSON'
    }).done(function (data, textStatus, xhr) {
        SoldProductsTable(data);
    }).fail(function (xhr, textStatus, errorThrown) {
        msg('Sold Products: ' + errorThrown, 'error');
    }).always(function () {
        $('.loading').hide();
    });
}

function SoldProductsTable(arr) {
    $('#tbl_products').dataTable().fnClearTable();
    $('#tbl_products').dataTable().fnDestroy();
    $('#tbl_products').dataTable({
        data: arr,
        sorting: false,
        lengthChange: false,
        ordering: false,
        paging: false,
        columnDefs: [{ targets: 0, sortable: false, orderable: false }],
        dom: '<"toolbar">frtip',
        scrollX: true,
        scrollY: 300,
        order: [[11, "asc"]],
        columns: [{ data: function data(_data) {
                return '<input type="checkbox" class="check_product" value="' + _data.id + '">';
            }, searchable: false, orderable: false }, { data: 'customer_code' }, { data: 'firstname' }, { data: 'lastname' }, { data: 'prod_code' }, { data: 'prod_name' }, { data: 'prod_type' }, { data: 'variants' }, { data: 'quantity' }, { data: 'cost' }, { data: 'customer_type' }, { data: 'created_at' }]
    });

    $("#tbl_products_wrapper .toolbar").html('Sold Products');
}

function getSales() {
    $('.loading').show();
    $.ajax({
        url: '/admin/wrong-sales-deletion/get-sales',
        type: 'GET',
        dataType: 'JSON'
    }).done(function (data, textStatus, xhr) {
        SalesTable(data);
    }).fail(function (xhr, textStatus, errorThrown) {
        msg('Sold Products: ' + errorThrown, 'error');
    }).always(function () {
        $('.loading').hide();
    });
}

function SalesTable(arr) {
    $('#tbl_sales').dataTable().fnClearTable();
    $('#tbl_sales').dataTable().fnDestroy();
    $('#tbl_sales').dataTable({
        data: arr,
        sorting: false,
        lengthChange: false,
        ordering: false,
        paging: false,
        dom: '<"toolbar">frtip',
        columnDefs: [{ targets: 0, sortable: false, orderable: false }],
        scrollX: true,
        scrollY: 300,
        order: [[10, "asc"]],
        columns: [{ data: function data(_data2) {
                return '<input type="checkbox" class="check_sale" value="' + _data2.id + '">';
            }, searchable: false, orderable: false }, { data: 'customer_code' }, { data: 'firstname' }, { data: 'lastname' }, { data: 'customer_type' }, { data: 'sub_total' }, { data: 'discount' }, { data: 'payment' }, { data: 'change' }, { data: 'total_sale' }, { data: 'created_at' }]
    });

    $("#tbl_sales_wrapper .toolbar").html('Sales');
}

/***/ })

/******/ });