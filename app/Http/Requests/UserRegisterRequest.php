<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
class UserRegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
//        $authorization = $this->headers->get('authorization');
//        $hash = Hash::make($this->server->get('REQUEST_TIME'));
//        return $authorization === $hash;
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
            //
            'email' => 'sometimes|required|string|email|max:255',
            'username' => 'sometimes|required|string',
            'social_type' => 'required|numeric|min:1|max:4',
            'link' => 'sometimes|required|string',
            'sns_access_token' => 'sometimes|required|string',
            'sns_account_id' => 'required|digits_between:1,30',
            'avatar' => 'sometimes|required|string',
            'secret_token' => 'sometimes|required|string',
        ];
    }
}
