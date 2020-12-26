// CSS
import '../scss/app.scss';

// jQuery
const $ = require('jquery');

// Packages
require('bootstrap');
$(document).ready(function() {
    $('[data-toggle="popover"]').popover();
});

// Custom JS
import * as navbar from "./common/navbar";
navbar.toggleMenu();