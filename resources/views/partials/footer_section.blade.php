<div class="footerInfo">
    <h4>{{$footerHeadline->headline}}</h4>
    <ul>
        @foreach($footerSectionMenu as $fsm)
            @if($footerHeadline->id == $fsm->footer_headline_id)
                <li>
                    <a href="{{ $fsm->href }}">{{ $fsm->text }}</a>
                </li>
                @endif
            @endforeach
    </ul>
</div>
