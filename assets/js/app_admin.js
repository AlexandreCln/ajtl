// CSS
import '../scss/app_admin.scss';

// jQuery
const $ = require('jquery');

// Packages
require('bootstrap');

// Custom JavaScript
import * as dashboard from './pages/admin/dashboard.js';
dashboard.toggleMenu();
