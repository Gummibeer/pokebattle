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
                        <h4 class="media-heading">{{ $pokemonOfTheDay->name }}</h4>
                        <div>
                            <strong>{{ trans('messages.types') }}</strong>
                            {{ implode(', ', $pokemonOfTheDay->types->pluck('name')->toArray()) }}
                        </div>
                        <ul class="list-inline margin-bottom-0">
                            <li>
                                <strong>HP</strong>
                                {{ $pokemonOfTheDay->health }}
                            </li>
                            <li>
                                <strong>ATK</strong>
                                {{ $pokemonOfTheDay->attack }}
                            </li>
                            <li>
                                <strong>DEF</strong>
                                {{ $pokemonOfTheDay->defense }}
                            </li>
                            <li>
                                <strong>SPD</strong>
                                {{ $pokemonOfTheDay->speed }}
                            </li>
                        </ul>
                        <div>
                            <strong>{{ trans('messages.moves') }}</strong>
                            {{ $pokemonOfTheDay->moves->count() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection