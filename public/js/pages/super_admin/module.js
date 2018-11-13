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
/******/ 	return __webpack_require__(__webpack_require__.s = 42);
/******/ })
/************************************************************************/
/******/ ({

/***/ 42:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(43);


/***/ }),

/***/ 43:
/***/ (function(module, exports) {

$(function () {
	getModules([]);

	$('#frm_module').on('submit', function (e) {
		e.preventDefault();
		$.ajax({
			url: $(this).attr('action'),
			type: 'POST',
			dataType: 'JSON',
			data: $(this).serialize()
		}).done(function (data, textStatus, xhr) {
			if (textStatus == 'success') {
				alert(textStatus);
				clear();
				getModules(data);
			}
		}).fail(function (xhr, textStatus, errorThrown) {
			var errors = xhr.responseJSON.errors;
			showErrors(errors);
		}).always(function () {
			console.log("complete");
		});
	});

	$('#tbl_modules_body').on('click', '.btn_edit', function () {
		$('#id').val($(this).attr('data-id'));
		$('#module_code').val($(this).attr('data-module_code'));
		$('#module_name').val($(this).attr('data-module_name'));
		$('#module_category').val($(this).attr('data-module_category'));
		$('#icon').val($(this).attr('data-ic'));
	});

	$('#tbl_modules_body').on('click', '.btn_remove', function () {
		confirm('Delete Module', 'Do you want to delete this module?', $(this).attr('data-id'));
	});

	$('#btn_confirm').on('click', function () {
		$.ajax({
			url: '/admin/module/delete',
			type: 'POST',
			dataType: 'JSON',
			data: {
				_token: token,
				id: $('#confirm_id').val()
			}
		}).done(function (data, textStatus, xhr) {
			if (textStatus == 'success') {
				$('#confirm_modal').modal('hide');
				alert(textStatus);
				ModulesDataTable(data);
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

function getModules(data) {
	if (data.length > 0) {
		console.log(data);
		ModulesDataTable(data);
	} else {
		$.ajax({
			url: '/admin/module/show',
			type: 'GET',
			dataType: 'JSON',
			data: { _token: token }
		}).done(function (data, textStatus, xhr) {
			ModulesDataTable(data);
		}).fail(function (xhr, textStatus, errorThrown) {
			console.log("error");
		}).always(function () {
			console.log("complete");
		});
	}
}

function ModulesDataTable(arr) {
	$('#tbl_modules').dataTable().fnClearTable();
	$('#tbl_modules').dataTable().fnDestroy();
	$('#tbl_modules').dataTable({
		data: arr,
		sorting: false,
		deferRender: true,
		columns: [{ data: 'module_code' }, { data: 'module_name' }, { data: 'module_category' }, { data: function data(x) {
				return '<i class="' + x.icon + '"></i>';
			} }, { data: function data(x) {
				return '<div class="btn-group"><button class="btn btn-sm btn-info btn_edit" data-id="' + x.id + '"' + 'data-module_code="' + x.module_code + '" ' + 'data-module_name="' + x.module_name + '" ' + 'data-module_category="' + x.module_category + '" ' + 'data-ic="' + x.icon + '"><i class="fa fa-edit"></i></button>' + '<button class="btn btn-sm btn-danger btn_remove" data-id="' + x.id + '"><i class="fa fa-trash"></i></button></div>';
			}, searchable: false, orderable: false }]
	});
}

/***/ })

/******/ });