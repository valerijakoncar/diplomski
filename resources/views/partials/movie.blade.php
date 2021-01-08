<div class="movie">
    <div class="picGeneralMovieInfo">
        <div class="moviePic">
            <a href="{{ url('movie/'.$movie->idMovie) }}">
                @if(strpos($movie->path, "cloudinary"))
                    <img src="{{$movie->path . $movie->picName }}" alt="{{ $movie->alt }}" width="250" height="350"/>
                    @else
                    <img src="{{ asset($movie->path . $movie->picName) }}" alt="{{ $movie->alt }}" width="250" height="350"/>
                    @endif
            </a>
        </div>
        <div class="generalMovieInfo">
            <a href="{{ url('movie/'.$movie->idMovie) }}">
                <h3>{{ $movie->movieName }}<span class="ageLimit">{{ $movie->age_limit }}</span></h3>
            </a>
            <div class="movieGrade">
                            <p class="numberMovieGrade">{{ $movie->grade }}</p>
                            @component("partials.movie_stars",["movie" => $movie])
                                @endcomponent
                <?php if(session()->has('user') && session("user")->role_id === 1){ ?>
                <a href="#"class="vote">Rate?</a>
                    <div class="voteDiv">
                        <div class="giveVote">
                            <div class="faCloseRateCloud"><span class="fa fa-close"></span></div>
                            <p>{{$movie->movieName}}</p>
                            <ul class="giveVoteList">
                                @for($i = 0; $i < 10; $i++)
                                    <li><span class="fa fa-star-o" data-index="{{$i}}"></span></li>
                                    @endfor
                            </ul>
                            <span class="userChosenGrade">0.0</span>
                            <input type="button" value="Rate" class="confirmVote" data-movid="{{$movie->idMovie}}"/>
                        </div>
                    </div>
                <?php  } ?>
             </div>
            <p class="movieDesc">{{ $movie->description }}</p>
            <p>
                <?php $i=0; ?>
                @foreach($movie->genres as $genre)
                   <?php $i++; ?>
                    {{ $genre->genre }}
                    @if(count($movie->genres) != $i)
                        {{ "," . " " }}
                        @endif
                    @endforeach
                | <span class="fa fa-clock-o"></span> {{ $movie->running_time }} min
            </p>
            <p class="movieDate">In cinemas from:
                <?php
                    $toDate = date_create($movie->in_cinemas_from);
                    $formattedDate = date_format($toDate, 'd.m.Y.');
                ?>
                <span>{{ $formattedDate }}</span>
            </p>
            <a href="{{ url('movie/'.$movie->idMovie) }}" class="detailsLink">View details</a>
        </div>
    </div>
    <div class="movieProjections">
        @foreach($movie->projections as $p)
            @component("partials.projection",["p" => $p])
                @endcomponent
            @endforeach
        <div class="cleaner"></div>
    </div>
</div>
<div class="decorationalMovieDiv"></div>
