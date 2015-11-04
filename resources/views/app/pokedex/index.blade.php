@extends('app')

@section('content')
    <article class="panel">
        <header class="panel-heading">
            <h3 class="panel-title">{{ trans('menu.pokedex') }}</h3>
        </header>
        <div class="panel-body">
            {!! $pokemons->render() !!}
        </div>
        <div class="list-group">
            @foreach($pokemons as $pokemon)
                <div class="list-group-item" id="pokemon-{{ $pokemon->id }}">
                    <div class="media">
                        <div class="media-left">
                            <img class="media-object" src="{{ $pokemon->avatar }}" alt="{{ $pokemon->display_name }}">
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading">#{{ $pokemon->id }} {{ $pokemon->display_name }}</h4>
                            <div>
                                <strong>{{ trans('messages.types') }}</strong>
                                {{ implode(', ', $pokemon->types->pluck('display_name')->toArray()) }}
                            </div>
                            <ul class="list-inline margin-bottom-0">
                                <li><strong>HP</strong> {{ $pokemon->health }}</li>
                                <li><strong>ATK</strong> {{ $pokemon->attack }}</li>
                                <li><strong>DEF</strong> {{ $pokemon->defense }}</li>
                                <li><strong>SPD</strong> {{ $pokemon->speed }}</li>
                                <li><strong>EXP</strong> {{ $pokemon->experience }}</li>
                            </ul>
                            <div>
                                <strong>{{ trans('messages.moves') }}</strong>
                                {{ $pokemon->moves->count() }}
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="panel-footer">
            {!! $pokemons->render() !!}
        </div>
    </article>
@endsection