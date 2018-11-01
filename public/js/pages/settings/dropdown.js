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
/******/ 	return __webpack_require__(__webpack_require__.s = 48);
/******/ })
/************************************************************************/
/******/ ({

/***/ 48:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(49);


/***/ }),

/***/ 49:
/***/ (function(module, exports) {

var options = [];

$(function () {
	getName('');
	getOption(0);

	checkAllCheckboxesInTable('.check_all_name', '.check_item_name');

	$('#frm_name').on('submit', function (e) {
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
				clear();
				DropdownNameDataTable(data.name);
			}
		}).fail(function (xhr, textStatus, errorThrown) {
			var errors = xhr.responseJSON.errors;
			showErrors(errors);
		}).always(function () {
			$('.loading').hide();
		});
	});

	$('#tbl_name_body').on('click', '.btn_add_option', function () {
		$('#dropdown_name').html($(this).attr('data-description'));
		$('#dropdown_id').val($(this).attr('data-id'));
		$('#option_description').prop('readonly', false);
		getOption($(this).attr('data-id'));
	});

	$('#tbl_name_body').on('click', '.btn_edit_name', function () {
		$('#id').val($(this).attr('data-id'));
		$('#description').val($(this).attr('data-description'));
	});

	$('#frm_options').on('submit', function (e) {
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
				clear();
				DropdownOptionDataTable(data.option);
			}
		}).fail(function (xhr, textStatus, errorThrown) {
			var errors = xhr.responseJSON.errors;
			showErrors(errors);
		}).always(function () {
			$('.loading').hide();
		});
	});

	$('#tbl_option_body').on('click', '.btn_edit_option', function () {
		$('#dropdown_id').val($(this).attr('data-dropdown_id'));
		$('#option_id').val($(this).attr('data-id'));
		$('#option_description').val($(this).attr('data-option_description'));
	});
});

function clear() {
	$('.clear').val('');
}

function getName(data) {
	if (data.length > 0) {
		DropdownNameDataTable(data);
	} else {
		$.ajax({
			url: '../../dropdown/show-name',
			type: 'GET',
			dataType: 'JSON',
			data: { _token: token }
		}).done(function (data, textStatus, xhr) {
			DropdownNameDataTable(data);
		}).fail(function (xhr, textStatus, errorThrown) {
			console.log("error");
		}).always(function () {
			$('.loading').hide();
		});
	}
}

function getOption(id) {
	$.ajax({
		url: '../../dropdown/show-option',
		type: 'GET',
		dataType: 'JSON',
		data: {
			_token: token,
			dropdown_id: id
		}
	}).done(function (data, textStatus, xhr) {
		options = data;
		DropdownOptionDataTable(options);
	}).fail(function (xhr, textStatus, errorThrown) {
		console.log("error");
	}).always(function () {
		$('.loading').hide();
	});
}

function DropdownNameDataTable(arr) {

	$('#tbl_name').dataTable().fnClearTable();
	$('#tbl_name').dataTable().fnDestroy();
	$('#tbl_name').dataTable({
		data: arr,
		sorting: false,
		searching: false,
		paging: false,
		deferRender: true,
		columns: [{ data: function data(x) {
				return '<input type="checkbox" class="check_item_name">';
			} }, { data: 'description' }, { data: function data(x) {
				var edit = '';
				if (user_type == 'Administrator') {
					edit = '<button class="btn btn-sm btn-info btn_edit_name" data-id="' + x.id + '" ' + ' data-description="' + x.description + '">' + '<i class="fa fa-edit"></i>' + '</button>';
				}

				return '<div class="btn-group">' + '<button class="btn btn-sm btn-success btn_add_option" data-id="' + x.id + '" ' + ' data-description="' + x.description + '">' + '<i class="fa fa-plus"></i>' + '</button>' + edit + '</div>';
			}, searchable: false, orderable: false }]
	});
}

function DropdownOptionDataTable(arr) {
	$('#tbl_option').dataTable().fnClearTable();
	$('#tbl_option').dataTable().fnDestroy();
	$('#tbl_option').dataTable({
		data: arr,
		sorting: false,
		searching: false,
		paging: false,
		deferRender: true,
		columns: [{ data: function data(x) {
				return x.option_description + '<input type="hidden" name="option_description[]" value="' + x.option_description + '">';
			} }, { data: function data(x) {
				return '<div class="btn-group">' + '<button class="btn btn-sm btn-info btn_edit_option" data-id="' + x.id + '" ' + ' data-dropdown_id="' + x.dropdown_id + '" ' + ' data-option_description="' + x.option_description + '">' + '<i class="fa fa-edit"></i>' + '</button>' + '</div>';
			}, searchable: false, orderable: false }]
	});
}

/***/ })

/******/ });