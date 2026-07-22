@extends('layouts.app')
@section('title', 'Tambah SPBU')
@section('heading', 'Tambah SPBU')
@section('subheading', 'Daftarkan SPBU tujuan distribusi baru.')

@section('content')
<div class="bg-white rounded-2xl shadow-card ring-1 ring-black/[0.04] p-6 max-w-2xl">
    <form method="POST" action="{{ route('spbus.store') }}">
        @include('spbus._form')
    </form>
</div>
@endsection
