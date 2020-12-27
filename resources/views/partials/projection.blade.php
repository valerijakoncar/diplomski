<div class="movieProjection
 @if((!$p->reservation_available) || $p->projectionAlreadyStartedEnded)
     {{" disabledReservation"}}
     @endif
 ">
    @if(session()->has('user'))
        @if($p->reservation_available && (!$p->projectionAlreadyStartedEnded))
             <a href="{{ url('/continueReservation/'.$p->id) }}" data-id="{{$p->id}}" class="projectionLink">
                 @endif
    @endif
        <p class="movieTime">
            <?php
            $toDate = date_create($p->starts_at);
            $formattedDate = date_format($toDate, 'H:i');
            ?>
            {{ $formattedDate }}
            @if((!$p->reservation_available) || $p->projectionAlreadyStartedEnded)
                <span class="fa fa-ticket redTicket"></span>
            @else
                <span class="fa fa-ticket greenTicket"></span>
            @endif
        </p>
        <p class="movieHall">{{ $p->name }}</p>
        <p class="movieTechn">{{ $p->technologyName }}</p>
             @if(session()->has('user'))
                 @if($p->reservation_available && (!$p->projectionAlreadyStartedEnded))</a>@endif
                 @endif
</div>

