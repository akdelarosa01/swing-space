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
/******/ 	return __webpack_require__(__webpack_require__.s = 58);
/******/ })
/************************************************************************/
/******/ ({

/***/ 58:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(59);


/***/ }),

/***/ 59:
/***/ (function(module, exports) {

var items = [];

$(function () {
    get_dropdown_options(2, '#item_type');
    inventoryTable(items);

    $('#btn_search_type').on('click', function () {
        if ($('#item_type').val() == '') {
            msg('please select an item type.', 'failed');
        } else {
            searchItems($('#item_type').val());
        }
    });

    $('#frm_update').on('submit', function (e) {
        e.preventDefault();

        if (items.length > 0) {
            $('.loading').show();

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                dataType: 'JSON',
                data: $(this).serialize()
            }).done(function (data, textStatus, xhr) {
                if (textStatus == 'success') {
                    msg(data.msg, data.status);
                    searchItems(data.item_type);
                }
            }).fail(function (xhr, textStatus, errorThrown) {
                var errors = xhr.responseJSON.errors;

                if (errors == undefined) {
                    msg('Received Items: ' + errorThrown, textStatus);
                } else {
                    showErrors(errors);
                }
            }).always(function () {
                $('.loading').hide();
            });
        } else {
            msg('Please search an item type first.', 'failed');
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
        }
    }).done(function (data, textStatus, xhr) {
        items = data;
        inventoryTable(data);
    }).fail(function (xhr, textStatus, errorThrown) {
        msg('Inventories: ' + errorThrown, textStatus);
    }).always(function () {
        $('.loading').hide();
    });
}

function inventoryTable(arr) {
    $('#tbl_items').dataTable().fnClearTable();
    $('#tbl_items').dataTable().fnDestroy();
    $('#tbl_items').dataTable({
        data: arr,
        columns: [{ data: 'item_code' }, { data: 'item_name' }, { data: 'item_type' }, { data: 'quantity' }, { data: 'minimum_stock' }, { data: 'uom' }, { data: function data(x) {
                return '<input type="number" class="form-control form-control-sm" name="new_qty[]" maxlength="3" min="1" required>' + '<input type="hidden" name="id[]" value="' + x.id + '">' + '<input type="hidden" name="item_code[]" value="' + x.item_code + '">' + '<input type="hidden" name="item_name[]" value="' + x.item_name + '">' + '<input type="hidden" name="item_type[]" value="' + x.item_type + '">' + '<input type="hidden" name="quantity[]" value="' + x.quantity + '">' + '<input type="hidden" name="minimum_stock[]" value="' + x.minimum_stock + '">' + '<input type="hidden" name="uom[]" value="' + x.uom + '">';
            } }],
        createdRow: function createdRow(row, data, dataIndex) {
            if (data.quantity <= data.minimum_stock) {
                $(row).css('background-color', '#ff6266');
                $(row).css('color', '#fff');
            }
        }
    });
}

/***/ })

/******/ });