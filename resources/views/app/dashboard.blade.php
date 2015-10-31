@extends('app')

@section('content')
    <div class="row">
        <div class="col-md-3">
            <div class="widget">
                <div class="widget-head">
                    <h3 class="panel-title">{{ trans('messages.pokemons_per_type') }}</h3>
                </div>
                <div class="chart-container">
                    <canvas id="type-radar" height="200px" data-label="{{ trans('messages.pokemons_per_type') }}" data-labels="{{ $types->pluck('name')->toJson() }}" data-dataset="{{ $types->map(function($item) { return $item->pokemons->count(); })->toJson() }}"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="widget">
                <div class="widget-head">
                    <h3 class="panel-title">{{ trans('messages.pokemon_of_the_day') }}</h3>
                </div>
                <div class="media">
                    <div class="media-left">
                        <img class="media-object" src="{{ $pokemonOfTheDay->avatar }}" alt="{{ $pokemonOfTheDay->name }}">
                    </div>
                    <div class="media-body">
                        <h4 class="media-heading">#{{ $pokemonOfTheDay->id }} {{ $pokemonOfTheDay->name }}</h4>
                        <div>
                            <strong>{{ trans('messages.types') }}</strong>
                            {{ implode(', ', $pokemonOfTheDay->types->pluck('name')->toArray()) }}
                        </div>
                        <ul class="list-inline margin-bottom-0">
                            <li><strong>HP</strong> {{ $pokemonOfTheDay->health }}</li>
                            <li><strong>ATK</strong> {{ $pokemonOfTheDay->attack }}</li>
                            <li><strong>DEF</strong> {{ $pokemonOfTheDay->defense }}</li>
                            <li><strong>SPD</strong> {{ $pokemonOfTheDay->speed }}</li>
                        </ul>
                        <div>
                            <strong>{{ trans('messages.moves') }}</strong>
                            {{ $pokemonOfTheDay->moves->count() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
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
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/modules/dashboard.js') }}" type="text/javascript"></script>
@endsection