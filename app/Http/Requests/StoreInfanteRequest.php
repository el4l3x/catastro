<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StoreInfanteRequest extends FormRequest
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
            'nombre' =>'required|string',
            'apellido' => 'required|string',
            'sexo' => [
                Rule::in(['true', 'false']),
            ],
            'nacimiento' => 'required|date|before:now|after:now - 15 year',
            'responsable' => 'required|exists:ciudadanos,id',
        ];
    }
}
