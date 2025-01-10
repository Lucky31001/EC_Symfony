document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('bookReadForm');
    const isReadCheckbox = form.querySelector('input[name="is_read"]');
    const booksRead = [];
    const booksReading = [];

    if (form) {
        isReadCheckbox.addEventListener('change', function () {
            isReadCheckbox.value = isReadCheckbox.checked ? 1 : 0;
        });

        form.addEventListener('submit', function (event) {
            event.preventDefault();

            const formData = new FormData(form);
            const jsonData = {};
            formData.forEach((value, key) => {
                jsonData[key] = value;
            });

            jsonData['is_read'] = isReadCheckbox.checked;
            jsonData['description'] = form.querySelector('#description').value;

            const xhr = new XMLHttpRequest();
            xhr.open('POST', '/book/read', true);
            xhr.setRequestHeader('Content-Type', 'application/json');

            console.log(jsonData);
            xhr.onload = function () {
                if (xhr.status >= 200 && xhr.status < 300) {
                    const response = JSON.parse(xhr.responseText);
                    const bookRead = response.bookRead;
                    console.log(response);

                    if (response.methode === 'create') {
                        if (bookRead.is_read) {
                            booksRead.push(bookRead);
                            const tableBody = document.querySelector('#read-books-table tbody');
                            const newRow = document.createElement('tr');

                            const fullStars = Math.ceil(bookRead.rating);
                            const emptyStars = 5 - fullStars;

                            newRow.innerHTML = `
                                <td>
                                    <div class="flex flex-col gap-2">
                                        <a class="leading-none font-medium text-sm text-gray-900 hover:text-primary" href="#">
                                            ${bookRead.book}
                                        </a>
                                        <span class="text-2sm text-gray-700 font-normal leading-3">
                                            ${bookRead.description}
                                        </span>
                                    </div>
                                </td>
                                <td>${bookRead.category}</td>
                                <td>
                                    <div class="rating">
                                        ${'<div class="rating-label checked"><i class="rating-on ki-solid ki-star text-base leading-none"></i></div>'.repeat(fullStars)}
                                        ${'<div class="rating-label"><i class="rating-off ki-outline ki-star text-base leading-none"></i></div>'.repeat(emptyStars)}
                                    </div>
                                </td>
                            `;

                            tableBody.appendChild(newRow);
                            updateChart(bookRead.category);
                        } else {
                            booksReading.push(bookRead);
                            const tableBody = document.querySelector('#current-books-table tbody');
                            const newRow = document.createElement('tr');

                            newRow.innerHTML = `
                                <td>
                                    <div class="flex flex-col gap-2">
                                        <a class="leading-none font-medium text-sm text-gray-900 hover:text-primary" href="#">
                                            ${bookRead.book}
                                        </a>
                                        <span class="text-2sm text-gray-700 font-normal leading-3">
                                            ${bookRead.description}
                                        </span>
                                    </div>
                                </td>
                                <td class="text-end">
                                    ${new Date(bookRead.updated_at).toLocaleDateString('fr-FR')} à ${new Date(bookRead.updated_at).toLocaleTimeString('fr-FR', { hour: '2-digit', minute: '2-digit' })}
                                </td>
                            `;

                            tableBody.appendChild(newRow);
                        }
                    }

                    form.reset();
                    document.querySelector('[data-modal-toggle="#book_modal"]').click();
                } else {
                    try {
                        const response = JSON.parse(xhr.responseText);
                        alert('An error occurred: ' + response.message);
                    } catch (e) {
                        console.error('Error parsing JSON:', e);
                        alert('An error occurred while processing the response.');
                    }
                }
            };

            xhr.onerror = function () {
                alert('An error occurred during the request.');
            };

            xhr.send(JSON.stringify(jsonData));
        });
    } else {
        console.error('Form not found');
    }
});

document.querySelector('#book_modal').addEventListener('show', function () {

        document.querySelector('#book').value = 5;
        document.querySelector('#description').value = "ceci est un test";
        document.querySelector('[name="rating"]').value = 3.5;
        document.querySelector('[name="is_read"]').checked = true;
});
