@extends('layouts.app')

@push('styles')


@endpush

@push('content')
<div class="container">
  <h1>Dashboard</h1>
  <p>Welcome, {{ Auth::user()->name }}!</p>
  <!-- Add your dashboard content here -->
</div>
@endpush

@push('scripts')


@endpush
