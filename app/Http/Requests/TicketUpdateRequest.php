<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TicketUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'id' => 'required|integer|exists:tickets,id',
            'ticket_nature_id' => 'required|integer|exists:ticket_natures,id',
            'district_id' => 'required|integer|exists:districts,id',
            'department' => 'required|min:2|max:50',
            'device_id' => 'required|integer|exists:devices,id',
            'brand' => 'required|min:2|max:50',
            'model' => 'required|min:2|max:50',
            'property_no' => 'required|min:2|max:50',
            'serial_no' => 'required|min:2|max:50',
            'details' => 'required|min:5|max:300',
        ];
    }

    public function messages(): array
    {
        return [
            'id.exists' => 'This ticket does not exist!',
            'ticket_nature_id.required' => 'Please select a ticket nature.',
            'district_id.required' => 'Please select a district.',
            'department.required' => 'Please enter the department name. Type NA if not applicable.',
            'device_id.required' => 'Please select a device. Select NA if not applicable.',
            'brand.required' => 'Please enter the brand. Type NA if not applicable.',
            'model.required' => 'Please enter the model. Type NA if not applicable.',
            'property_no.required' => 'Please enter the property number. Type NA if not applicable.',
            'serial_no.required' => 'Please enter the serial number. Type NA if not applicable.',
            'details.required' => 'Please provide details about your ticket request.',
        ];
    }
}
