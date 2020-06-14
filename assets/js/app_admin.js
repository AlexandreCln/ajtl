// CSS
import '../scss/app_admin.scss';

// jQuery
const $ = require('jquery');

// Packages
require('bootstrap');

// Custom JavaScript
$("#menu-toggle").click(function(e) {
    e.preventDefault();
    $("#wrapper").toggleClass("toggled");
});
