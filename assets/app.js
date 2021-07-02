/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';
import '@fortawesome/fontawesome-free/js/fontawesome';
import '@fortawesome/fontawesome-free/js/solid';
import '@fortawesome/fontawesome-free/js/regular';
import '@fortawesome/fontawesome-free/js/brands';

// start the Stimulus application
import './bootstrap';

// js for carousel on the home page
import './js/caroussel';

// js for login page
import './js/login';

// js for register page
import './js/register';

require('bootstrap');
require('jquery');
require('slick-carousel');
