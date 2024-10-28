<script>
    // var reminderChannel = pusher.subscribe('reminder-channel');
    // reminderChannel.bind('form-submitted', function(data) {
    //     openModal();
    // });

    // di mag pop up ug usab kung di mo logout -----------
    var reminderChannel = pusher.subscribe('private-reminder-channel.' + "{{ auth()->user()->id }}");
    reminderChannel.bind('pusher:subscription_succeeded', function(data) {
        if (!localStorage.getItem('modalOpened')) {
        openModal();
        console.log('Working');
        localStorage.setItem('modalOpened', true); 
    }
    });

    var tickeChannel = pusher.subscribe('ticket-channel');
    tickeChannel.bind('form-submitted', function(data) {
        toastr.options.closeButton = true;
        toastr.options.positionClass = "toast-bottom-right";
        toastr.info(JSON.stringify(data.message), {timeOut: 8000});
        fetchUnreadCount();
        fetchAllNotifications()
        console.log('Working');
    });
    var ticketReassignChannel = pusher.subscribe('private-ticket-reassign.' + "{{ auth()->user()->id }}");
    ticketReassignChannel.bind('reassign-technician', function(data) {
        toastr.options.closeButton = true;
        toastr.options.positionClass = "toast-bottom-right";
        toastr.info(JSON.stringify(data.message), {timeOut: 8000});
        console.log('Working');
        fetchUnreadCount();
        fetchAllNotifications()
    });
</script>