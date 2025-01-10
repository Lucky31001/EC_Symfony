document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.like-button').forEach(button => {
        console.log(button);
        const heartIcon = button.querySelector('.heart-icon');
        heartIcon.classList.add('text-gray-500', 'ki-outline');
        heartIcon.classList.remove('text-red-500', 'ki-solid');
    });

    document.querySelectorAll('.like-button').forEach(button => {
        const activityId = button.getAttribute('data-activity-id');
        if (likes.includes(parseInt(activityId))) {
            const heartIcon = button.querySelector('.heart-icon');
            heartIcon.classList.add('text-red-500', 'ki-solid');
            heartIcon.classList.remove('text-gray-500', 'ki-outline');
        }
    });
});

document.querySelectorAll('.like-button').forEach(button => {
    button.addEventListener('click', function(event) {
        event.preventDefault();

        const heartIcon = this.querySelector('.heart-icon');
        heartIcon.classList.toggle('text-red-500');
        heartIcon.classList.toggle('text-gray-500');
        heartIcon.classList.toggle('ki-solid');
        heartIcon.classList.toggle('ki-outline');

        const activityId = this.getAttribute('data-activity-id');

        jsonData = { activityId: activityId };
        console.log(jsonData);

        const xhr = new XMLHttpRequest();
        xhr.open('POST', `/like`, true);
        xhr.setRequestHeader('Content-Type', 'application/json');

        xhr.onload = function() {
            if (xhr.status >= 200 && xhr.status < 300) {
                const response = JSON.parse(xhr.responseText);
                console.log(response.message);
            } else {
                console.error('Error:', xhr.statusText);
            }
        };

        xhr.onerror = function() {
            console.error('Request failed');
        };

        xhr.send(JSON.stringify(jsonData));
    });
});