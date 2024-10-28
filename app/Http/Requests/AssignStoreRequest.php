<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class AssignStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::user()->role === 'Admin';
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'if_priority' => $this->boolean('if_priority'),
        ]);
    }

    public function rules(): array
    {
        return [
            'ticket_id' => 'required|integer|exists:tickets,id',
            'technician_id' => 'required|integer|exists:users,id',
            'assigned_by' => 'required|integer|exists:users,id',
            'if_priority' => 'required|boolean',
        ];
    }
}
