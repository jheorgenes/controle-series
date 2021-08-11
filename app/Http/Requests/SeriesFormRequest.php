<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SeriesFormRequest extends FormRequest
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
            'nome' => 'required|min:3'
        ];
    }

    public function messages()
    {
        return [
          //'regra' => 'mensagem' //Exemplo
          //'nome.required' => 'O campo deverá ser preenchido', //Forma manual
          'required' => 'O campo :attribute é obrigatório', //Aqui pega automático e recebe um campo que será substituído no lugar de :attribute
          'nome.min' => 'O campo nome precisa ter pelo menos 3 caracteres'
        ];
    }
}
