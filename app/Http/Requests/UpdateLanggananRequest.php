<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLanggananRequest extends FormRequest
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
            'harga_subs' => 'required|numeric',
            'gambar_subs' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'pilihan_subs.required' => 'Nama kelas wajib diisi',
            'penjelasan_subs.required' => 'Penjelasan kelas wajib diisi',
            'harga_subs.required' => 'Harga kelas wajib diisi',
        ];
    }
}