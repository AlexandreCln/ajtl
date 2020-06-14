// CSS
import '../scss/app.scss';

// jQuery
const $ = require('jquery');

// Packages
require('bootstrap');

$(document).ready(function() {
    $('[data-toggle="popover"]').popover();
});

// Custom JavaScript
import navbar from "./common/navbar";
navbar();

console.log('here')
$("#menu-toggle").click(function(e) {
    console.log('clicked')
    e.preventDefault();
    $("#wrapper").toggleClass("toggled");
});
