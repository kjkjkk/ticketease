<script>

// di mag pop up ug usab kung di mo logout -----------
    var loginChannel = pusher.subscribe('private-login-channel.'  + "{{ auth()->user()->id }}");
    loginChannel.bind('pusher:subscription_succeeded', function(data) {
        if (!localStorage.getItem('modalOpened')) {
        openModal(); // Your function to open the modal
        console.log('Working');
        localStorage.setItem('modalOpened', true); // Set the flag to prevent it from opening again
    }
    });

    var ticketStatusUpdateChannel = pusher.subscribe('private-ticket-status.' + "{{ auth()->user()->id }}");
    ticketStatusUpdateChannel.bind('status-updated', function(data) {
        console.log('Working');
    toastr.options.closeButton = true;
    toastr.options.positionClass = "toast-bottom-right";
    toastr.info('Your ticket status has been updated', {timeOut: 8000});
    });
</script>