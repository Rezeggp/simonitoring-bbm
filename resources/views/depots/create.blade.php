@extends('layouts.app')
@section('title', 'Tambah Depot')
@section('heading', 'Tambah Terminal BBM')
@section('subheading', 'Daftarkan terminal penyimpanan BBM baru.')

@section('content')
<div class="bg-white rounded-2xl shadow-card ring-1 ring-black/[0.04] p-6 max-w-2xl">
    <form method="POST" action="{{ route('depots.store') }}">
        @include('depots._form')
    </form>
</div>
@endsection
