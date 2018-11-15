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

$(function () {
	getTransactionCodes([]);

	$('#frm_trans_code').on('submit', function (e) {
		e.preventDefault();
		$.ajax({
			url: $(this).attr('action'),
			type: 'POST',
			dataType: 'JSON',
			data: $(this).serialize()
		}).done(function (data, textStatus, xhr) {
			if (textStatus == 'success') {
				msg(data.msg, data.status);
				TransactionDataTable(data.trans);
				clear();
			}
		}).fail(function (xhr, textStatus, errorThrown) {
			var errors = xhr.responseJSON.errors;
			showErrors(errors);
		}).always(function () {
			console.log("complete");
		});
	});

	$('#tbl_transaction_body').on('click', '.btn_edit', function () {
		$('#id').val($(this).attr('data-id'));
		$('#code').val($(this).attr('data-code'));
		$('#description').val($(this).attr('data-description'));
		$('#prefix').val($(this).attr('data-prefix'));
		$('#prefix_format').val($(this).attr('data-prefix_format'));
		$('#next_no').val($(this).attr('data-next_no'));
		$('#next_no_length').val($(this).attr('data-next_no_length'));
	});

	$('#tbl_transaction_body').on('click', '.btn_remove', function () {
		confirm('Delete Transaction Code', 'Do you want to delete this transaction code?', $(this).attr('data-id'));
	});

	$('#btn_confirm').on('click', function () {
		$.ajax({
			url: '/admin/transaction-codes/delete',
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
				TransactionDataTable(data.trans);
			}
		}).fail(function (xhr, textStatus, errorThrown) {
			console.log("error");
		}).always(function () {
			console.log("complete");
		});
	});

	$('#btn_cancel').on('click', function () {
		clear();
	});
});

function getTransactionCodes(data) {
	if (data.length > 0) {
		console.log(data);
		TransactionDataTable(data);
	} else {
		$.ajax({
			url: '/admin/transaction-codes/show',
			type: 'GET',
			dataType: 'JSON',
			data: { _token: token }
		}).done(function (data, textStatus, xhr) {
			TransactionDataTable(data);
		}).fail(function (xhr, textStatus, errorThrown) {
			console.log("error");
		}).always(function () {
			console.log("complete");
		});
	}
}

function TransactionDataTable(arr) {
	$('#tbl_transaction').dataTable().fnClearTable();
	$('#tbl_transaction').dataTable().fnDestroy();
	$('#tbl_transaction').dataTable({
		data: arr,
		sorting: false,
		deferRender: true,
		columns: [{ data: 'code' }, { data: 'description' }, { data: 'prefix' }, { data: 'prefix_format' }, { data: 'next_no' }, { data: 'next_no_length' }, { data: function data(x) {
				return '<div class="btn-group"><button class="btn btn-sm btn-info btn_edit" data-id="' + x.id + '"' + ' data-code="' + x.code + '"' + ' data-description="' + x.description + '"' + ' data-prefix="' + x.prefix + '"' + ' data-prefix_format="' + x.prefix_format + '"' + ' data-next_no="' + x.next_no + '"' + ' data-next_no_length="' + x.next_no_length + '"><i class="fa fa-edit"></i></button>' + '<button class="btn btn-sm btn-danger btn_remove" data-id="' + x.id + '"><i class="fa fa-trash"></i></button></div>';
			}, searchable: false, orderable: false }]
	});
}

/***/ })

/******/ });