<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class StoreLanggananRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'pilihan_subs' => 'required|string|max:255',
            'penjelasan_subs' => 'required|string',
            'benefit_subs' => 'required|array|min:1',
            'benefit_subs.*' => 'required|string|max:255',
            'harga_subs' => 'required|numeric|min:0',
            'gambar_subs' => 'required|image|mimes:jpeg,png,jpg,gif|max:10248',
            'status' => 'nullable|in:active,deactive',
        ];
    }

    public function messages()
    {
        return [
            'pilihan_subs.required' => 'Nama kelas wajib diisi',
            'pilihan_subs.max' => 'Nama kelas maksimal 255 karakter',
            'penjelasan_subs.required' => 'Penjelasan kelas wajib diisi',
            'harga_subs.required' => 'Harga kelas wajib diisi',
            'harga_subs.numeric' => 'Harga kelas harus berupa angka',
            'harga_subs.min' => 'Harga kelas tidak boleh kurang dari 0',
            'gambar_subs.required' => 'Gambar kelas wajib diisi',
            'gambar_subs.image' => 'File harus berupa gambar',
            'gambar_subs.mimes' => 'Gambar harus berformat JPG, PNG, JPEG, atau GIF',
            'gambar_subs.max' => 'Ukuran gambar maksimal 10MB',
            'benefit_subs.required' => 'Benefit kelas wajib diisi',
            'benefit_subs.array' => 'Benefit kelas harus berupa array',
            'benefit_subs.min' => 'Minimal harus ada 1 benefit',
            'benefit_subs.*.required' => 'Benefit tidak boleh kosong',
            'benefit_subs.*.string' => 'Benefit harus berupa teks',
            'benefit_subs.*.max' => 'Benefit maksimal 255 karakter',
        ];
    }

    protected function prepareForValidation()
    {
        // Clean up benefit_subs array - remove empty values before validation
        if ($this->has('benefit_subs') && is_array($this->benefit_subs)) {
            $benefits = array_filter($this->benefit_subs, function($value) {
                return !empty(trim($value));
            });
            
            $this->merge([
                'benefit_subs' => array_values($benefits)
            ]);
        }
    }

    protected function failedValidation(Validator $validator)
    {
        if ($this->expectsJson()) {
            throw new HttpResponseException(
                response()->json([
                    'errors' => $validator->errors()
                ], 422)
            );
        }

        parent::failedValidation($validator);
    }
}