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
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
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
/******/ 	__webpack_require__.p = "";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = "./index.js");
/******/ })
/************************************************************************/
/******/ ({

/***/ "./index.js":
/*!******************!*\
  !*** ./index.js ***!
  \******************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _src_sidebar_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./src/sidebar.js */ \"./src/sidebar.js\");\n/* harmony import */ var _src_sidebar_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_src_sidebar_js__WEBPACK_IMPORTED_MODULE_0__);\n// Import Index JS file\n\n\n//# sourceURL=webpack:///./index.js?");

/***/ }),

/***/ "./src/sidebar.js":
/*!************************!*\
  !*** ./src/sidebar.js ***!
  \************************/
/*! no static exports found */
/***/ (function(module, exports) {

eval("function _typeof(obj) { if (typeof Symbol === \"function\" && typeof Symbol.iterator === \"symbol\") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === \"function\" && obj.constructor === Symbol && obj !== Symbol.prototype ? \"symbol\" : typeof obj; }; } return _typeof(obj); }\n\nfunction _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError(\"Cannot call a class as a function\"); } }\n\nfunction _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if (\"value\" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }\n\nfunction _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }\n\nfunction _possibleConstructorReturn(self, call) { if (call && (_typeof(call) === \"object\" || typeof call === \"function\")) { return call; } return _assertThisInitialized(self); }\n\nfunction _getPrototypeOf(o) { _getPrototypeOf = Object.setPrototypeOf ? Object.getPrototypeOf : function _getPrototypeOf(o) { return o.__proto__ || Object.getPrototypeOf(o); }; return _getPrototypeOf(o); }\n\nfunction _inherits(subClass, superClass) { if (typeof superClass !== \"function\" && superClass !== null) { throw new TypeError(\"Super expression must either be null or a function\"); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, writable: true, configurable: true } }); if (superClass) _setPrototypeOf(subClass, superClass); }\n\nfunction _setPrototypeOf(o, p) { _setPrototypeOf = Object.setPrototypeOf || function _setPrototypeOf(o, p) { o.__proto__ = p; return o; }; return _setPrototypeOf(o, p); }\n\nfunction _assertThisInitialized(self) { if (self === void 0) { throw new ReferenceError(\"this hasn't been initialised - super() hasn't been called\"); } return self; }\n\n/**\r\n * Internal block libraries\r\n */\nvar __ = wp.i18n.__;\nvar _wp$editPost = wp.editPost,\n    PluginSidebar = _wp$editPost.PluginSidebar,\n    PluginSidebarMoreMenuItem = _wp$editPost.PluginSidebarMoreMenuItem;\nvar _wp$components = wp.components,\n    PanelBody = _wp$components.PanelBody,\n    TextControl = _wp$components.TextControl,\n    CheckboxControl = _wp$components.CheckboxControl,\n    DateTimePicker = _wp$components.DateTimePicker;\nvar _wp$element = wp.element,\n    Component = _wp$element.Component,\n    Fragment = _wp$element.Fragment;\nvar withSelect = wp.data.withSelect;\nvar compose = wp.compose.compose;\nvar registerPlugin = wp.plugins.registerPlugin;\n\nvar WP_Last_Modified_Info =\n/*#__PURE__*/\nfunction (_Component) {\n  _inherits(WP_Last_Modified_Info, _Component);\n\n  function WP_Last_Modified_Info() {\n    var _this;\n\n    _classCallCheck(this, WP_Last_Modified_Info);\n\n    _this = _possibleConstructorReturn(this, _getPrototypeOf(WP_Last_Modified_Info).apply(this, arguments));\n    _this.state = {\n      key: '_lmt_disable',\n      value: '',\n      isChecked: false\n    };\n    _this.handleChecked = _this.handleChecked.bind(_assertThisInitialized(_assertThisInitialized(_this)));\n    wp.apiFetch({\n      path: \"/wp/v2/posts/\".concat(_this.props.postId),\n      method: 'GET'\n    }).then(function (data) {\n      _this.setState({\n        value: data.meta._lmt_disable\n      });\n\n      if (_this.state.value == 'yes') {\n        _this.setState({\n          isChecked: !_this.state.isChecked\n        });\n      }\n\n      return data;\n    }, function (err) {\n      return err;\n    });\n    return _this;\n  }\n\n  _createClass(WP_Last_Modified_Info, [{\n    key: \"handleChecked\",\n    value: function handleChecked() {\n      this.setState({\n        isChecked: !this.state.isChecked,\n        value: this.state.isChecked == false ? 'yes' : ''\n      });\n    }\n  }, {\n    key: \"render\",\n    value: function render() {\n      return React.createElement(Fragment, null, React.createElement(PluginSidebarMoreMenuItem, {\n        target: \"wp-last-modified-info-sidebar\"\n      }, __('WP Last Modified Info')), React.createElement(PluginSidebar, {\n        name: \"wp-last-modified-info-sidebar\",\n        title: __('WP Last Modified Info')\n      }, React.createElement(PanelBody, null, React.createElement(CheckboxControl, {\n        label: __('Disable auto insert on frontend'),\n        value: this.state.value,\n        checked: this.state.isChecked,\n        onChange: this.handleChecked\n      }))));\n    }\n  }], [{\n    key: \"getDerivedStateFromProps\",\n    value: function getDerivedStateFromProps(nextProps, state) {\n      if ((nextProps.isPublishing || nextProps.isSaving) && !nextProps.isAutoSaving) {\n        wp.apiRequest({\n          path: \"/wp-last-modified-info/v1/update-meta?id=\".concat(nextProps.postId),\n          method: 'POST',\n          data: state\n        }).then(function (data) {\n          return data;\n        }, function (err) {\n          return err;\n        });\n      }\n    }\n  }]);\n\n  return WP_Last_Modified_Info;\n}(Component);\n\nvar WPLMI = withSelect(function (select, _ref) {\n  var forceIsSaving = _ref.forceIsSaving;\n\n  var _select = select('core/editor'),\n      getCurrentPostId = _select.getCurrentPostId,\n      isSavingPost = _select.isSavingPost,\n      isPublishingPost = _select.isPublishingPost,\n      isAutosavingPost = _select.isAutosavingPost;\n\n  return {\n    postId: getCurrentPostId(),\n    isSaving: forceIsSaving || isSavingPost(),\n    isAutoSaving: isAutosavingPost(),\n    isPublishing: isPublishingPost()\n  };\n})(WP_Last_Modified_Info);\nregisterPlugin('wp-last-modified-info', {\n  icon: 'clock',\n  render: WPLMI\n});\n\n//# sourceURL=webpack:///./src/sidebar.js?");

/***/ })

/******/ });