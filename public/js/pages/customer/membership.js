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

$(function () {
	$('#phone').mask('(99)999-9999', { placeholder: '(__) ___-____' });
	$('#mobile').mask('(+63)999-999-9999', { placeholder: '(+63)___-___-____' });

	referrer('#referrer');

	$('#frm_membership').on('submit', function (e) {
		e.preventDefault();
		$.ajax({
			url: $(this).attr('action'),
			type: 'POST',
			dataType: 'JSON',
			data: $(this).serialize()
		}).done(function (data, textStatus, xhr) {
			msg(data.msg, data.status);
			assign_data_to_moodal(data.customer);
			clear();
		}).fail(function (xhr, textStatus, errorThrown) {
			var errors = xhr.responseJSON.errors;

			if (errors == undefined) {
				msg(errorThrown, textStatus);
			} else {
				showErrors(errors);
			}
		}).always(function () {
			console.log("complete");
		});
	});

	display_customer($('#id').val());
});

function clear() {
	$('.clear').val('');
}

function assign_data_to_moodal(cust) {
	$('#customer_code_v').html(cust.customer_code);
	$('#membership_type_v').html(cust.membership_type);
	$('#date_registered_v').html(cust.date_registered);
	$('#name_v').html(cust.firstname + ' ' + cust.lastname);
	$('#email_v').html(cust.email);
	$('#gender_v').html(cust.gender);
	$('#phone_v').html(cust.phone);
	$('#mobile_v').html(cust.mobile);
	$('#facebook_v').html(cust.facebook);
	$('#instagram_v').html(cust.instagram);
	$('#twitter_v').html(cust.twitter);
	$('#occupation_v').html(cust.occupation);
	$('#company_v').html(cust.company);
	$('#school_v').html(cust.school);

	$('#membership_modal').modal('show');
}

function display_customer(id) {
	if (id !== '') {
		$.ajax({
			url: '../../membership/show',
			type: 'GET',
			dataType: 'JSON',
			data: {
				_token: token,
				id: id
			}
		}).done(function (data, textStatus, xhr) {
			$('#firstname').val(data.firstname);
			$('#lastname').val(data.lastname);
			$('#email').val(data.email);
			$('#gender').val(data.gender);
			$('#phone').val(data.phone);
			$('#mobile').val(data.mobile);
			$('#facebook').val(data.facebook);
			$('#instagram').val(data.instagram);
			$('#twitter').val(data.twitter);
			$('#occupation').val(data.occupation);
			$('#company').val(data.company);
			$('#school').val(data.school);
			$('#referrer').val(data.referrer_id);
			$('#date_of_birth').val(data.date_of_birth);
			$('#membership_type').val(data.membership_type);

			if (data.disable) {
				$('#disable').prop('checked', true);
			}
		}).fail(function (xhr, textStatus, errorThrown) {
			console.log("error");
		}).always(function () {
			console.log("complete");
		});
	}
}

/***/ })

/******/ });