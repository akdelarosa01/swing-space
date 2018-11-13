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
/******/ 	return __webpack_require__(__webpack_require__.s = 46);
/******/ })
/************************************************************************/
/******/ ({

/***/ 46:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(47);


/***/ }),

/***/ 47:
/***/ (function(module, exports) {

var customers = [];

$(function () {
    getCustomers();

    $('#tbl_customers_body').on('click', '.delete-customer', function () {
        confirm('Delete Customer', 'Do you want to delete this customer?', $(this).attr('data-id'));
    });

    $('#btn_confirm').on('click', function () {
        $('.loading').show();
        $.ajax({
            url: '../../customer-list/delete',
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
                customerTable(data.customers);
            }
        }).fail(function (xhr, textStatus, errorThrown) {
            msg('Delete Customer: ' + errorThrown, textStatus);
        }).always(function () {
            $('.loading').hide();
        });
    });
});

function getCustomers() {
    customers = [];
    $.ajax({
        url: 'customer-list/show',
        type: 'GET',
        dataType: 'JSON',
        data: { _token: token }
    }).done(function (data, textStatus, xhr) {
        customers = data;
        customerTable(customers);
    }).fail(function (xhr, textStatus, errorThrown) {
        msg(errorThrown, textStatus);
    }).always(function () {
        console.log("complete");
    });
}

function customerTable(arr) {
    $('#tbl_customers').dataTable().fnClearTable();
    $('#tbl_customers').dataTable().fnDestroy();
    $('#tbl_customers').dataTable({
        data: arr,
        //    bLengthChange : false,
        //    searching: false,
        //    ordering: false,
        // paging: false,
        // scrollY: "250px",
        columns: [{ data: function data(x) {
                return '<img src="' + x.photo + '" class="w-35 rounded-circle" alt="' + x.firstname + ' ' + x.lastname + '">';
            }, searchable: false, orderable: false }, { data: 'customer_code' }, { data: function data(x) {
                return x.firstname + ' ' + x.lastname;
            } }, { data: 'gender' }, { data: function data(x) {
                return '<div class="btn-group">' + '<a href="/membership/' + x.id + '/edit" class="btn btn-sm btn-info">Edit</a>' + '<button class="btn btn-sm btn-danger delete-customer" data-id="' + x.id + '">Delete</button>' + '</div>';
            }, searchable: false, orderable: false }]
    });
}

/***/ })

/******/ });