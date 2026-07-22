@extends('layouts.app')
@section('title', 'Tambah Pengguna')
@section('heading', 'Tambah Pengguna')
@section('subheading', 'Buat akun pengguna baru beserta peran aksesnya.')

@section('content')
<div class="bg-white rounded-2xl shadow-card ring-1 ring-black/[0.04] p-6 max-w-2xl">
    <form method="POST" action="{{ route('users.store') }}">
        @include('users._form')
    </form>
</div>
@endsection
