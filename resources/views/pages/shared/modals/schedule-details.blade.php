<x-modal id="scheduleDetails" title="Schedule Details" size="md">
    <div class="row fw-bold">
        <div class="col-4">
            <p>Ticket #<span class="fw-normal" id="ticketId"></span></p>
        </div>
        <div class="col-8">
            <p>Date Assigned:
                <span class="fw-normal" id="dateAssigned"></span>
            </p>
        </div>
    </div>
    <div class="row fw-bold">
        <div class="col-4">
            <p>Type: <span class="fw-normal" id="ticketNature"></span></p>
        </div>
        <div class="col-8">
            <p>District: <span class="fw-normal" id="district"></span></p>
        </div>
    </div>
    <div class="row fw-bold mb-3">
        <div class="col-4">
            <p>Department: <span class="fw-normal" id="department"></span></p>
        </div>
        <div class="col-8">
            <p>Date Submitted: <span class="fw-normal" id="created_at"></span></p>
        </div>
    </div>

    <form action="{{ route('shared.calendar.edit') }}" method="POST">
        @csrf
        @method('PUT')

        <input type="hidden" name="schedule_id" id="schedId" readonly>
        <div class="mb-3">
            <label for="start_time" class="fw-bold">Start Time</label>
            <input type="datetime-local" class="form-control bg-white" name="start_time" id="startTime" required>
        </div>

        <div class="mb-3">
            <label for="end_time" class="fw-bold">Estimated Finish Time</label>
            <input type="datetime-local" class="form-control bg-white" name="end_time" id="endTime" required>
        </div>


        <div class="mb-3">
            <label for="comments" class="fw-bold">Comments</label>
            <textarea name="comments" id="comments" class="form-control bg-white"></textarea>
        </div>

        <hr>
        <div class="float-end">
            <x-cancel-button>Close</x-cancel-button>
            <x-submit-button>Reschedule</x-submit-button>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const startTimeInput = document.getElementById('startTime');
            const endTimeInput = document.getElementById('endTime');

            if (startTimeInput && endTimeInput) {
                function checkStartTime() {
                    if (startTimeInput.value) {
                        endTimeInput.disabled = false;
                        endTimeInput.min = startTimeInput.value;
                    } else {
                        endTimeInput.disabled = true;
                        endTimeInput.min = '';
                    }
                }

                checkStartTime();
                startTimeInput.addEventListener('change', checkStartTime);
                document.getElementById('scheduleDetails').addEventListener('show.bs.modal', function() {
                    checkStartTime();
                });
            }
        });
    </script>

</x-modal>