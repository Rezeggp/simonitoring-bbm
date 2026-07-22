@extends('layouts.app')
@section('title', 'Ubah Jenis BBM')
@section('heading', 'Ubah Jenis BBM')
@section('subheading', 'Perbarui informasi jenis BBM.')

@section('content')
<div class="bg-white rounded-2xl shadow-card ring-1 ring-black/[0.04] p-6 max-w-xl">
    <form method="POST" action="{{ route('jenis-bbm.update', $jenisBbm) }}">
        @method('PUT')
        @include('jenis-bbm._form')
    </form>
</div>
@endsection
