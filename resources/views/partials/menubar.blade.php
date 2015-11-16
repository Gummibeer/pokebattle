<div class="am-left-sidebar">
    <div class="content">
        <div class="am-logo"></div>
        <ul class="sidebar-elements">
            <li class="@if(Request::is('*app/dashboard')) active @endif">
                <a href="{{ lurl('app/dashboard') }}" class="text-center">
                    <i class="icon wh-monitor"></i>
                    <span>{{ trans('menu.home') }}</span>
                </a>
            </li>
            <li class="@if(Request::is('*app/pokedex*')) active @endif">
                <a href="{{ lurl('app/pokedex') }}" class="text-center">
                    <i class="icon wh-indexmanager"></i>
                    <span>{{ trans('menu.pokedex') }}</span>
                </a>
            </li>
            <li class="@if(Request::is('*app/pokepc*')) active @endif">
                <a href="{{ lurl('app/pokepc') }}" class="text-center">
                    <i class="icon wh-server"></i>
                    <span>{{ trans('menu.pokepc') }}</span>
                </a>
            </li>
            <li>
                <a href="https://gitlab.com/powerful-panda-productions/pokebattle" class="text-center social-gitlab" target="_blank" data-toggle="tooltip" data-placement="right" data-title="{{ trans('messages.gitlab_help') }}">
                    <i class="icon wh-code"></i>
                    <span>{{ trans('menu.gitlab') }}</span>
                </a>
            </li>
            <li>
                <a href="https://www.paypal.me/gummibeer/5" class="text-center social-paypal" target="_blank" data-toggle="tooltip" data-placement="right" data-title="{{ trans('messages.paypal_help') }}">
                    <i class="icon wh-paypal"></i>
                    <span>{{ trans('menu.paypal') }}</span>
                </a>
            </li>
        </ul>
    </div>
</div>