@extends('layouts.app')

@section('styles')


@endsection

@section('content')
<div class="container">
  <h1>Dashboard</h1>
  <p>Welcome, {{ Auth::user()->name }}!</p>
  <!-- Add your dashboard content here -->
</div>
@endsection

@section('scripts')


@endsection
