<?php

namespace App\Http\Requests\Admin\Products;

use App\Enum\Permissions\Product;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::user()->can(Product::CREATE->value);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title'=>['required', 'string', 'min:2', 'unique:products,id'],
            'SKU'=>['required', 'string', 'min:5', 'unique:products,id'],
            'description'=>['nullable', 'string', 'min:5'],
            'price'=>['required', 'numeric'],
            'discount'=>['nullable', 'numeric'],
            'quantity'=>['required', 'numeric'],
            'thumbnail'=>['nullable', 'file'],
            'categories.*'=>['required', 'exists:categories,id'],
            'images.*'=>[ 'image:jpg,jpeg,png'],
        ];
    }
}
