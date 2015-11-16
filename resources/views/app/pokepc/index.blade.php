@extends('app')

@section('content')
    <article class="panel">
        <header class="panel-heading">
            <h3 class="panel-title">{{ trans('menu.pokepc') }}</h3>
        </header>
        <div class="panel-body">
            {!! $pokemons->render() !!}

            <div class="row">
                @foreach($pokemons as $pokemon)
                    <div class="col-lg-4 col-md-6 margin-bottom-30">
                        <div class="media">
                            <div class="media-left">
                                <img class="media-object @if(!$pokemon->catched()) disabled @endif" src="{{ $pokemon->avatar }}" alt="{{ $pokemon->display_name }}">
                            </div>
                            <div class="media-body">
                                <div class="clearfix">
                                    <h4 class="media-heading pull-left">#{{ $pokemon->id }} {{ $pokemon->display_name }}</h4>
                                    <span class="pull-right">LvL {{ getCurLvl(null, $pokemon) }} | {{ getRelativeCurExp(null, $pokemon) }} / {{ getRelativeNeededExp(null, $pokemon) }} EXP</span>
                                </div>
                                <div class="progress height-5 margin-bottom-5" data-toggle="tooltip" data-placement="bottom" title="{{ getLvlPercentage(null, $pokemon) }} %">
                                    <div class="progress-bar" style="width: {{ getLvlPercentage(null, $pokemon) }}%;"></div>
                                </div>
                                <div>
                                    <strong>{{ trans('messages.types') }}</strong>
                                    {{ implode(', ', $pokemon->types->pluck('display_name')->toArray()) }}
                                </div>
                                <ul class="list-inline margin-bottom-0">
                                    <li><strong>HP</strong> {{ getHealth(null, $pokemon) }}</li>
                                    <li><strong>ATK</strong> {{ getAtk(null, $pokemon) }}</li>
                                    <li><strong>DEF</strong> {{ getDef(null, $pokemon) }}</li>
                                    <li><strong>SPD</strong> {{ getSpd(null, $pokemon) }}</li>
                                    <li><strong>EXP</strong> {{ $pokemon->experience }}</li>
                                </ul>
                                <div>
                                    <p>
                                        <strong>{{ trans('messages.moves') }}</strong>
                                        {{ $pokemon->moves->count() }}
                                        <a data-toggle="collapse" href="#moves-{{ $pokemon->id }}"><i class="icon wh-list"></i></a>
                                    </p>
                                    <div class="collapse" id="moves-{{ $pokemon->id }}">
                                        <div class="well">
                                            <ul class="list-inline margin-bottom-0">
                                                @foreach($pokemon->moves()->orderBy('power')->get() as $move)
                                                    <li>{{ $move->display_name }} ({{ $move->power }})</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {!! $pokemons->render() !!}
        </div>
    </article>
@endsection