<div class="movieAdmin">
    <div class="moviePicAdmin movieInfoAdmin">
        @if(strpos($movie->path, "cloudinary"))
            <img src="{{ $m->path . $m->picName }}" alt="{{ $m->alt }}"/>
            @else
        <img src="{{ asset($m->path . $m->picName) }}" alt="{{ $m->alt }}"/>
        @endif
{{--        width="120" height="180"--}}
        <div class="underImgMovieAdm">
            <p class="movieDateAdmin">Date aired:
                <?php
                $toDate = date_create($m->in_cinemas_from);
                $formattedDate = date_format($toDate, 'd.m.Y.');
                ?>
                <span>{{ $formattedDate }}</span>
            </p>
            <p>
                <?php $i=0; ?>
                @foreach($m->genres as $genre)
                    <?php $i++; ?>
                    {{ $genre->genre }}
                    @if(count($m->genres) != $i)
                        {{ "," }}
                    @endif
                @endforeach
                | <span class="fa fa-clock-o"></span> {{ $m->running_time }} min
            </p>
        </div>
    </div>
    <div class="movieNameAdmin movieInfoAdmin">
        <p class="headlineAdmMovie">Movie name</p>
        {{$m->movieName}}
        <p class="headlineAdmMovie headlineAdmActors">Actors</p>
        <p class="actorsAdmMovie">
            @for($i=0; $i<count($m->actors); $i++)
                @if($i === count($m->actors)-1)
                    {{$m->actors[$i]->name}}
                @else
                    {{$m->actors[$i]->name . ", "}}
                @endif
            @endfor
        </p>
    </div>
    <div class="movieRatingAdmin movieInfoAdmin">
        <p class="headlineAdmMovie">Rating</p>
        <p class="numberMovieGrade">{{ $m->grade }}</p>
        @component("partials.movie_stars",["movie" => $m])
        @endcomponent
    </div>
    <div class="movieDirectorAdmin movieInfoAdmin">
        <p class="headlineAdmMovie">Director</p>
        {{$m->dirName}}
    </div>
    <div class="movieDescAdmin movieInfoAdmin">
        <p class="headlineAdmMovie">Description</p>
        <p class="admDescP">{{$m->description}}</p>
    </div>
    <div class="movieInfoAdmin btnsAdminMovies">
        <div><input type="button" value="Update" class="btnUpdateMov" data-id="{{$m->idMovie}}"/></div>
        <div><a href="{{url('deleteMovie/'. $m->idMovie)}}" data-id="{{$m->idMovie}}" class="btnDeleteMov">Delete</a></div>
{{--        <input type="button" value="Delete" class="btnDeleteMov" data-id="{{$m->idMovie}}"/>--}}
    </div>
</div>
