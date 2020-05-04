// Custom
import '../scss/app.scss';

// jQuery
const $ = require('jquery');

// Bootstrap
require('bootstrap');

$(document).ready(function() {
    $('[data-toggle="popover"]').popover();
});
