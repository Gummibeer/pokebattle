<nav class="navbar navbar-default navbar-fixed-top am-top-header">
    <div class="container-fluid">
        <div class="navbar-header">
            <div class="page-title">
                <span>{{ trans('messages.pokebattle') }}</span>
            </div>
            <a href="#" class="am-toggle-left-sidebar navbar-toggle collapsed">
                <span class="icon-bar"><span></span><span></span><span></span></span>
            </a>
            <a href="{{ url('/') }}" class="navbar-brand">
                <img src="{{ asset('img/favicon.png') }}" class="img-responsive">
            </a>
        </div>
        <a href="#" data-toggle="collapse" data-target="#am-navbar-collapse" class="am-toggle-top-header-menu collapsed">
            <i class="icon fa fa-angle-down"></i>
        </a>
        <div id="am-navbar-collapse" class="collapse navbar-collapse">
            <ul class="nav navbar-nav navbar-right am-user-nav">
                <li class="dropdown">
                    <a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="dropdown-toggle">
                        <img src="{{ \Auth::User()->avatar() }}">
                        <span class="user-name">{{ \Auth::User()->name }}</span>
                        <i class="angle-down icon fa fa-angle-down"></i>
                    </a>
                    <ul role="menu" class="dropdown-menu">
                        <li>
                            <a href="{{ url('auth/logout') }}">
                                <i class="icon fa fa-power-off"></i>
                                {{ trans('messages.signout') }}
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>