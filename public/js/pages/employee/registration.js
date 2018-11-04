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

get_dropdown_options(1, '#position');
getProvince();
getModules('');

$(function () {

	if ($('#id').val() !== '') {
		show_employee($('#id').val());
	}

	$('#state').on('change', function () {
		getCity($(this).val(), '');
	});

	$('#frm_registration').on('submit', function (e) {
		e.preventDefault();
		$('.loading').show();

		var data = new FormData(this);
		$.ajax({
			url: $(this).attr('action'),
			type: 'POST',
			dataType: 'JSON',
			data: data,
			mimeType: "multipart/form-data",
			contentType: false,
			cache: false,
			processData: false
		}).done(function (data, textStatus, xhr) {
			if (textStatus == 'success') {
				msg(data.msg, data.status);
			}
		}).fail(function (xhr, textStatus, errorThrown) {
			var errors = xhr.responseJSON.errors;
			showErrors(errors);

			if (errorThrown == "Internal Server Error") {
				msg('Employee Registration: ' + errorThrown, textStatus);
			}
		}).always(function () {
			$('.loading').hide();
		});
	});
});

function show_employee(id) {
	$.ajax({
		url: '../../employee/show',
		type: 'GET',
		dataType: 'JSON',
		data: {
			_token: token,
			id: id
		}
	}).done(function (data, textStatus, xhr) {
		getModules(data.id);

		$('#firstname').val(data.firstname);
		$('#lastname').val(data.lastname);
		$('#email').val(data.email);
		$('#gender').val(data.gender);
		$('#date_of_birth').val(data.date_of_birth);
		$('#position').val(data.position);
		$('#phone').val(data.phone);
		$('#mobile').val(data.mobile);
		$('#street').val(data.street);
		$('#state').val(data.state);

		$('#zip').val(data.zip);
		$('#tin').val(data.tin);
		$('#sss').val(data.sss);
		$('#philhealth').val(data.philhealth);
		$('#pagibig').val(data.pagibig);

		getCity(data.state, data.city);

		$('#profile_photo').attr('src', '../../' + data.photo);
	}).fail(function (xhr, textStatus, errorThrown) {
		msg("Employee Data: " + errorThrown, textStatus);
	});
}

/***/ })

/******/ });