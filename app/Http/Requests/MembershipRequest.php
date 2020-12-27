<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MembershipRequest extends FormRequest
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
            "memName" => "required|regex:/^[A-Za-z]{6,15}(\s[A-Za-z]{6,15})*$/",
            "memLastname" =>  "required|regex:/^[A-Za-z]{6,15}(\s[A-Za-z]{6,15})*$/",
            "memEmail" => "required|email"
        ];
    }

    public function messages(){
        return [
            "memName.required" => "Enter your firstname.",
            "memName.regex" => "Firstname is not in valid format.",
            "memLastname.required" =>  "Enter your lastname.",
            "memLastname.regex" => "Lastname is not in valid format.",
            "memEmail.required" => "Enter your email.",
            "memEmail.regex" => "Email is not in valid format"
        ];
    }
}
