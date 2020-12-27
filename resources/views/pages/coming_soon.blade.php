@extends("template")
@section("title")
    Cooming Soon
@endsection
@section("mainContent")
    <div id="centeredComingSoon">
        <div id="curtain">

        </div>
        <div id="csHolderOpacity">
            <h2>Coming Soon</h2>
            <div class="decorationalDiv">
                <span></span>
            </div>
            <div id="csMovieHolder">
                @foreach($coming_soon as $cs)
                    <div class="cs_movie">
                        <img src="{{asset($cs->path . $cs->picName)}}" alt="{{$cs->alt}}" class="imgCS" width="230" height="350"/>
                        <?php
                        $toDate = date_create($cs->in_cinemas_from);
                        $formattedDate = date_format($toDate, 'd.m.Y.');
                        ?>
                        <div class="csInfoHolder">
                            <p class="inCinemasCS"><span>In cinemas from:</span> {{$formattedDate}}</p>
                            <p class="genresCS">
                                <?php $i=0; ?>
                                @foreach($cs->genres as $genre)
                                    <?php $i++; ?>
                                    {{ $genre->genre }}
                                    @if(count($cs->genres) != $i)
                                        {{ "," . " " }}
                                    @endif
                                @endforeach
                            </p>
                            <p><span class="fa fa-clock-o"></span> {{ $cs->running_time }} min</p>
                        </div>
                    </div>
                @endforeach
                <div class="cleaner"></div>
            </div>
        </div>
    </div>
    @endsection
