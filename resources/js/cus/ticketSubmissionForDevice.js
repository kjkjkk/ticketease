document.addEventListener("DOMContentLoaded", function () {
    const deviceSelect = document.querySelector('select[name="device_id"]');
    const brandInput = document.querySelector('input[name="brand"]');
    const modelInput = document.querySelector('input[name="model"]');
    const propertyNoInput = document.querySelector('input[name="property_no"]');
    const serialNoInput = document.querySelector('input[name="serial_no"]');

    deviceSelect.addEventListener("change", function () {
        if (this.value == "1") {
            const NOT_APPLICABLE = "N/A";
            // Pre-fill the inputs
            brandInput.value = NOT_APPLICABLE;
            modelInput.value = NOT_APPLICABLE;
            propertyNoInput.value = NOT_APPLICABLE;
            serialNoInput.value = NOT_APPLICABLE;
            // Make inputs readonly instead of disabled
            brandInput.readOnly = true;
            modelInput.readOnly = true;
            propertyNoInput.readOnly = true;
            serialNoInput.readOnly = true;
        } else {
            // Remove the inputs value
            brandInput.value = "";
            modelInput.value = "";
            propertyNoInput.value = "";
            serialNoInput.value = "";
            // Make inputs editable again
            brandInput.readOnly = false;
            modelInput.readOnly = false;
            propertyNoInput.readOnly = false;
            serialNoInput.readOnly = false;
        }
    });

    // Trigger change event to set initial state based on the default selection
    deviceSelect.dispatchEvent(new Event("change"));
});
