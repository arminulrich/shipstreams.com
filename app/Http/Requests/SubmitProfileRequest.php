<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubmitProfileRequest extends FormRequest
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
            "email" => "email|required",
            "twitch_username" => "required",
            "twitter_handle" => "max:255",
            "website" => "url|max:512|nullable"
        ];
    }
}
