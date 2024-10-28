<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Ticket;
use App\Models\TicketNature;
use App\Models\User;

class TicketStoreRequest extends FormRequest
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
            'requestor_id' => [
                'required',
                'integer',
                'exists:users,id',
                function ($attribute, $value, $fail) {
                    $user = User::find($value);
                    if ($user === null) {
                        $fail('This user does not exist!');
                    } elseif ($user->role !== 'Requestor') {
                        $fail('This user is not a Requestor.');
                    }
                },
            ],
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
            'requestor_id.exists' => 'This user does not exist!',
            'ticket_nature_id.required' => 'Please select a ticket nature.',
            'district_id.required' => 'Please select a district.',
            'department.required' => 'Please enter the department name. Type N/A if not applicable.',
            'device_id.required' => 'Please select a device. Select N/A if not applicable.',
            'brand.required' => 'Please enter the brand. Type N/A if not applicable.',
            'model.required' => 'Please enter the model. Type N/A if not applicable.',
            'property_no.required' => 'Please enter the property number. Type N/A if not applicable.',
            'serial_no.required' => 'Please enter the serial number. Type N/A if not applicable.',
            'details.required' => 'Please provide details about your ticket request.',
        ];
    }

    public function checkRequestorTickets($requestor_id, $ticket_nature_id): array
    {
        // Check if the user has a pending ticket with the same ticket_nature_id
        $pendingTicket = Ticket::where('requestor_id', $requestor_id)
            ->where('ticket_nature_id', $ticket_nature_id)
            ->whereIn('status_id', [1, 2, 3]) // Checking for pending statuses
            ->first();

        if ($pendingTicket) {
            // Fetch the related TicketNature model
            $nature = $pendingTicket->ticketNature;

            // If a pending ticket with the same nature exists
            $message = "You have a pending " . $nature->ticket_nature_name . " request, you cannot make this request.";
            return [true, $pendingTicket->status_id, $message];
        }

        // No pending ticket found
        return [false, null, null];
    }
}
