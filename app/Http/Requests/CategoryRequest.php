<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch ($this->method()) {
            case 'POST':
                return [
                    'title' => 'required|unique:categories',
                    'description' => 'required'
                ];
            case 'PUT':
            case 'PATCH': {
                return [
                    'title' => 'required|unique:categories,title,'.$this->route()->parameter('category')->id,
                    'description' => 'required'
                ];
            }
            default:
                break;
        }
    }
}
