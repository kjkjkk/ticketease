<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
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
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'contact_number' => 'nullable|string|regex:/^(\d+[-]?)*\d+$/',
            'email' => 'nullable|email|unique:users,email',
            'role' => 'required|in:Admin,Technician,Requestor',
            'signature' => 'nullable|image|mimes:png,jpg|max:2048'
        ];
    }
}
