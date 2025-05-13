@extends('layouts.admin')

@section('content')
<div class="p-6">
    <h2 class="text-xl font-bold mb-4">Edit Kelas</h2>

    <form action="{{ route('adminbuns.classes.update', $langganan->id_langganan) }}" method="POST">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
            <input type="text" name="pilihan_subs" value="{{ $langganan->pilihan_subs }}" required class="p-2 border rounded">
            <input type="text" name="penjelasan_subs" value="{{ $langganan->penjelasan_subs }}" required class="p-2 border rounded">
            <input type="number" step="0.01" name="harga_subs" value="{{ $langganan->harga_subs }}" required class="p-2 border rounded">
        </div>
        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Perbarui</button>
        <a href="{{ route('adminbuns.classes.index') }}" class="ml-4 text-blue-600">← Kembali</a>
    </form>
</div>
@endsection
