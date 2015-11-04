<nav class="am-right-sidebar">
    <div class="sb-content">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#sidebar-history" data-toggle="tab" class="text-center"><i class="icon wh-history"></i></a></li>
            <li><a href="#sidebar-battles" data-toggle="tab" class="text-center"><i class="icon wh-trophy"></i></a></li>
        </ul>

        <div class="tab-content">
            <div class="am-scroller nano tab-pane active" id="sidebar-history">
                <div class="nano-content">
                    <div class="content padding-15">
                        @foreach($battlemessages as $battlemessage)
                            {!! \Michelf\MarkdownExtra::defaultTransform($battlemessage->message) !!}
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="am-scroller nano tab-pane" id="sidebar-battles">
                <div class="nano-content">
                    <div class="content padding-15">
                        @foreach($battlehistories as $battlehistory)
                            <p>
                                <strong class="@if($battlehistory->attacker_win) text-success @else text-danger @endif">{{ $battlehistory->attacker->name }}</strong>
                                <i class="icon wh-pokemon" data-toggle="tooltip" data-placement="bottom" data-title="{{ $battlehistory->attackerPokemon->display_name }}"></i>
                                vs
                                <strong class="@if(!$battlehistory->attacker_win) text-success @else text-danger @endif">{{ $battlehistory->defender->name }}</strong>
                                <i class="icon wh-pokemon" data-toggle="tooltip" data-placement="bottom" data-title="{{ $battlehistory->defenderPokemon->display_name }}"></i>
                            </p>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>