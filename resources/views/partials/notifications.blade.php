<script>
    function fetchUnreadCount() {
        $.ajax({
            url: "{{ route('notifications.unread-count') }}",
            method: 'GET',
            success: function(data) {
                $('#unread-count').text(data);
                $('#unread-count-seeAllNotfication').text(data);
            }
        });
    }
    
    // Fetch all notifications
    function fetchAllNotifications() {
        $.ajax({
        url: "{{ route('notifications.all') }}",
        method: 'GET',
        success: function(notifications) {
            let notificationList = '';
            notifications.forEach(function(notification) {
            let icon = notification.icon;
            notificationList += `
            <li class="dropdown-item notification-container ${notification.if_read ? '' : 'unread'}">
                <div class="col-12 d-flex">
                    <div class="icon-circle">
                        <img src="{{ url('img/notification/${icon}.png') }}" alt="" class="img-fluid">
                    </div>
                    <div class="notification-content">
                        <div class="d-flex flex-wrap justify-content-between ">
                            <h6 class="fw-semibold text-${notification.if_read ? 'secondary' : 'dark'}">
                                ${notification.title}
                            </h6>
                            <small>${moment(notification.created_at).fromNow()}</small>
                        </div>
                        <small class="message mb-0 text-secondary">${notification.message}</small>
                        <div class="d-flex justify-content-between text-secondary">
                            <small class="fw-bold mark-unread" data-id="${notification.id}">
                                Mark as ${notification.if_read ? 'unread' : 'read'}
                            </small>
                            ${notification.if_read ? '<i class="fi fi-ss-check-circle text-primary"></i>' : ''}
                        </div>
                    </div>
                </div>
            </li>`;
            });
            $('#notification-list').html(notificationList);
            }
        });
    }

    $(document).ready(function() {
        // Initial data fetch when page loads
        fetchUnreadCount();
        fetchAllNotifications();
        
        // Reload notifications and unread count when the bell is clicked
        $('#notificationDropdown').on('click', function() {
            fetchUnreadCount();
            fetchAllNotifications();
        });
        
        // Mark all notifications as read
        $('#mark-all-read').on('click', function() {
            $.ajax({
                url: "{{ route('notifications.mark-all-read') }}",
                method: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                },
                success: function() {
                    fetchUnreadCount();
                    fetchAllNotifications();
                }
            });
        });
        
        // Handle mark as read/unread
        $(document).on('click', '.mark-unread', function() {
            const notificationId = $(this).data('id');
            $.ajax({
                url: `/notifications/toggle-read/${notificationId}`,
                method: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                },
                success: function() {
                    fetchUnreadCount();
                    fetchAllNotifications();
                }
            });
        });
    });
</script>