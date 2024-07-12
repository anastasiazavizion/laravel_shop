<?php

namespace App\Http\Requests\Admin\Categories;

use App\Enum\Permissions\Category;
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
        return Auth::user()->can(Category::EDIT->value);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'=>['required', 'string', 'min:2', 'max:40', Rule::unique('categories', 'name')->ignore(request('id'))],
            'parent_id'=>['nullable', 'exists:categories,id', 'numeric']
        ];
    }
}
