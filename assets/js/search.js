// assets/js/search.js

document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.querySelector('#search_modal input[name="query"]');
    const searchResultsContainer = document.querySelector('#search_modal .menu .grid');

    searchInput.addEventListener('input', function() {
        const query = searchInput.value;
        performSearch(query);
    });

    function performSearch(query) {
        fetch(`/search?query=${query}`)
            .then(response => response.json())
            .then(data => {
                searchResultsContainer.innerHTML = '';
                data.forEach(activity => {
                    const resultItem = document.createElement('div');
                    resultItem.classList.add('menu-item');
                    resultItem.innerHTML = `
                        <div class="menu-link flex justify-between gap-2">
                            <div class="flex items-center gap-2.5">
                                <img alt="Cover" class="rounded-full size-9 shrink-0" src="${activity.cover}" />
                                <div class="flex flex-col">
                                    <a class="text-sm font-semibold text-gray-900 hover:text-primary-active mb-px" href="#">
                                        ${activity.bookName}
                                    </a>
                                    <span class="text-2sm font-normal text-gray-500">
                                        ${activity.bookDescription}
                                    </span>
                                </div>
                            </div>
                            <div class="flex items-center gap-2.5">
                                <div class="rating">
                                    ${[...Array(activity.rating)].map(() => `
                                        <div class="rating-label checked">
                                            <i class="rating-on ki-solid ki-star text-base leading-none"></i>
                                            <i class="rating-off ki-outline ki-star text-base leading-none"></i>
                                        </div>
                                    `).join('')}
                                </div>
                            </div>
                        </div>
                    `;
                    searchResultsContainer.appendChild(resultItem);
                });
            });
    }
});