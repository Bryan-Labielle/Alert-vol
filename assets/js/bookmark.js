// AJAX for Bookmarks

// eslint-disable-next-line no-use-before-define
document.querySelectorAll('.bookmarkPin').forEach((bookmark) => { bookmark.addEventListener('click', addToBookmarks); });
function addToBookmarks(event) {
    // Get the link objet you click on the DOM
    const bookmarksLink = event.currentTarget;
    const id = event.currentTarget.dataset.bookmark;
    const link = `/annonce/${id}/bookmark`;
    // Send an HTTP request with fetch to the URI defined in the href
    fetch(link)
        // Extract the JSON from the response
        .then((res) => res.json())
        // Update the Bookmark icon
        .then((res) => {
            // eslint-disable-next-line no-console
            const bookmarksIcon = bookmarksLink.firstElementChild;
            if (res.isInBookmarks) {
                bookmarksIcon.classList.add('bookmark-position-yellow'); // turn the color of bookmark on Yellow
                bookmarksIcon.classList.remove('bookmark-position-transparent');
            } else {
                bookmarksIcon.classList.remove('bookmark-position-yellow');
                bookmarksIcon.classList.add('bookmark-position-transparent');
            }
        });
}
