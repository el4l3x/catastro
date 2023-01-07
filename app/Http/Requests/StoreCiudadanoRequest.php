<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StoreCiudadanoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (Auth::check() && Auth::user()->hasPermissionTo('personas.create')) {
            return true;
        } else {
            return false;
        }
        
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'nombres' =>'required|string',
            'apellidos' => 'required|string',
            'nacionalidad' => [
                'required',
                'alpha', 
                Rule::in(['v', 'e']),
            ],
            'cedula' => 'required|integer|digits_between:6,8|unique:ciudadanos,cedula',
            'sexo' => [
                Rule::in(['true', 'false']),
            ],
            'nacimiento' => 'required|date|before:now - 7 year',
            'telefono' => 'numeric|digits:7',
            'codigo' => 'numeric|digits:4',
            'parroquia' => 'required|exists:parroquias,id',
            'direccion' => 'required',
            'comuna' => 'required|exists:comunas,id',
            'concejo' => 'required|exists:concejos,id',
        ];
    }
}
