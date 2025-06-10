@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto px-6 pt-16 pb-20 bg-white min-h-screen">
    <h1 class="text-5xl font-extrabold text-gray-900 mb-12 text-center">
        Daftar Users
    </h1>

    <div class="overflow-x-auto rounded-lg shadow-sm border border-gray-200">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wide">
                        Nama Member
                    </th>
                    <th scope="col" class="px-6 py-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wide">
                        Email Member
                    </th>
                    <th scope="col" class="px-6 py-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wide">
                        Telepon
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                @forelse ($accounts as $account)
                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                        <td class="px-6 py-4 whitespace-nowrap text-gray-900 text-sm font-medium">
                            {{ optional($account->member)->nama_member ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-900 text-sm">
                            {{ optional($account->member)->email_member ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-900 text-sm">
                            {{ optional($account->member)->no_telp ?? 'N/A' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-6 py-8 text-center text-sm text-gray-500">
                            Tidak ada data akun member yang ditemukan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-8 flex justify-center">
        {{ $accounts->links('pagination::tailwind') }}
    </div>
</div>
@endsection

