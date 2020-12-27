<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            "logUsername" => "required|regex:/^[A-Za-z]{6,15}[\d]{1,5}$/",
            "logPass" =>  "required|regex:/[\d\w\@\$\^\*\-\.\_\!\+\=\)\(\{\}\?\/\<\>]{6,13}/"
        ];
    }

    public function messages(){
        return [
            "logUsername.required" => "Enter your username.",
            "logUsername.regex" => "Username must contain at least 6 characters and at least 1 number.",
            "logPass.required" =>  "Enter your password.",
            "logPass.regex" => "Password must contain at least 6 characters."
        ];
    }
}
