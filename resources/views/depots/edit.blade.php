@extends('layouts.app')
@section('title', 'Ubah Depot')
@section('heading', 'Ubah Data Terminal BBM')
@section('subheading', 'Perbarui informasi terminal BBM.')

@section('content')
<div class="bg-white rounded-2xl shadow-card ring-1 ring-black/[0.04] p-6 max-w-2xl">
    <form method="POST" action="{{ route('depots.update', $depot) }}">
        @method('PUT')
        @include('depots._form')
    </form>
</div>
@endsection
