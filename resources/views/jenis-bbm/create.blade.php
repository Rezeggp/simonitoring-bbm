@extends('layouts.app')
@section('title', 'Tambah Jenis BBM')
@section('heading', 'Tambah Jenis BBM')
@section('subheading', 'Daftarkan jenis produk BBM baru.')

@section('content')
<div class="bg-white rounded-2xl shadow-card ring-1 ring-black/[0.04] p-6 max-w-xl">
    <form method="POST" action="{{ route('jenis-bbm.store') }}">
        @include('jenis-bbm._form')
    </form>
</div>
@endsection
