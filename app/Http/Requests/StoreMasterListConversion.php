<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMasterListConversion extends FormRequest
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
        return [
            'left_quantity' => 'required|numeric',
            'right_quantity' => 'required|numeric',
            'left_unit' => 'required',
            'right_unit' => 'required'
        ];
    }
}
