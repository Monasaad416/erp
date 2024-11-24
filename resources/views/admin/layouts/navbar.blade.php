<nav class="main-header navbar navbar-expand navbar-white navbar-light">

    <ul class="navbar-nav">
        <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ route('index') }}" class="nav-link">{{trans('admin.home')}}</a>
        </li>
        {{-- <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
        </li> --}}
    </ul>

    <ul class="navbar-nav ml-auto">

        {{-- <li class="nav-item">
            <a class="nav-link" data-widget="navbar-search" href="#" role="button">
            <i class="fas fa-search"></i>
            </a>
            <div class="navbar-search-block">
                <form class="form-inline">
                <div class="input-group input-group-sm">
                <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                <i class="fas fa-search"></i>
                </button>
                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                <i class="fas fa-times"></i>
                </button>
                </div>
                </div>
                </form>
            </div>
        </li> --}}

        @php
            $noOfNotifications = count(auth()->user()->notifications);
            $noOfUnReadNotifications = count(auth()->user()->unreadnotifications);
        @endphp


    <li class="nav-item dropdown"  id="notificationIcon">
            <a class="nav-link" data-toggle="dropdown" href="#" >
                <i class="far fa-bell"></i>
                <span id="counter" class="badge badge-{{ $noOfUnReadNotifications == 0 ? 'secondary' : 'warning'}} navbar-badge">
                {{ request()->is('notifications') ? 0 : $noOfUnReadNotifications}}
                </span>
            </a>

            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">

                <span class="dropdown-item dropdown-header">{{$noOfNotifications}} إشعار</span>
                @if($noOfNotifications > 0)
                <div class="dropdown-divider"></div>
                    @foreach (Auth::user()->notifications->take(15) as $notification)
                        @if($notification->data['action'])
                            <a href="{{url($notification->data['action'])}}" id="notification" data-id="{{$notification->id}}" class="dropdown-item @if($notification->read_at == null ) text-primary @else text-muted @endif">
                                <i class="fas fa-envelope mr-2"></i>{{$notification->data['title']}}
                                <span class="float-right text-muted text-sm">{{ $notification->created_at->diffForHumans() }}</span>
                            </a>
                        @else
                        <i class="fas fa-envelope mr-2">{{$notification->data['title']}}</i>
                        @endif
                    @endforeach
                    <div class="dropdown-divider"></div>
                    <a href="{{route('notifications')}}" class="dropdown-item dropdown-footer">إظهار كل الاشعارات</a>
                @endif


            </div>
        </li>


        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>

        <li class="nav-item dropdown" title="{{trans('admin.select_lang')}}">
          <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="far fa-flag"></i>
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)

                <a class="dropdown-item" rel="alternate" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                    {{ $properties['native'] }}
                </a>
                <div class="dropdown-divider"></div>
            @endforeach

          </div>
        </li>

    </ul>
</nav>
