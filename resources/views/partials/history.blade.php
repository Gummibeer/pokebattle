<nav class="am-right-sidebar">
    <div class="sb-content">
        <div class="am-scroller nano">
            <div class="nano-content">
                <div class="content padding-15">
                    @foreach($battlemessages as $battlemessage)
                        {!! \Michelf\MarkdownExtra::defaultTransform($battlemessage->message) !!}
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</nav>