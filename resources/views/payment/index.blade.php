<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Form</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="container">
        <h1>Payment for Subscription</h1>

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('payment.show') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="nama_member">Nama Member</label>
                <input type="text" name="nama_member" id="nama_member" required>
            </div>

            <div class="form-group">
                <label for="email_member">Email Member</label>
                <input type="email" name="email_member" id="email_member" required>
            </div>

            <div class="form-group">
                <label for="no_telp">No Telepon</label>
                <input type="text" name="no_telp" id="no_telp" required>
            </div>

            <div class="form-group">
                <label for="alamat_member">Alamat Member</label>
                <textarea name="alamat_member" id="alamat_member" required></textarea>
            </div>

            <div class="form-group">
                <label for="harga_subs">Harga Subscription</label>
                <input type="number" name="harga_subs" id="harga_subs" required>
            </div>

            <div class="form-group">
                <label for="id_account">ID Akun</label>
                <input type="text" name="id_account" id="id_account" required>
            </div>

            <div class="form-group">
                <label for="pilihan_hari">Pilihan Hari</label>
                <input type="text" name="pilihan_hari" id="pilihan_hari" required>
            </div>

            <button type="submit" class="btn btn-primary">Bayar</button>
        </form>
    </div>
</body>
</html>