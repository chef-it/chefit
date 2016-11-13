<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRecipe extends FormRequest
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
            'name' => 'required',
            'menu_price' => 'numeric',
            'portions_per_batch' => 'numeric',
            'batch_quantity' => 'numeric',
            'batch_unit' => 'numeric',
            'component_only' => 'required'
        ];
    }
}
