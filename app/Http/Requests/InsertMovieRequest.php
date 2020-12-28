<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InsertMovieRequest extends FormRequest
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
            "picMovIns" => "required",
            "picMovBgIns" => "required",
            "picSliderMovIns" => "nullable"
        ];
    }
//|mimes:jpeg,jpg,png

    public function messages(){
        return[
//            "picMovIns.mimes" => "Picture must be jpeg, jpg or png.",
            "picMovIns.required" => "Movie poster is required.",
//            "picMovBgIns.mimes" => "Picture must be jpeg, jpg or png.",
            "picMovBgIns.required" => "Background movie picture is required.",
//            "picSliderMovIns.mimes" => "Picture must be jpeg, jpg or png."
        ];
    }
}
