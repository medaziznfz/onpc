<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="notificationDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i data-feather="bell"></i>
        @if(auth()->user()->unreadNotifications->count() > 0)
        <div class="indicator">
            <div class="circle"></div>
        </div>
        @endif
    </a>
    <div class="dropdown-menu p-0" aria-labelledby="notificationDropdown">
        <div class="px-3 py-2 d-flex align-items-center justify-content-between border-bottom">
            <p>{{ auth()->user()->unreadNotifications->count() }} New Notifications</p>
            <a href="javascript:;" class="text-muted" onclick="markAllAsRead()">Clear all</a>
        </div>
        <div class="p-1">
            @foreach(auth()->user()->notifications->take(4) as $notification)
            <a href="{{ $notification->redirect_link }}" 
                class="dropdown-item d-flex align-items-center py-2 @if(!$notification->read) bg-light @endif"
                data-notification-id="{{ $notification->id }}"
                onclick="markAsRead({{ $notification->id }})">
                <div class="wd-30 ht-30 d-flex align-items-center justify-content-center bg-primary rounded-circle me-3">
                    <i class="icon-sm text-white" data-feather="bell"></i>
                </div>
                <div class="flex-grow-1 me-2">
                    <p>{{ $notification->title }}</p>
                    <p class="tx-12 text-muted">{{ $notification->subtitle }}</p>
                    <p class="tx-12 text-muted">{{ $notification->created_at->diffForHumans() }}</p>
                </div>
            </a>
            @endforeach
        </div>
        <div class="px-3 py-2 d-flex align-items-center justify-content-center border-top">
            <a href="{{ route('notifications.index') }}">View all</a>
        </div>
    </div>
</li>