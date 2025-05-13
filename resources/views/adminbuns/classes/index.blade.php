@extends('layouts.admin')

@section('content')
<div class="p-6">
    <h2 class="text-xl font-bold mb-4">Daftar Kelas</h2>

    @if(session('success'))
        <div class="bg-green-200 text-green-800 p-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('adminbuns.classes.store') }}" method="POST" class="mb-6">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
            <input type="text" name="pilihan_subs" placeholder="Nama Kelas" required class="p-2 border rounded">
            <input type="text" name="penjelasan_subs" placeholder="Penjelasan" required class="p-2 border rounded">
            <input type="number" step="0.01" name="harga_subs" placeholder="Harga" required class="p-2 border rounded">
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Tambah Kelas</button>
    </form>

    <table class="table-auto w-full border-collapse">
        <thead>
            <tr class="bg-gray-200 text-left">
                <th class="p-2 border">Nama Kelas</th>
                <th class="p-2 border">Penjelasan</th>
                <th class="p-2 border">Harga</th>
                <th class="p-2 border">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($langganans as $langganan)
            <tr>
                <td class="p-2 border">{{ $langganan->pilihan_subs }}</td>
                <td class="p-2 border">{{ $langganan->penjelasan_subs }}</td>
                <td class="p-2 border">Rp {{ number_format($langganan->harga_subs, 0, ',', '.') }}</td>
                <td class="p-2 border">
                    <a href="{{ route('adminbuns.classes.edit', $langganan->id_langganan) }}" class="text-blue-600">Edit</a> |
                    <form action="{{ route('adminbuns.classes.destroy', $langganan->id_langganan) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Yakin ingin menghapus?')" class="text-red-600">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
