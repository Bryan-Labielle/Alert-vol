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
import './js/autocomplete_zip';


// js for bookmarks
import './js/bookmark';

// eslint-disable-next-line import/extensions
import Filter from './js/filter.js';

window.bootstrap = require('bootstrap');
window.$ = window.jQuery = require('jquery');
require('slick-carousel');

new Filter(document.querySelector('js-filter'));

// AJAX for Bookmarks
/*
document.querySelector('#bookmark').addEventListener('click', addToBookmarks);
*/

// eslint-disable-next-line no-use-before-define
document.querySelectorAll('.cacahouete').forEach((bookmark) => { bookmark.addEventListener('click', addToBookmarks); });
function addToBookmarks(event) {
    // Get the link objet you click on the DOM
    const bookmarksLink = event.currentTarget;
    const id = event.currentTarget.dataset.cacahouete;
    const link = `/annonce/${id}/bookmark`;
    // Send an HTTP request with fetch to the URI defined in the href
    fetch(link)
    // Extract the JSON from the response
        .then((res) => res.json())
    // Update the Bookmark icon
        .then((res) => {
            // eslint-disable-next-line no-console
            console.log(res);
            const bookmarksIcon = bookmarksLink.firstElementChild;
            if (res.isInBookmarks) {
                bookmarksIcon.classList.add('bookmark-position-yellow'); // turn the color of bookmark on Yellow
                bookmarksIcon.classList.remove('bookmark-position-transparent');
            } else {
                bookmarksIcon.class.remove('bookmark-position-yellow');
                bookmarksIcon.class.add('bookmark-position-transparent');
            }
            // eslint-disable-next-line no-undef
            initCollection('ul.bookmark');
            // eslint-disable-next-line no-console
        })/* .catch(error => console.error(error)) */;
}

// AJAX for Bookmarks
/*
document.querySelector('#bookmark').addEventListener('click', addToBookmarks);
*/

// eslint-disable-next-line no-use-before-define
document.querySelectorAll('.cacahouete').forEach(bookmark => {bookmark.addEventListener('click', addToBookmarks)})
function addToBookmarks(event) {
    // Get the link objet you click on the DOM
    const bookmarksLink = event.currentTarget;
    const id = event.currentTarget.dataset.cacahouete;
    const link = `/annonce/${id}/bookmark`;
    // Send an HTTP request with fetch to the URI defined in the href
    fetch(link)
    // Extract the JSON from the response
        .then((res) => res.json())
    // Update the Bookmark icon
        .then((res) => {
            // eslint-disable-next-line no-console
            console.log(res);
            const bookmarksIcon = bookmarksLink.firstElementChild;
            if (res.isInBookmarks) {
                bookmarksIcon.classList.add('bookmark-position-yellow'); // turn the color of bookmark on Yellow
                bookmarksIcon.classList.remove('bookmark-position-transparent');
            } else {
                bookmarksIcon.class.remove('bookmark-position-yellow');
                bookmarksIcon.class.add('bookmark-position-transparent');
            }
            // eslint-disable-next-line no-undef
            initCollection('ul.bookmark');
            // eslint-disable-next-line no-console
        })/* .catch(error => console.error(error)) */;
}
