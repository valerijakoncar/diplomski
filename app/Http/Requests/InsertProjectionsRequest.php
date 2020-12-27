<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InsertProjectionsRequest extends FormRequest
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
        $rules = [];

        foreach($this->request->get('projectionDate') as $key => $val)
        {
            $rules['projectionDate.'.$key] = 'after:yesterday';
        }

        return $rules;
    }

    public function messages(){
        $messages = [];
        foreach($this->request->get('projectionDate') as $key => $val)
        {
            $messages['projectionDate.'.$key.'.after'] = "Date can't be in the past.";
        }
        return $messages;
    }
}
