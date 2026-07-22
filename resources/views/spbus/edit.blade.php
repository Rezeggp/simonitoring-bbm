@extends('layouts.app')
@section('title', 'Ubah SPBU')
@section('heading', 'Ubah Data SPBU')
@section('subheading', 'Perbarui informasi SPBU.')

@section('content')
<div class="bg-white rounded-2xl shadow-card ring-1 ring-black/[0.04] p-6 max-w-2xl">
    <form method="POST" action="{{ route('spbus.update', $spbu) }}">
        @method('PUT')
        @include('spbus._form')
    </form>
</div>
@endsection
