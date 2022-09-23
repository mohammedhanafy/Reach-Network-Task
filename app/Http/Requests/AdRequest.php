<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdRequest extends FormRequest
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
                    'title' => 'required|unique:ads',
                    'description' => 'required',
                    'type' => 'required|in:free,paid',
                    'start_date' => 'required|date',
                    'category_id' => 'required|integer|exists:categories,id',
                    'user_id' => 'required|integer|exists:users,id',
                    'tags' => 'required|array',
                    'tags.*'  => "required|integer|distinct|exists:tags,id",
                ];
            case 'PUT':
            case 'PATCH': {
                return [
                    'title' => 'required|unique:ads,title,'.$this->route()->parameter('ad')->id,
                    'description' => 'required',
                    'type' => 'required|in:free,paid',
                    'start_date' => 'required|date',
                    'category_id' => 'required|integer|exists:categories,id',
                    'user_id' => 'required|integer|exists:users,id',
                    'tags' => 'required|array',
                    'tags.*'  => "required|integer|distinct|exists:tags,id",
                ];
            }
            default:
                break;
        }
    }
}
