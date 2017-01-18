<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConnectionRequest extends FormRequest
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
            'user_name'     => 'required',
            'user_password' => 'required',
        ];
    }
}
