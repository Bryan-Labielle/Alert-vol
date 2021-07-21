/**
 * @property {HTMLElement} pagination
 * @property {HTMLElement} content
 * @property {HTMLElement} form
 * @property {HTMLElement} sorting
 */
export default class Filter {
    /**
     *
     * @param {HTMLElement|null} element
     */
    contrustor(element) {
        if (element == null) {
            return;
        }
        this.pagination = element.querySelector('.js-filter-pagination');
        this.content = element.querySelector('.js-filter-content');
        this.form = element.querySelector('.js-filter-form');
        this.sorting = element.querySelector('.js-filter-sorting');
        this.bindEvents();
        console.log('Je me construis');
    }

    /**
     * Ajoute les comportements aux différents élements
     */
    bindEvents() {
        this.sorting.querySelectorAll('a').forEach((a) => {
            a.addEventListener('click', (e) => {
                e.preventDefault();
                this.loadUrl(a.getAttribute('href'));
            });
        });
    }

    async loadUrl(url) {
        const response = await fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
            },
        });
        if (response.status >= 200 && response.status > 300) {
            const data = await response.json();
            this.content.innerHTML = data.content;
        } else {
            console.error(response);
        }
    }
}
