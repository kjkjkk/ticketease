<script>
    // var reminderChannel = pusher.subscribe('technician-reminder-channel');
    // reminderChannel.bind('form-submitted', function(data) {
    //     openModal();
    // });
    
    // di mag pop up ug usab kung di mo logout -----------
    var reminderChannel = pusher.subscribe('private-technician-reminder-channel.' + "{{ auth()->user()->id }}");
    reminderChannel.bind('pusher:subscription_succeeded', function(data) {
        if (!localStorage.getItem('modalOpened')) {
        openModal();
        console.log('Working');
        localStorage.setItem('modalOpened', true); 
    }
    });

    var ticketAssignChannel = pusher.subscribe('private-ticket-assign.' + "{{ auth()->user()->id }}");
    ticketAssignChannel.bind('assign-technician', function(data) {
        toastr.options.closeButton = true;
        toastr.options.positionClass = "toast-bottom-right";
        toastr.info(JSON.stringify(data.message), {timeOut: 8000});
        console.log('Working');
        fetchUnreadCount();
        fetchAllNotifications();
    });

    var ticketReassignChannel = pusher.subscribe('private-ticket-reassign.' + "{{ auth()->user()->id }}");
    ticketReassignChannel.bind('reassign-technician', function(data) {
        console.log(data);
        toastr.options.closeButton = true;
        toastr.options.positionClass = "toast-bottom-right";
        toastr.info(JSON.stringify(data.message), {timeOut: 8000});
        console.log('Working');
        fetchUnreadCount();
        fetchAllNotifications();
    });
</script>