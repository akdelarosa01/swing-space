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
}

function EmployeeList(data) {
	var list = '';
	$.each(data, function (i, x) {
		list = '<div class="col-md-6 col-lg-4 col-xxl-3">' + '<div class="card contact-item">' + '<div class="card-header border-none">' + '<ul class="actions top-right">' + '<li class="dropdown">' + '<a href="javascript:void(0)" class="btn btn-sm btn-info" data-toggle="dropdown" aria-expanded="false">' + '<i class="fa fa-cog"></i>' + '</a>' + '<div class="dropdown-menu dropdown-menu-right">' + '<div class="dropdown-header">' + 'Manage Employee' + '</div>' + '<a href="javascript:void(0)" class="dropdown-item">' + '<i class="icon dripicons-view-list"></i> View' + '</a>' + '<a href="javascript:void(0)" class="dropdown-item">' + '<i class="icon dripicons-pencil"></i> Edit' + '</a>' + '<a href="javascript:void(0)" class="dropdown-item">' + '<i class="icon dripicons-cloud-download"></i> Export' + '</a>' + '<a href="javascript:void(0)" class="dropdown-item">' + '<i class="icon dripicons-trash"></i> Remove' + '</a>' + '</div>' + '</li>' + '</ul>' + '</div>' + '<div class="card-body">' + '<div class="row">' + '<div class="col-md-12 text-center">' + '<img src="../../' + x.photo + '" alt="user" class="rounded-circle max-w-100 m-t-20">' + '</div>' + '<div class="col-md-12 text-center">' + '<h5 class="card-title">' + x.firstname + ' ' + x.lastname + '</h5>' + '<small class="text-muted d-block">' + x.position + '</small>' + '<small class="text-muted d-block">' + x.email + '</small>' + '</div>' + '</div>' + '</div>' + '</div>' + '</div>';
		$('#employee_list').append(list);
	});
}

/***/ })

/******/ });