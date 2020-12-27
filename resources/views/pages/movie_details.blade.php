@extends("template")
@section("title")
    {{$movie->movieName}}
@endsection
@section("mainContent")
   <div id="backgroundPic" style="background-image: url('{{asset($movie->backgroundPicName->path.$movie->backgroundPicName->name)}}');">
       <div id="transparentDivOnBg">
           <div id="abtMovie">
               <div class="fancyTitle">
                   <div class="fancyTitlePre">
                       <div class="line"></div>
                       <div class="end"></div>
                   </div>
                   <div class="fancyTitleInner">
                       <h2>{{$movie->movieName}}</h2>
                   </div>
                   <div class="fancyTitlePost">
                       <div class="end"></div>
                       <div class="line"></div>
                   </div>
               </div>
               <div id="movieInformation">
                   <div id="leftMovieInformation">
                        <img src="{{ asset($movie->path . $movie->picName) }}" alt="{{ $movie->alt }}" width="200px" height="300px"/>
                       <?php
                       $toDate = date_create($movie->in_cinemas_from);
                       $formattedDate = date_format($toDate, 'd.m.Y');
                       ?>
                       <p><span class="fa fa-calendar"></span> In cinemas from: {{$formattedDate}}</p>
                       <p><span class="fa fa-flag"></span> Country - {{$movie->country}}</p>
                       <?php if(session()->has('user') ){ ?>
{{--                       && session("user")->role_id === 1--}}
{{--                       <a href="#"class="vote">Rate?</a>--}}
                       <a href="#" class="detailsLink vote" data-movid="{{$movie->idMovie}}" id="abtMovieBook">Rate ?</a>
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
                   <div id="rightMovieInformation">
                        <div id="rightMovieInformationTransparent">
                                <div class="fancy-box">
                                    <span class="fancy-box__tl"></span>
                                    <span class="fancy-box__tr"></span>
                                    <span class="fancy-box__bl"></span>
                                    <span class="fancy-box__br"></span>
                                    <span class="fancy-box__sides"></span>
                                    <div class="fancy-box__inner">
                                        <table id="tableInfo">
                                            <tr>
                                                <td>Rating</td>
                                                <td class="ratingTd">
                                                    <p class="numberMovieGrade numberMovieGradeMovDet">{{$movie->grade}}</p>
                                                    @component("partials.movie_stars",["movie" => $movie])
                                                    @endcomponent
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    Category
                                                </td>
                                                <td>
                                                    <?php $i=0; ?>
                                                    @foreach($movie->genres as $genre)
                                                        <?php $i++; ?>
                                                        {{ $genre->genre }}
                                                        @if(count($movie->genres) != $i)
                                                            {{ "," . " " }}
                                                        @endif
                                                    @endforeach
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Running time</td>
                                                <td><span class="fa fa-clock-o"></span> {{$movie->running_time}}min</td>
                                            </tr>
                                            <tr>
                                                <td>Rated</td>
                                                <td><p class="ageLimit">{{$movie->age_limit}}</p></td>
                                            </tr>
                                            <tr>
                                                <td>Actors</td>
                                                <td id="actorsTd">
                                                    <?php $i = 0;?>
                                                    @foreach($movie->actors as $a)
                                                        <?php $i++; ?>
                                                       {{$a->name}}
                                                            @if(count($movie->actors) !== $i)
                                                            {{", "}}
                                                            @endif

                                                        @endforeach
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Director</td>
                                                <td>{{$movie->director}}</td>
                                            </tr>
                                            <tr>
                                                <td>Distributer</td>
                                                <td>{{$movie->distributer}}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                        </div>
                   </div>
               </div>
           </div>
           <div id="tapeHolder">
               <div class="tape">
                   <div class="tapeHold"></div>
               </div>
{{--               <div class="tape">--}}
{{--                   <div class="tapeHold"></div>--}}
{{--               </div>--}}
           </div>
       </div>
   </div>
    <div id="centeredWrapper">
        <div id="plot">
            <h2>Movie plot</h2>
            <div class="decorationalDiv">
                <span></span>
            </div>
            <div id="plotText">
                {{$movie->description_detailed}}
            </div>
        </div>
{{--        <div id="projectionsMovie">--}}
{{--            <div id="picHeadlineMovDet">--}}
{{--                <h2>Projections</h2>--}}
{{--            </div>--}}
{{--            <div class="decorationalDiv">--}}
{{--                <span></span>--}}
{{--            </div>--}}
{{--            <div id="movProj">--}}
{{--                <div class="sparkleCam">--}}
{{--                    <div class="cameraDecorationHeadline"></div>--}}
{{--                    <div class="sparkle"></div>--}}
{{--                </div>--}}
{{--                <div id="movProjHolder">--}}
{{--                    @foreach($movie->projections as $p)--}}
{{--                        <div class="movieProjection--}}
{{--                         @if((!$p->reservation_available) || $p->projectionAlreadyStartedEnded)--}}
{{--                                                {{" disabledReservation"}}--}}
{{--                                                @endif--}}
{{--                        ">--}}
{{--                            @if(session()->has('user'))--}}
{{--                                @if($p->reservation_available && (!$p->projectionAlreadyStartedEnded))--}}
{{--                                    <a href="{{ url('/continueReservation/'.$p->id) }}" data-id="{{$p->id}}" class="projectionLink">--}}
{{--                                        @endif--}}
{{--                                    @endif--}}
{{--                            <p class="movieTime">--}}
{{--                                <?php--}}
{{--                                $toDate = date_create($p->starts_at);--}}
{{--                                $formattedDate = date_format($toDate, 'H:i');--}}
{{--                                ?>--}}
{{--                                {{ $formattedDate }}--}}
{{--                                @if((!$p->reservation_available) || $p->projectionAlreadyStartedEnded)--}}
{{--                                    <span class="fa fa-ticket redTicket"></span>--}}
{{--                                @else--}}
{{--                                    <span class="fa fa-ticket greenTicket"></span>--}}
{{--                                @endif--}}
{{--                            </p>--}}
{{--                            <p class="movieHall">{{ $p->name }}</p>--}}
{{--                            <p class="movieTechn">{{ $p->technologyName }}</p>--}}
{{--                               @if(session()->has('user'))--}}
{{--                                    @if($p->reservation_available && (!$p->projectionAlreadyStartedEnded))--}}
{{--                                        </a>--}}
{{--                                    @endif--}}
{{--                                @endif--}}
{{--                        </div>--}}
{{--                    @endforeach--}}
{{--                    <div class="cleaner"></div>--}}
{{--                </div>--}}
{{--                <div class="sparkleCam">--}}
{{--                    <div class="sparkle"></div>--}}
{{--                    <div class="cameraDecorationHeadline" id="rotatedCam"></div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
    </div>
    <div id="comments">
        <div id="commentsTransparent">
            <h3><span class="fa fa-comment"></span>Comments<span id="numOfComments">(<span id="commentsNumber"><?php echo($movie->commentsCount);?></span>)</span></h3>
            <div id="peopleComments">
                @if(session()->has('user'))
                    <form id="postCommentForm" action="#" method="POST">
                        @csrf
                        <div id="leaveComm">
                            <div class="userFaHolder">
                                @if(session('user')->role_id == 2)
                                    <p class="adminComment">Admin</p>
                                @endif
                                <span class="fa fa-user
                                 @if(session('user')->gender_id == 1)
                                    femaleUser
                                    @else
                                    maleUser
                                @endif
                                "></span>
                                <p class="memberSince">Member since</p>
                                    <?php
                                    $toDate = date_create(session('user')->registered_at);
                                    $formattedDate = date_format($toDate, 'd.m.Y');
                                    ?>
                                <p class="memberDate">{{$formattedDate}}</p>
                            </div>
                            <div class="commentRight">
                                <div class="topPartComment">
                                    <span class="usernameComment">{{session('user')->username}}</span>
                                </div>
                                <textarea id="myComment" placeholder="Leave a comment..."></textarea>
                            </div>
                            <span class="fa fa-pencil" data-movid="{{$movie->idMovie}}"></span>
                        </div>
                    </form>
                @endif
                @foreach($movie->comments as $c)
                    @component("partials.comment",["c" => $c])
                    @endcomponent
                @endforeach
            </div>
            <a href="#" id="viewMoreCom" data-movid="{{$movie->idMovie}}">View more ...</a>
{{--            {{url(''.'/movie/'.$movie->idMovie)}}--}}
        </div>
    </div>
    @endsection
