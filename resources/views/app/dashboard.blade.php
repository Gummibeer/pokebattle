@extends('app')

@section('content')
    <div class="row masonry-container">
        <div class="col-md-3 col-xs-12 masonry-item masonry-sizer">
            <div class="widget">
                <div class="widget-head">
                    <h3 class="panel-title">{{ trans('messages.active_pokemon') }}</h3>
                </div>
                <div class="media">
                    <div class="media-left">
                        <img class="media-object" src="{{ \Auth::User()->pokemon->avatar }}" alt="{{ \Auth::User()->pokemon->display_name }}">
                    </div>
                    <div class="media-body">
                        <div class="clearfix">
                            <h4 class="media-heading pull-left">#{{ \Auth::User()->pokemon->id }} {{ \Auth::User()->pokemon->display_name }}</h4>
                            <span class="pull-right">LvL {{ getCurLvl() }} | {{ getRelativeCurExp() }} / {{ getRelativeNeededExp() }} EXP</span>
                        </div>
                        <div class="progress height-5 margin-bottom-5" data-toggle="tooltip" data-placement="bottom" title="{{ getLvlPercentage() }} %">
                            <div class="progress-bar" style="width: {{ getLvlPercentage() }}%;"></div>
                        </div>
                        <div>
                            <strong>{{ trans('messages.types') }}</strong>
                            {{ implode(', ', \Auth::User()->pokemon->types->pluck('display_name')->toArray()) }}
                        </div>
                        <ul class="list-inline margin-bottom-0">
                            <li><strong>HP</strong> {{ getHealth() }}</li>
                            <li><strong>ATK</strong> {{ getAtk() }}</li>
                            <li><strong>DEF</strong> {{ getDef() }}</li>
                            <li><strong>SPD</strong> {{ getSpd() }}</li>
                        </ul>
                        <div>
                            <strong>{{ trans('messages.moves') }}</strong>
                            {{ \Auth::User()->pokemon->moves->count() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-xs-12 masonry-item masonry-sizer">
            <div class="widget">
                <div class="widget-head">
                    <h3 class="panel-title">{{ trans('messages.trainer_stats') }}</h3>
                </div>
                <ul class="list-inline margin-bottom-0">
                    <li><i class="icon wh-pokemon" data-toggle="tooltip" data-placement="bottom" title="{{ trans('messages.catched_pokemons') }}"></i> {{ \Auth::User()->pokemons()->count() }}</li>
                    <li><i class="icon wh-brain" data-toggle="tooltip" data-placement="bottom" title="{{ trans('messages.trainer_experience') }}"></i> {{ \Auth::User()->experience }}</li>
                    <li><i class="icon wh-trophy" data-toggle="tooltip" data-placement="bottom" title="{{ trans('messages.wins') }}"></i> {{ \Auth::User()->wins }}</li>
                    <li><i class="icon wh-skull" data-toggle="tooltip" data-placement="bottom" title="{{ trans('messages.kills') }}"></i> {{ \Auth::User()->kills }}</li>
                </ul>
            </div>
        </div>

        <div class="col-md-3 col-xs-12 masonry-item">
            <div class="widget">
                <div class="widget-head">
                    <h3 class="panel-title">{{ trans('messages.arena_weather') }}</h3>
                </div>
                <div class="row">
                    <div class="col-xs-6 text-center">
                        <div class="text-primary">{{ trans('messages.today') }}</div>
                        <i class="wi-fw wi-{{ $weather['today']['type'] }} icon-3x inline-block padding-vertical-10 text-muted" data-toggle="tooltip" data-placement="bottom" title="{{ trans('messages.weather.'.$weather['today']['type']) }}"></i>
                        <ul class="list-inline">
                            <li><i class="icon wh-temperature-thermometer"></i> {{ $weather['today']['temp'] }} °C</li>
                            <li><i class="icon wh-windleft"></i> {{ $weather['today']['wind'] }} km/h</li>
                            <li><i class="icon wh-moon-{{ $moonPhase['today'] }}"></i> {{ trans('messages.moon.'.$moonPhase['today']) }}</li>
                        </ul>
                    </div>
                    <div class="col-xs-6 text-center">
                        <div class="text-primary">{{ trans('messages.tomorrow') }}</div>
                        <i class="wi-fw wi-{{ $weather['tomorrow']['type'] }} icon-3x inline-block padding-vertical-10 text-muted" data-toggle="tooltip" data-placement="bottom" title="{{ trans('messages.weather.'.$weather['tomorrow']['type']) }}"></i>
                        <ul class="list-inline">
                            <li><i class="icon wh-temperature-thermometer"></i> {{ $weather['tomorrow']['temp'] }} °C</li>
                            <li><i class="icon wh-windleft"></i> {{ $weather['tomorrow']['wind'] }} km/h</li>
                            <li><i class="icon wh-moon-{{ $moonPhase['tomorrow'] }}"></i> {{ trans('messages.moon.'.$moonPhase['tomorrow']) }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-xs-12 masonry-item">
            <div class="widget">
                <div class="widget-head">
                    <h3 class="panel-title">{{ trans('messages.pokemons_per_type') }}</h3>
                </div>
                <div class="chart-container">
                    <canvas id="type-radar" height="200px" data-label="{{ trans('messages.pokemons_per_type') }}" data-labels="{{ $types->pluck('display_name')->toJson() }}" data-dataset="{{ $types->map(function($item) { return $item->pokemons->count(); })->toJson() }}"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-xs-12 masonry-item">
            <div class="widget">
                <div class="widget-head">
                    <h3 class="panel-title">{{ trans('messages.pokemon_of_the_day') }}</h3>
                </div>
                <div class="media">
                    <div class="media-left">
                        <img class="media-object" src="{{ $pokemonOfTheDay->avatar }}" alt="{{ $pokemonOfTheDay->display_name }}">
                    </div>
                    <div class="media-body">
                        <h4 class="media-heading">#{{ $pokemonOfTheDay->id }} {{ $pokemonOfTheDay->display_name }}</h4>
                        <div>
                            <strong>{{ trans('messages.types') }}</strong>
                            {{ implode(', ', $pokemonOfTheDay->types->pluck('display_name')->toArray()) }}
                        </div>
                        <ul class="list-inline margin-bottom-0">
                            <li><strong>HP</strong> {{ $pokemonOfTheDay->health }}</li>
                            <li><strong>ATK</strong> {{ $pokemonOfTheDay->attack }}</li>
                            <li><strong>DEF</strong> {{ $pokemonOfTheDay->defense }}</li>
                            <li><strong>SPD</strong> {{ $pokemonOfTheDay->speed }}</li>
                            <li><strong>EXP</strong> {{ $pokemonOfTheDay->experience }}</li>
                        </ul>
                        <div>
                            <strong>{{ trans('messages.moves') }}</strong>
                            {{ $pokemonOfTheDay->moves->count() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-xs-12 masonry-item">
            <div class="widget">
                <div class="widget-head">
                    <h3 class="panel-title">{{ trans('messages.fights_per_day') }}</h3>
                </div>
                <div class="chart-container">
                    <canvas id="fights-line" height="200px" data-label="{{ trans('messages.fights_per_day') }}" data-labels="{{ json_encode($fights->keys()) }}" data-dataset="{{ $fights->values()->toJson() }}"></canvas>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/modules/dashboard.js') }}" type="text/javascript"></script>
@endsection