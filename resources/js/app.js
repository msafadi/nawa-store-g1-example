import './bootstrap';

// import Alpine from 'alpinejs';

// window.Alpine = Alpine;

// Alpine.start();

// Channels type: private, public, presence
Echo.private('App.Models.User.' + userId) // Subscribe to private channel
    .notification(function (data) {
        // Listen to notification event
        alert(data.title);
        $('#notifications-list').prepend(`<div class="dropdown-divider"></div>
        <a href="${data.link}?notification_id=${data.id}" class="dropdown-item">
            ${data.icon}
            <strong>${data.title}</strong>
            <span class="float-right text-muted text-sm">now</span>
        </a>`);
        $('.notifications-count').each(function() {
            $(this).text( Number($(this).text()) + 1 );
        });
    });