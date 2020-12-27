<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMovieRequest extends FormRequest
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
            "picMovUpd" => "nullable|mimes:jpeg,jpg,png",
            "picMovBgUpd" => "nullable|mimes:jpeg,jpg,png",
            "picSliderMovUpd" => "nullable|mimes:jpeg,jpg,png"
        ];
    }

    public function messages(){
        return[
            "picMovUpd.mimes" => "Picture must be jpeg, jpg or png.",
            "picMovBgUpd.mimes" => "Picture must be jpeg, jpg or png.",
            "picSliderMovUpd.mimes" => "Picture must be jpeg, jpg or png."
        ];
    }
}
