<?php
namespace App\Http\Requests\Order;
use Illuminate\Foundation\Http\FormRequest;

class CreateOrderRequest extends FormRequest
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
            'name' => ['required', 'string', 'min:3', 'max:40'],
            'lastname' => ['required', 'string', 'min:3', 'max:50'],
            'city' => ['required', 'string', 'min:3', 'max:50'],
            'address' => ['required', 'string', 'min:3', 'max:50'],
            'email' => ['required', 'string', 'email'],
            'phone' => ['required', 'string',],
        ];
    }
}
