<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FetchWeatherDataRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    
    protected function prepareForValidation()
    {
        $this->merge([
            'cidade' => $this->query('select-cidade') ?? $this->query('other-city'),
        ]);
    }
    
    public function rules(): array
    {
        return [
            'select-cidade' => 'nullable|integer',
            'other-city'    => 'nullable|string|max:255',
            //
            'cidade'        => 'required',
        ];
    }   
    
    public function messages(): array
    {
        return [
            'cidade.required' => 'Por favor, selecione ou digite o nome de uma cidade.',
        ];
    }
}