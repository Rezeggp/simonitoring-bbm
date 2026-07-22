@extends('layouts.app')
@section('title', 'Ubah Pengguna')
@section('heading', 'Ubah Data Pengguna')
@section('subheading', 'Perbarui informasi akun dan peran akses.')

@section('content')
<div class="bg-white rounded-2xl shadow-card ring-1 ring-black/[0.04] p-6 max-w-2xl">
    <form method="POST" action="{{ route('users.update', $user) }}">
        @method('PUT')
        @include('users._form')
    </form>
</div>
@endsection
