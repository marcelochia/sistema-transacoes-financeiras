<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class TransationsFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'csvfile' => ['required', 'min:0.125']
        ];
    }

    public function messages()
    {
        return [
            'csvfile.required' => 'O arquivo CSV não foi selecionado',
            'min' => 'O arquivo selecionado está vazio'
        ];
    }
}
