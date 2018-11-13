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
/******/ 	return __webpack_require__(__webpack_require__.s = 52);
/******/ })
/************************************************************************/
/******/ ({

/***/ 52:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(53);


/***/ }),

/***/ 53:
/***/ (function(module, exports) {

$(function () {
	getEmployees();
});

function getEmployees() {
	$('.loading').show();
	$.ajax({
		url: '../../employee-show-list',
		type: 'GET',
		dataType: 'JSON',
		data: {
			_token: token
		}
	}).done(function (data, textStatus, xhr) {
		EmployeeList(data);
	}).fail(function (xhr, textStatus, errorThrown) {
		msg('Employee List: ' + errorThrown, textStatus);
	}).always(function () {
		$('.loading').hide();
	});

	$('#employee_list').on('click', '.delete-employee', function () {
		confirm('Remove Employee', 'Do you want to remove this employee?', $(this).attr('data-id'));
	});

	$('#btn_confirm').on('click', function () {
		$('.loading').show();
		$.ajax({
			url: '../../employee/delete',
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
				EmployeeList(data.employee);
			}
		}).fail(function (xhr, textStatus, errorThrown) {
			msg('Remove Employee: ' + errorThrown, textStatus);
		}).always(function () {
			$('.loading').hide();
		});
	});
}

function EmployeeList(data) {
	var list = '';
	$('#employee_list').html(list);
	$.each(data, function (i, x) {
		list = '<div class="col-md-6 col-lg-4 col-xxl-3">' + '<div class="card contact-item">' + '<div class="card-header border-none">' + '<ul class="actions top-right">' + '<li class="dropdown">' + '<a href="javascript:void(0)" class="btn btn-sm btn-info" data-toggle="dropdown" aria-expanded="false">' + '<i class="fa fa-cog"></i>' + '</a>' + '<div class="dropdown-menu dropdown-menu-right">' + '<div class="dropdown-header">' + 'Manage Employee' + '</div>' + '<a href="../../employee/' + x.id + '/edit" class="dropdown-item">' + '<i class="icon dripicons-pencil"></i> Edit' + '</a>' + '<a href="javascript:void(0)" class="dropdown-item delete-employee" data-id="' + x.id + '">' + '<i class="icon dripicons-trash"></i> Remove' + '</a>' + '</div>' + '</li>' + '</ul>' + '</div>' + '<div class="card-body">' + '<div class="row">' + '<div class="col-md-12 text-center">' + '<img src="../../' + x.photo + '" alt="user" class="rounded-circle max-w-100 m-t-20">' + '</div>' + '<div class="col-md-12 text-center">' + '<h5 class="card-title">' + x.firstname + ' ' + x.lastname + '</h5>' + '<small class="text-muted d-block">' + x.position + '</small>' + '<small class="text-muted d-block">' + x.employee_id + '</small>' + '</div>' + '</div>' + '</div>' + '</div>' + '</div>';
		$('#employee_list').append(list);
	});
}

/***/ })

/******/ });