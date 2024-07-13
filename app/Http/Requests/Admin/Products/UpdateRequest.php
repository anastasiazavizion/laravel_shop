<?php

namespace App\Http\Requests\Admin\Products;

use App\Enum\Permissions\Product;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        //check if user can work with this resource
        return Auth::user()->can(Product::EDIT->value);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title'=>['required', 'string', 'min:2', Rule::unique('products', 'title')->ignore(request('id'))],
            'SKU'=>['required', 'string', 'min:5', 'unique:products,id'],
            'description'=>['nullable', 'string', 'min:5'],
            'price'=>['required', 'numeric'],
            'discount'=>['nullable', 'numeric'],
            'quantity'=>['required', 'numeric'],
            'categories.*'=>['required', 'exists:categories,id'],
        ];
    }
}
