@extends('layouts.admin')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold mb-2">Selamat Datang, {{ session('admin_nama') }}!</h1>
    <p class="text-gray-600 mb-6">Berikut adalah ringkasan data sistem hari ini:</p>


    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        <div class="bg-white rounded-lg shadow p-6 text-center">
            <h2 class="text-lg font-semibold mb-2">💰 Total Uang Masuk</h2>
            <p class="text-3xl text-green-600 font-bold">Rp {{ number_format($totalUangMasuk, 0, ',', '.') }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6 text-center">
            <h2 class="text-lg font-semibold mb-2">👤 Total Member</h2>
            <p class="text-3xl text-blue-600 font-bold">{{ $totalMember }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6 text-center">
            <h2 class="text-lg font-semibold mb-2">🙋 Non-Member</h2>
            <p class="text-3xl text-red-500 font-bold">{{ $totalNonMember }}</p>
        </div>
    </div>


    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <a href="{{ route('admin-buns.gallery') }}" class="bg-gray-50 hover:bg-gray-100 p-6 rounded-lg shadow text-center">
            <div class="text-4xl mb-2">🖼</div>
            <h3 class="text-lg font-semibold">Gallery</h3>
        </a>
        <a href="{{ route('admin.users') }}" class="bg-gray-50 hover:bg-gray-100 p-6 rounded-lg shadow text-center">
            <div class="text-4xl mb-2">👥</div>
            <h3 class="text-lg font-semibold">Users</h3>
        </a>
        <a href="{{ route('admin.members') }}" class="bg-gray-50 hover:bg-gray-100 p-6 rounded-lg shadow text-center">
            <div class="text-4xl mb-2">💳</div>
            <h3 class="text-lg font-semibold">Members</h3>
        </a>
        <a href="{{ route('admin-buns.classes.index') }}" class="bg-gray-50 hover:bg-gray-100 p-6 rounded-lg shadow text-center">
            <div class="text-4xl mb-2">📚</div>
            <h3 class="text-lg font-semibold">Classes</h3>
        </a>
    </div>
</div>
@endsection