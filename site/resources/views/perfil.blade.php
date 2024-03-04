@extends('layouts.master')

@section('title', 'perfil')

@section('content')
<div class="bg-page">
  @if(session('key'))
      <p>Bienvenido, {{ session('key') }}</p>
  @endif
</div>
@endsection
