<li class="nav-item dropdown">
    <a class="nav-link" data-toggle="dropdown" href="#">
        <i class="far fa-bell"></i>
        @if ($count > 0)
        <span class="notifications-count badge badge-warning navbar-badge">{{ $count > 100? '99+' : $count }}</span>
        @endif
    </a>
    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <span class="dropdown-header"><span class="notifications-count">{{ $count }}</span> Notifications</span>
        <div id="notifications-list">
        @foreach ($notifications as $notification)
            <div class="dropdown-divider"></div>
            <a href="{{ $notification->data['link'] }}?notification_id={{ $notification->id }}" class="dropdown-item">
                {!! $notification->data['icon'] !!}
                @if ($notification->read())
                {{ $notification->data['title'] }}
                @else
                <strong>{{ $notification->data['title'] }}</strong>
                @endif
                <span class="float-right text-muted text-sm">{{ $notification->created_at->shortRelativeDiffForHumans() }}</span>
            </a>
            @endforeach
        </div>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
    </div>
</li>