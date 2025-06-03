<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class accountRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'nama_member' => 'required|string|max:255',
            'alamat_member' => 'required|string|max:255',
            'no_telp' => 'required|string|max:20',
            'foto_profil' => 'nullable|image|mimes:jpg,jpeg,png|max:10240',
            'delete_image' => 'nullable|string'
        ];
    }

    public function messages()
    {
        return [
            'nama_member.required' => 'Nama lengkap wajib diisi.',
            'alamat_member.required' => 'Alamat wajib diisi.',
            'no_telp.required' => 'Nomor telepon wajib diisi.',
            'foto_profil.image' => 'File harus berupa gambar.',
            'foto_profil.mimes' => 'Format gambar yang diterima: jpg, jpeg, png.',
            'foto_profil.max' => 'Ukuran gambar maksimal 2MB.'
        ];
    }
}