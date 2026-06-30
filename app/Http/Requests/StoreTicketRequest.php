<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
class StoreTicketRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [

            'title' => [
                'required',
                'string',
                'max:255'
            ],

            'category_id' => [
                'required',
                'exists:categories,id'
            ],

            'priority_id' => [
                'required',
                'exists:priorities,id'
            ],

            'description' => [
                'required',
                'string'
            ],

        ];
    }

    public function attributes(): array
    {
        return [

            'category_id' => 'category',

            'priority_id' => 'priority',

        ];
    }
}