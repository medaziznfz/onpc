@extends('layouts.app')

@push('content')
<div class="container">
    <h1>All Notifications</h1>
    <div class="list-group">
        @foreach($notifications as $notification)
        <a href="{{ $notification->redirect_link }}" 
           class="list-group-item list-group-item-action @if(!$notification->read) bg-light @endif">
            <div class="d-flex w-100 justify-content-between">
                <h5 class="mb-1">{{ $notification->title }}</h5>
                <small>{{ $notification->created_at->diffForHumans() }}</small>
            </div>
            <p class="mb-1">{{ $notification->subtitle }}</p>
        </a>
        @endforeach
    </div>
    {{ $notifications->links() }}
</div>
@endpush