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
        if (element === null) {
            return;
        }
        this.pagination = element.querySelector('.js-filter-pagination');
        this.content = element.querySelector('.js-filter-content');
        this.form = element.querySelector('.js-filter-form');
        this.sorting = element.querySelector('.js-filter-sorting');
        this.bindEvents();
    }

    /**
     * Ajoute les comportements aux différents élements
     */
    bindEvents() {
        const aClickListener = (e) => {
            if (e.target.tagName === 'A') {
                e.preventDefault();
                this.loadUrl(a.getAttribute('href'));
            }
        };
        this.sorting.addEventListener('click', aClickListener);
        this.pagination.addEventListener('click', aClickListener);
        this.form.querySelectorAll('input[type=checkbox]').forEach((input) => {
            input.addEventListener('change', this.loadForm().bind(this));
        });
    }

    async loadForm() {
        const data = new FormData(this.form);
        const url = new URL(this.form.getAttribute('action') || window.location.href);
        const params = new URLSearchParams();
        data.forEach((value, key) => {
            params.append(key, value);
        });
        return this.loadUrl(`${url.pathname} ? ${params.toString()}`);
    }

    async loadUrl(url) {
        const ajaxURL = `${url}&ajax=1`;
        const response = await fetch(ajaxURL, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
            },
        });
        if (response.status >= 200 && response.status < 300) {
            const data = await response.json();
            this.content.innerHTML = data.content;
            this.sorting.innerHTML = data.sorting;
            // params contient l'url
            params.delete('ajax'); // On ne veut pas que le paramètre "ajax" se retrouve dans l'URL
            history.replaceState({}, '', `${url.split('?')[0]}?${params.toString()}`);
        } else {
            console.error(response);
        }
    }
}
