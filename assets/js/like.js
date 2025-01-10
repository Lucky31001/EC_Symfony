document.querySelectorAll('.like-button').forEach(button => {
    button.addEventListener('click', function(event) {
        event.preventDefault();

        const heartIcon = this.querySelector('.heart-icon');
        heartIcon.classList.toggle('text-red-500');
        heartIcon.classList.toggle('text-gray-500');
        heartIcon.classList.toggle('ki-solid');
        heartIcon.classList.toggle('ki-outline');

        const activityId = this.getAttribute('data-activity-id');

        console.log(`Like button clicked for activity with ID ${activityId}`);
        const xhr = new XMLHttpRequest();
        xhr.open('POST', `/like/${activityId}`, true);
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

        xhr.send(JSON.stringify({ activityId: activityId }));
    });
});