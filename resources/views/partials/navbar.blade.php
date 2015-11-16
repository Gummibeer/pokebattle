<nav class="navbar navbar-default navbar-fixed-top am-top-header">
    <div class="container-fluid">
        <div class="navbar-header">
            <div class="page-title">
                <span>{{ trans('messages.pokebattle') }}</span>
            </div>
            <a href="#" class="am-toggle-left-sidebar navbar-toggle collapsed">
                <span class="icon-bar"><span></span><span></span><span></span></span>
            </a>
            <a href="{{ lurl('/') }}" class="navbar-brand text-center">
                <i class="icon wh-pokemon icon-2x"></i>
            </a>
        </div>
        <a href="#" class="am-toggle-right-sidebar">
            <span class="icon wh-dropmenu"></span>
        </a>
        <a href="#" data-toggle="collapse" data-target="#am-navbar-collapse" class="am-toggle-top-header-menu collapsed">
            <i class="icon wh-chevron-down"></i>
        </a>
        <div id="am-navbar-collapse" class="collapse navbar-collapse">
            <ul class="nav navbar-nav hidden-xs">
                <li>
                    <span data-toggle="tooltip" data-placement="bottom" title="{{ trans('messages.weather.'.$weather['today']['type']) }}"><i class="wi-fw wi-{{ $weather['today']['type'] }} icon-2x"></i></span>
                </li>
                <li>
                    <span data-toggle="tooltip" data-placement="bottom" title="{{ $weather['today']['temp'] }}&nbsp;°C"><i class="icon wh-temperature-thermometer icon-2x"></i></span>
                </li>
                <li>
                    <span data-toggle="tooltip" data-placement="bottom" title="{{ $weather['today']['wind'] }}&nbsp;km/h"><i class="icon wh-windleft icon-2x"></i></span>
                </li>
                <li>
                    <span data-toggle="tooltip" data-placement="bottom" title="{{ trans('messages.moon.'.$moonPhase['today']) }}"><i class="icon wh-moon-{{ $moonPhase['today'] }} icon-2x"></i></span>
                </li>
                <li>
                    <span data-toggle="tooltip" data-placement="bottom" title="{{ \Auth::user()->pokemon->display_name }} LvL {{ getCurLvl() }}"><i class="icon wh-pokemon icon-2x"></i></span>
                </li>
            </ul>

            <ul class="nav navbar-nav navbar-right am-user-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="flag-icon flag-icon-{{ App::getLocale() }}"></span> <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        @foreach(config('app.supported_locales') as $locale)
                            <li><a href="{{ lurl('/', $locale) }}"><span class="flag-icon flag-icon-{{ $locale }}"></span> {{ trans('messages.lang.'.$locale) }}</a></li>
                        @endforeach
                    </ul>
                </li>

                <li>
                    <img src="{{ \Auth::User()->avatar(50) }}" class="img-circle padding-15" data-toggle="tooltip" data-placement="bottom" title="{{ \Auth::User()->name }}" />
                </li>
                <li>
                    <a href="{{ lurl('auth/logout') }}" data-toggle="tooltip" data-placement="bottom" title="{{ trans('messages.signout') }}">
                        <i class="icon wh-off"></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>