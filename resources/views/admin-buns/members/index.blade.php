@extends('layouts.admin')

@section('content')
<section id="members" class="bg-light py-5">
    <div class="container">
        <!-- Header Section with Title -->
        <div class="header-section mb-5">
            <h2 class="page-title">
                Daftar Member
            </h2>
        </div>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

        <!-- Action Bar - Search -->
        <div class="action-bar mb-4">
            <div class="action-right">
                <form action="{{ route('admin-buns.members.index') }}" method="GET" class="search-form-modern">
                    <div class="search-container">
                        <div class="search-input-wrapper">
                            <i class="fas fa-search search-icon"></i>
                            <input
                                type="text"
                                id="searchInput"
                                name="search"
                                class="search-input"
                                value="{{ request('search') }}"
                                placeholder="Search members by name or email..."
                                autocomplete="off" />
                            @if(request('search'))
                            <button type="button" class="clear-search" onclick="clearSearch()">
                                <i class="fas fa-times"></i>
                            </button>
                            @endif
                        </div>
                        <button type="submit" class="search-btn">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Members List -->
        <div class="members-container mt-4">
            <div class="table-responsive">
                <table class="table custom-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Member</th>
                            <th>Email</th>
                            <th>Telepon</th>
                            <th>Alamat</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        @forelse($members as $member)
                        <tr>
                            <td>{{ $loop->iteration + ($members->currentPage() - 1) * $members->perPage() }}</td>
                            <td class="item-name">{{ $member->nama_member }}</td>
                            <td>{{ $member->email_member }}</td>
                            <td>{{ $member->no_telp }}</td>
                            <td>{{ $member->alamat_member }}</td>
                            <td>
                                @if($member->day > 0)
                                <span class="badge-role active">Active ({{ $member->day }} days)</span>
                                @else
                                <span class="badge-role inactive">Inactive</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr class="empty-row">
                            <td colspan="6">
                                <div class="empty-state">
                                    <i class="fas fa-users fa-3x"></i>
                                    <p>Tidak ada data member</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $members->appends(request()->input())->links() }}
            </div>
        </div>
    </div>
</section>

@endsection

<style>
    html,
    body {
        min-height: 100vh !important;
        background-color: #f8f9fa !important;
    }

    body>div,
    #app,
    .wrapper,
    .content-wrapper,
    main,
    .admin-layout {
        min-height: 100vh !important;
        background-color: #f8f9fa !important;
    }

    footer {
        background-color: #f8f9fa !important;
        margin-top: auto;
    }

    body {
        display: flex;
        flex-direction: column;
    }

    * {
        margin-bottom: 0;
    }

    .header-section {
        text-align: center;
        margin-bottom: 2.5rem;
        position: relative;
    }

    .page-title {
        font-size: 2.2rem;
        font-weight: 700;
        color: #343a40;
        margin-bottom: 0.5rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }

    .page-subtitle {
        font-size: 1.1rem;
        color: #6c757d;
        font-weight: 400;
        margin: 0;
        opacity: 0.8;
    }

    .action-bar {
        display: flex;
        justify-content: flex-end;
        align-items: flex-start;
        gap: 2rem;
        margin-bottom: 2rem;
        flex-wrap: wrap;
    }

    .action-right {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        min-width: 0;
        flex: 0 0 auto;
        max-width: 400px;
        margin-left: auto;
    }

    .search-form-modern {
        width: 350px;
        max-width: 350px;
    }

    .search-container {
        display: flex;
        align-items: center;
        gap: 8px;
        width: 100%;
    }

    .search-input-wrapper {
        position: relative;
        flex: 1;
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        border: 1px solid #e2e8f0;
        transition: all 0.3s ease;
        overflow: hidden;
        height: 36px;
    }

    .search-input-wrapper:focus-within {
        border-color: black;
        box-shadow: 0 2px 8px rgba(0, 123, 255, 0.15);
        transform: none;
    }

    .search-icon {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #6b7280;
        font-size: 0.875rem;
        z-index: 2;
        transition: all 0.3s ease;
    }

    .search-input-wrapper:focus-within .search-icon {
        color: #343a40;
        transform: translateY(-50%);
    }

    .search-input {
        width: 100%;
        border: none;
        outline: none;
        padding: 8px 12px 8px 32px;
        font-size: 0.8rem;
        background: transparent;
        color: #343a40;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .search-input::placeholder {
        color: #9ca3af;
        font-weight: 400;
        font-size: 0.8rem;
        transition: all 0.3s ease;
    }

    .search-input:focus::placeholder {
        color: #d1d5db;
    }

    .clear-search {
        position: absolute;
        right: 36px;
        top: 50%;
        transform: translateY(-50%);
        background: #f3f4f6;
        border: none;
        border-radius: 50%;
        width: 18px;
        height: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        color: #6b7280;
        font-size: 0.6rem;
    }

    .clear-search:hover {
        background: #e5e7eb;
        color: #374151;
        transform: translateY(-50%) scale(1.1);
    }

    .search-btn {
        background: #343a40;
        border: none;
        border-radius: 8px;
        padding: 8px 12px;
        color: white;
        font-weight: 600;
        font-size: 0.8rem;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 2px 6px rgba(0, 123, 255, 0.3);
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 36px;
        height: 36px;
    }

    .search-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 3px 8px rgba(0, 123, 255, 0.4);
        background: #0056b3;
    }

    .search-btn:active {
        transform: translateY(0);
    }

    .search-btn i {
        font-size: 0.75rem;
        transition: transform 0.3s ease;
    }

    .search-btn:hover i {
        transform: scale(1.05);
    }

    @media (max-width: 768px) {
        .action-bar {
            flex-direction: column;
            gap: 1rem;
            align-items: stretch;
        }

        .action-right {
            width: 100%;
            max-width: none;
            margin-left: 0;
            justify-content: center;
        }

        .search-form-modern {
            width: 100%;
            max-width: 100%;
        }
    }

    @media (max-width: 480px) {
        .search-form-modern {
            width: 100%;
        }

        .search-container {
            gap: 6px;
        }

        .search-input {
            padding: 8px 10px 8px 30px;
            font-size: 0.75rem;
        }

        .search-input::placeholder {
            font-size: 0.75rem;
        }

        .clear-search {
            right: 32px;
            width: 16px;
            height: 16px;
            font-size: 0.5rem;
        }

        .search-btn {
            padding: 8px 10px;
            min-width: 32px;
            height: 32px;
        }

        .search-btn i {
            font-size: 0.7rem;
        }
    }



    .pagination {
        margin-top: 20px;
        margin-bottom: 20px;
    }

    .pagination .page-item.active .page-link {
        background-color: #007bff;
        border-color: #007bff;
    }

    .pagination .page-link {
        color: #007bff;
        padding: 6px 10px;
        font-size: 1rem;
    }

    .pagination .page-link:hover {
        background-color: #f1f1f1;
    }

    .pagination .page-link:focus {
        box-shadow: none;
    }

    table.custom-table {
        width: 100%;
        border-collapse: collapse;
    }

    table.custom-table thead {
        background-color: #343a40;
        color: white;
        border-radius: 12px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    table.custom-table th,
    table.custom-table td {
        padding: 12px 15px;
        text-align: left;
    }

    table.custom-table tbody tr {
        background-color: white;
        border-bottom: 1px solid #ddd;
    }

    table.custom-table tbody tr:hover {
        background-color: #f8f9fa;
    }

    @media (max-width: 768px) {
        table.custom-table {
            font-size: 0.9rem;
        }

        table.custom-table th,
        table.custom-table td {
            padding: 8px;
        }
    }

    @media (max-width: 576px) {
        table.custom-table {
            font-size: 0.8rem;
        }

        table.custom-table th,
        table.custom-table td {
            padding: 5px;
        }
    }

    .badge-role {
        padding: 6px 12px;
        font-size: 0.85rem;
        color: white;
        border-radius: 10px;
        text-transform: uppercase;
        display: inline-block;
    }

    .badge-role.active {
        background-color: #28a745;
    }

    .badge-role.inactive {
        background-color: #dc3545;
    }

    .empty-state {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 3rem 0;
        color: #6c757d;
    }

    .empty-state i {
        margin-bottom: 1rem;
        color: #adb5bd;
    }

    .empty-state p {
        font-size: 1.1rem;
        font-weight: 500;
    }


    footer {
        background-color: #f8f9fa !important;
    }

    .admin-layout,
    #app,
    .wrapper {
        background-color: #f8f9fa !important;
        min-height: auto !important;
    }
</style>
<script>
    function clearSearch() {
        const searchInput = document.getElementById('searchInput');
        const form = document.querySelector('.search-form-modern');
        searchInput.value = '';
        form.submit();
    }

    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');

        if (searchInput) {
            searchInput.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    document.querySelector('.search-form-modern').submit();
                }
            });
        }
    });
</script>