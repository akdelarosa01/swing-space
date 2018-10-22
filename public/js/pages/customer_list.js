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

var customers = [{
    id: 1,
    customer_id: 'SSA-1810-00001',
    name: 'John Doe',
    ocupation: 'Programmer',
    membership: 'Level A',
    date_registered: '10/19/2018'
}, {
    id: 2,
    customer_id: 'SSA-1810-00002',
    name: 'Jane Doe',
    ocupation: 'Web Designer',
    membership: 'Level A',
    date_registered: '10/19/2018'
}, {
    id: 3,
    customer_id: 'SSB-1810-00003',
    name: 'Juan Dela Cruz',
    ocupation: 'Student',
    membership: 'Level B',
    date_registered: '10/19/2018'
}, {
    id: 4,
    customer_id: 'SSA-1810-00004',
    name: 'Sofia So',
    ocupation: 'Instructor',
    membership: 'Level A',
    date_registered: '10/19/2018'
}, {
    id: 5,
    customer_id: 'SSB-1810-00005',
    name: 'Aldrin Bayani',
    ocupation: 'Network Administrator',
    membership: 'Level B',
    date_registered: '10/19/2018'
}, {
    id: 6,
    customer_id: 'SSA-1810-00006',
    name: 'Gordon Ramsey',
    ocupation: 'Chef',
    membership: 'Level A',
    date_registered: '10/19/2018'
}, {
    id: 7,
    customer_id: 'SSB-1810-00007',
    name: 'Jimmy Kimmel',
    ocupation: 'Host',
    membership: 'Level B',
    date_registered: '10/19/2018'
}];

$(function () {
    customerTable(customers);
});

function customerTable(arr) {
    $('#tbl_customers').dataTable().fnClearTable();
    $('#tbl_customers').dataTable().fnDestroy();
    $('#tbl_customers').dataTable({
        data: arr,
        bLengthChange: false,
        searching: false,
        ordering: false,
        paging: false,
        scrollY: "250px",
        columns: [{ data: function data(x) {
                return '<img src="../../img/default-profile.png" class="w-35 rounded-circle" alt="' + x.name + '">';
            } }, { data: 'customer_id' }, { data: 'name' }, { data: 'ocupation' }, { data: 'membership' }, { data: 'date_registered' }, { data: function data(x) {
                return '<div class="btn-group">' + '<button class="btn btn-sm btn-info">Edit</button>' + '<button class="btn btn-sm btn-danger">Delete</button>' + '</button>';
            } }]
        // fnInitComplete: function() {
        //     $('.dataTables_scrollBody').slimscroll();
        // },
    });
}

/***/ })

/******/ });