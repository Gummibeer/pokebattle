<nav class="am-right-sidebar">
    <div class="sb-content">
        <div class="tab-navigation">
            <ul class="nav nav-tabs nav-justified">
                <li class="active"><a href="#sidebar-battles" data-toggle="tab" class="text-center"><i class="icon wh-trophy"></i></a></li>
                <li><a href="#sidebar-history" data-toggle="tab" class="text-center"><i class="icon wh-history"></i></a></li>
                <li><a href="#sidebar-highscore" data-toggle="tab" class="text-center"><i class="icon wh-podium-winner"></i></a></li>
            </ul>
        </div>

        <div class="tab-panel">
            <div class="tab-content white">
                <div class="am-scroller nano tab-pane active" id="sidebar-battles">
                    <div class="nano-content">
                        <div class="content padding-15">
                            @foreach($battlehistories as $battlehistory)
                                <p>
                                    <strong class="@if($battlehistory->attacker_win) text-primary @endif" data-toggle="tooltip" data-placement="bottom" data-title="{{ $battlehistory->attackerPokemon->display_name }}">{{ object_get($battlehistory->attacker, 'name', 'BOT') }}</strong>
                                    vs
                                    <strong class="@if(!$battlehistory->attacker_win) text-primary @endif" data-toggle="tooltip" data-placement="bottom" data-title="{{ $battlehistory->defenderPokemon->display_name }}">{{ object_get($battlehistory->defender, 'name', 'BOT') }}</strong>
                                </p>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="am-scroller nano tab-pane" id="sidebar-history">
                    <div class="nano-content">
                        <div class="content padding-15">
                            @foreach($battlemessages as $battlemessage)
                                {!! \Michelf\MarkdownExtra::defaultTransform($battlemessage->message) !!}
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="am-scroller nano tab-pane" id="sidebar-highscore">
                    <div class="nano-content">
                        <div class="content padding-15">
                            @foreach($highscores as $highscore)
                            <p>
                                <strong>{{ $highscore->name }}</strong>
                                <i class="icon wh-pokemon" data-toggle="tooltip" data-placement="bottom" data-title="{{ $highscore->pokemon->display_name }}"></i>
                                {{ $highscore->experience }} EXP
                            </p>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>