<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use App\Enums\OrderStatus;
use Illuminate\Validation\Rule;
class StoreOrderRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'store_id' => ['required','integer', 'exists:stores,id'],

            'items'            => ['required', 'array', 'min:1'],
            'items.*.item_name'     => ['required', 'string', 'max:255'], 
            'items.*.details'  => ['nullable', 'string', 'max:1000'],
        ];
    }
}
