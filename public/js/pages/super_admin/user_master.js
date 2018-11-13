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
/******/ 	return __webpack_require__(__webpack_require__.s = 40);
/******/ })
/************************************************************************/
/******/ ({

/***/ 40:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(41);


/***/ }),

/***/ 41:
/***/ (function(module, exports) {

var users = [];
$(function () {
    checkAllCheckboxesInTable('.check_all_users', '.check_user');
    getUsers();

    $('#frm_users').on('submit', function (e) {
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
                makeUserDataTable(data.users);
                clear();
            }
        }).fail(function (xhr, textStatus, errorThrown) {
            var errors = xhr.responseJSON.errors;

            if (errors == undefined) {
                msg('Users: ' + errorThrown, textStatus);
            } else {
                showErrors(errors);
            }
        }).always(function () {
            $('.loading').hide();
            clear();
        });
    });
});

function clear() {
    $('.clear').val('');
}

function getUsers() {
    $('.loading').show();
    $.ajax({
        url: '../../admin/user-master/show',
        type: 'GET',
        dataType: 'JSON',
        data: {
            _token: token
        }
    }).done(function (data, textStatus, xhr) {
        users = data;
        makeUserDataTable(users);
    }).fail(function (xhr, textStatus, errorThrown) {
        msg('Langauage : ' + errorThrown, textStatus);
    }).always(function () {
        $('.loading').hide();
    });
}

function makeUserDataTable(arr) {
    $('#tbl_users').dataTable().fnClearTable();
    $('#tbl_users').dataTable().fnDestroy();
    $('#tbl_users').dataTable({
        data: arr,
        columns: [{ data: function data(x) {
                return '<input type="checkbox" class="check_user" value="' + x.id + '">';
            }, searchable: false, orderable: false }, { data: 'user_type' }, { data: 'firstname' }, { data: 'lastname' }, { data: 'email' }, { data: 'actual_password' }, { data: function data(x) {
                var page_button = '';

                if (x.user_type !== 'Customer') {
                    page_button = '<button class="btn btn-sm btn-success assign-page" data-id="' + x.id + '">' + '<i class="fa fa-list"></i>' + '</button>';
                }

                return '<div class="btn-group">' + '<button class="btn btn-sm btn-info edit" data-id="' + x.id + '">' + '<i class="fa fa-edit"></i>' + '</button>' + page_button + '</div>';
            }, searchable: false, orderable: false }],
        createdRow: function createdRow(row, data, dataIndex) {
            if (data.disabled > 0) {
                $(row).css('background-color', '#ff6266');
                $(row).css('color', '#fff');
            }
        }
    });
}

/***/ })

/******/ });