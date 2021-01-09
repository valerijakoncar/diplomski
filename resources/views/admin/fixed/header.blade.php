<body>
<div class="blurBackgroundsAdmin" id="blurBgUpdateMovie">
    <div id="closeUpdateMovieFormHolder">
        <div id="closeUpdateMovieForm"></div>
    </div>
    <div id="updateMovieHolder">
        <p class="adminFormHeadline">Update Movie</p>
        <form id="updateMovieForm" action="{{url('updateMovie')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" id="movieIdHidden" name="movieIdHidden"/>
            <div class="labelInputHolder">
                <label class="inputAdminLabel">Movie name</label>
                <div class="labelInputHolderMultiple">
                    <input type="text" placeholder="Movie Name.." class="inputAdminClass" id="nameMovUpd" name="nameMovUpd"/>
                    <label class="inputAdminLabel inputAdminLabelSecond">Running time</label>
                    <input type="text" placeholder="Running time.." class="inputAdminClass" id="timeMovUpd" name="timeMovUpd"/>
                </div>
            </div>
            <div class="labelInputHolder">
                <label class="inputAdminLabel">Movie description</label>
                <textarea id="taShortDesc" name="taShortDesc" class="inputAdminClass"></textarea>
            </div>
            <div class="labelInputHolder">
                <label class="inputAdminLabel">Detailed description</label>
                <textarea id="taDetailedDesc" name="taDetailedDesc" class="inputAdminClass"></textarea>
            </div>
            <div class="labelInputHolder">
                    <label class="inputAdminLabel">Distributer</label>
                <div class="labelInputHolderMultiple">
{{--                    <input type="text" placeholder="Distrubuter.." class="inputAdminClass" id="distributerMovUpd"/>--}}
                    <select id="distributerMovUpd" name="distributerMovUpd" class="inputAdminClass">
                        <option value="0">Choose distributer..</option>
                        @foreach($distributers as $d)
                            <option value="{{$d->id}}">{{$d->name}}</option>
                        @endforeach
                    </select>
                     <label class="inputAdminLabel inputAdminLabelSecond">Director</label>
                    <select id="directorMovUpd" name="directorMovUpd" class="inputAdminClass">
                        <option value="0">Choose director..</option>
                        @foreach($directors as $d)
                            <option value="{{$d->id}}">{{$d->name}}</option>
                            @endforeach
                    </select>
                    <label class="inputAdminLabel inputAdminLabelSecond">Technology</label>
                    <select id="technologiesMovUpd" name="technologiesMovUpd" class="inputAdminClass">
                        @foreach($technologies as $t)
                            <option value="{{$t->id}}">{{$t->name}}</option>
                        @endforeach
                        <option value="3">All technologies.</option>
                    </select>
                </div>
            </div>
            <div class="labelInputHolder">
                <label class="inputAdminLabel">Country</label>
                <div class="labelInputHolderMultiple">
                    <select id="countryMovUpd" name="countryMovUpd" class="inputAdminClass">
                        <option value="0">Choose country..</option>
                        @foreach($countries as $c)
                            <option value="{{$c->id}}">{{$c->name}}</option>
                        @endforeach
                    </select>
                    <label class="inputAdminLabel inputAdminLabelSecond">In cinemas</label>
                    <input type="date" class="inputAdminClass" id="dateMovUpd" name="dateMovUpd"/>
                </div>
            </div>
            <div class="labelInputHolder">
                <label class="inputAdminLabel">Actors</label>
                <div class="selectAdminMovHolder">
                    <select class="inputAdminClass" id="actorsMovUpd" name="actorsMovUpd">
                        <option value="0">Choose actor..</option>
                        @foreach($actors as $a)
                            <option value="{{$a->id}}">{{$a->name}}</option>
                            @endforeach
                    </select>
                    <div id="actorsListMovUpd">
                    </div>
                </div>
            </div>
            <div class="labelInputHolder">
                <label class="inputAdminLabel">Genres</label>
                <div class="selectAdminMovHolder">
                    <select class="inputAdminClass" id="genresMovUpd" name="genresMovUpd">
                        <option value="0">Choose genre..</option>
                        @foreach($genres as $g)
                            <option value="{{$g->id}}">{{$g->genre}}</option>
                        @endforeach
                    </select>
                    <div id="genresListMovUpd">
                    </div>
                </div>
            </div>
            <div class="labelInputHolder">
                <label class="inputAdminLabel">Age limit</label>
                <div class="labelInputHolderMultiple">
                    <input type="text" class="inputAdminClass" id="ageMovUpd" name="ageMovUpd" placeholder="Age limit.."/>
                    <label class="inputAdminLabel inputAdminLabelSecond">Cooming soon</label>
                    <select class="inputAdminClass" id="csMovUpd" name="csMovUpd">
                        <option value="0">NO.</option>
                        <option value="1" selected="true">YES.</option>
                    </select>
                    <label class="inputAdminLabel inputAdminLabelSecond">Active Slider</label>
                    <select class="inputAdminClass" id="activeSliderMovUpd" name="activeSliderMovUpd">
                        <option value="0" selected="true">NO.</option>
                        <option value="1">YES.</option>
                    </select>
                </div>
            </div>
            <div class="labelInputHolder">
                <label class="inputAdminLabel">Movie poster</label>
                <div class="labelInputHolderMultiple">
                    <input type="file" class="inputAdminClass" id="picMovUpd" name="picMovUpd"/>
                    <label class="inputAdminLabel inputAdminLabelSecond">Movie bg</label>
                    <input type="file" class="inputAdminClass" id="picMovBgUpd" name="picMovBgUpd"/>
                    <label class="inputAdminLabel inputAdminLabelSecond">Slider pic</label>
                    <input type="file" class="inputAdminClass" id="picSliderMovUpd" name="picSliderMovUpd"/>
                </div>
            </div>
            <input type="submit" value="Update" id="updMov"/>
            <p class="errors error"></p>
                @isset($errors)
                <p class="error">
                    @foreach($errors->all() as $err)
                        {{ $err }}
                    @endforeach
                </p>
                @endisset
            @if(session()->has("error"))
                <p class="error">{{session("error")}}</p>
                @endif
            @if(session()->has("success"))
                <p class="success">{{session("success")}}</p>
            @endif
        </form>
    </div>

</div>

<div class="blurBackgroundsAdmin" id="blurBgInsertMovie">
    <div id="closeInsertMovieFormHolder">
        <div id="closeInsertMovieForm"></div>
    </div>
    <div id="insertMovieHolder">
        <p class="adminFormHeadline">Insert Movie</p>
        <form id="insertMovieForm" action="{{url('insertMovie')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="labelInputHolder">
                <label class="inputAdminLabel">Movie name</label>
                <div class="labelInputHolderMultiple">
                    <input type="text" placeholder="Movie Name.." class="inputAdminClass" id="nameMovIns" name="nameMovIns"/>
                    <label class="inputAdminLabel inputAdminLabelSecond">Running time</label>
                    <input type="text" placeholder="Running time.." class="inputAdminClass" id="timeMovIns" name="timeMovIns"/>
                </div>
            </div>
            <div class="labelInputHolder">
                <label class="inputAdminLabel">Movie description</label>
                <textarea id="taShortDescIns" name="taShortDescIns" class="inputAdminClass"></textarea>
            </div>
            <div class="labelInputHolder">
                <label class="inputAdminLabel">Detailed description</label>
                <textarea id="taDetailedDescIns" name="taDetailedDescIns" class="inputAdminClass"></textarea>
            </div>
            <div class="labelInputHolder">
                <label class="inputAdminLabel">Distributer</label>
                <div class="labelInputHolderMultiple">
                    {{--                    <input type="text" placeholder="Distrubuter.." class="inputAdminClass" id="distributerMovUpd"/>--}}
                    <select id="distributerMovIns" name="distributerMovIns" class="inputAdminClass">
                        <option value="0">Choose distributer..</option>
                        @foreach($distributers as $d)
                            <option value="{{$d->id}}">{{$d->name}}</option>
                        @endforeach
                    </select>
                    <label class="inputAdminLabel inputAdminLabelSecond">Director</label>
                    <select id="directorMovIns" name="directorMovIns" class="inputAdminClass">
                        <option value="0">Choose director..</option>
                        @foreach($directors as $d)
                            <option value="{{$d->id}}">{{$d->name}}</option>
                        @endforeach
                    </select>
                    <label class="inputAdminLabel inputAdminLabelSecond">Technology</label>
                    <select id="technologiesMovIns" name="technologiesMovIns" class="inputAdminClass">
                        @foreach($technologies as $t)
                            <option value="{{$t->id}}">{{$t->name}}</option>
                        @endforeach
                            <option value="3">All technologies.</option>
                    </select>
                </div>
            </div>
            <div class="labelInputHolder">
                <label class="inputAdminLabel">Country</label>
                <div class="labelInputHolderMultiple">
                    <select id="countryMovIns" name="countryMovIns" class="inputAdminClass">
                        <option value="0">Choose country..</option>
                        @foreach($countries as $c)
                            <option value="{{$c->id}}">{{$c->name}}</option>
                        @endforeach
                    </select>
                    <label class="inputAdminLabel inputAdminLabelSecond">In cinemas</label>
                    <input type="date" class="inputAdminClass" id="dateMovIns" name="dateMovIns"/>
                </div>
            </div>
            <div class="labelInputHolder">
                <label class="inputAdminLabel">Actors</label>
                <div class="selectAdminMovHolder">
                    <select class="inputAdminClass" id="actorsMovIns" name="actorsMovIns">
                        <option value="0">Choose actor..</option>
                        @foreach($actors as $a)
                            <option value="{{$a->id}}">{{$a->name}}</option>
                        @endforeach
                    </select>
                    <div id="actorsListMovIns">
                    </div>
                </div>
            </div>
            <div class="labelInputHolder">
                <label class="inputAdminLabel">Genres</label>
                <div class="selectAdminMovHolder">
                    <select class="inputAdminClass" id="genresMovIns" name="genresMovIns">
                        <option value="0">Choose genre..</option>
                        @foreach($genres as $g)
                            <option value="{{$g->id}}">{{$g->genre}}</option>
                        @endforeach
                    </select>
                    <div id="genresListMovIns">
                    </div>
                </div>
            </div>
            <div class="labelInputHolder">
                <label class="inputAdminLabel">Age limit</label>
                <div class="labelInputHolderMultiple">
                    <input type="text" class="inputAdminClass" id="ageMovIns" name="ageMovIns" placeholder="Age limit.."/>
                    <label class="inputAdminLabel inputAdminLabelSecond">Cooming soon</label>
                    <select class="inputAdminClass" id="csMovIns" name="csMovIns">
                        <option value="0">NO.</option>
                        <option value="1" selected="true">YES.</option>
                    </select>
                    <label class="inputAdminLabel inputAdminLabelSecond">Active Slider</label>
                    <select class="inputAdminClass" id="activeSliderMovIns" name="activeSliderMovIns">
                        <option value="0" selected="true">NO.</option>
                        <option value="1">YES.</option>
                    </select>
                </div>
            </div>
            <div class="labelInputHolder">
                <label class="inputAdminLabel">Movie poster</label>
                <div class="labelInputHolderMultiple">
                    <input type="file" class="inputAdminClass" id="picMovIns" name="picMovIns"/>
                    <label class="inputAdminLabel inputAdminLabelSecond">Movie bg</label>
                    <input type="file" class="inputAdminClass" id="picMovBgIns" name="picMovBgIns"/>
                    <label class="inputAdminLabel inputAdminLabelSecond">Slider pic</label>
                    <input type="file" class="inputAdminClass" id="picSliderMovIns" name="picSliderMovIns"/>
                </div>
            </div>
            <input type="submit" value="Insert" id="insMov"/>
            <p class="errors error"></p>
            @isset($errors)
                <p class="error">
                    @foreach($errors->all() as $err)
                        {{ $err }}
                    @endforeach
                </p>
            @endisset
            @if(session()->has("errorIns"))
                <p class="error">{{session("errorIns")}}</p>
            @endif
            @if(session()->has("successIns"))
                <p class="success">{{session("successIns")}}</p>
            @endif
        </form>
    </div>

</div>


<div class="blurBackgroundsAdmin" id="blurUpdateProj">
    <div id="closeUpdateProjFormHolder">
        <div id="closeUpdateProjForm"></div>
    </div>
    <div id="updateProjHolder">
        <p class="adminFormHeadline">Update projection</p>
        <form id="updateProjForm" action="{{url('updateProjection')}}" method="POST">
            @csrf
            <input type="hidden" id="idProjHidden" name="idProjHidden"/>
            <div class="labelInputHolder">
                <label class="inputAdminLabel">Movie</label>
                <select id="movieProjectionUpdate" name="movieProjectionUpdate" class="inputAdminClass">
                    <option value="0">Choose movie..</option>
                    @foreach($allMovies as $m)
                        <option value="{{$m->id}}">{{$m->name}}</option>
                        @endforeach
                </select>
            </div>
            <div class="labelInputHolder">
                <label class="inputAdminLabel">Projection date</label>
                <input type="date" id="dateProjectionUpdate" name="dateProjectionUpdate" class="inputAdminClass"/>
                <label class="inputAdminLabel inputAdminLabelSecond">Time</label>
                <input type="text" id="timeProjectionUpdate" name="timeProjectionUpdate" class="inputAdminClass"/>
            </div>
            <div class="labelInputHolder">
                <label class="inputAdminLabel">Technology</label>
                <select id="technProjectionUpdate" name="technProjectionUpdate" class="inputAdminClass">
                    <option value="0"></option>
                </select>
                <label class="inputAdminLabel inputAdminLabelSecond">Reservation</label>
                <select id="resProjectionUpdate" name="resProjectionUpdate" class="inputAdminClass">
                    <option value="0">Not available.</option>
                    <option value="1">Available.</option>
                </select>
            </div>
            <div class="labelInputHolder">
                <label class="inputAdminLabel">Hall</label>
                <select id="hallProjectionUpdate" name="hallProjectionUpdate" class="inputAdminClass">
                    <option value="0">Choose hall..</option>
                    @foreach($halls as $h)
                        <option value="{{$h->id}}">{{$h->name}}</option>
                    @endforeach
                </select>
            </div>
            <input type="submit" value="Update" id="updProj"/>
            <p class="errors error"></p>
            @isset($errors)
                <p class="error">
                    @foreach($errors->all() as $err)
                        {{ $err }}
                    @endforeach
                </p>
            @endisset
            @if(session()->has("errorUpdProj"))
                <p class="error">{{session("errorUpdProj")}}</p>
            @endif
            @if(session()->has("successUpdProj"))
                <p class="success">{{session("successUpdProj")}}</p>
            @endif
        </form>
    </div>
</div>

<div class="blurBackgroundsAdmin" id="blurBgUpdateUser">
    <div id="closeUpdateUserFormHolder">
        <div id="closeUpdateUserForm"></div>
    </div>
    <div id="updateUserHolder">
        <p class="adminFormHeadline">Update User</p>
        <form id="updateUserForm" action="#" method="POST">
            @csrf
            <input type="hidden" id="userIdHidden" name="userIdHidden"/>
            <div class="labelInputHolder">
                <label class="inputAdminLabel">Username</label>
                <div class="labelInputHolderMultiple">
                    <input type="text" placeholder="Username.." class="inputAdminClass" id="usernameUpd" name="usernameUpd"/>
                    <label class="inputAdminLabel inputAdminLabelSecond">Role</label>
                    <select id="roleUserUpd" name="roleUserUpd" class="inputAdminClass">
                        @foreach($roles as $r)
                            <option value="{{$r->id}}">{{$r->role}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="labelInputHolder">
                <label class="inputAdminLabel">Password</label>
                <input type="password" placeholder="New password.." class="inputAdminClass" id="passwordUpd" name="passwordUpd"/>
            </div>
            <div class="labelInputHolder">
                <label class="inputAdminLabel">Email</label>
                <input type="text" placeholder="Email.." class="inputAdminClass" id="emailUserUpd" name="emailUserUpd"/>
            </div>
            <div class="labelInputHolder">
                <label class="inputAdminLabel">Gender</label>
                <div class="labelInputHolderMultiple">
                    <select id="genderUserUpd" name="genderUserUpd" class="inputAdminClass">
                        @foreach($genders as $g)
                            <option value="{{$g->id}}">
                                @if($g->name == "f")
                                    {{"Female."}}
                                    @else
                                    {{"Male."}}
                                    @endif
                            </option>
                        @endforeach
                    </select>
                    <label class="inputAdminLabel inputAdminLabelSecond">Send news</label>
                    <select id="newsUserUpd" name="newsUserUpd" class="inputAdminClass">
                        <option value="0">Don't send.</option>
                        <option value="1">Send news.</option>
                    </select>
                </div>
            </div>
            <input type="submit" value="Update" id="updUser"/>
            <p class="errors error"></p>
            <p class="success"></p>
        </form>
    </div>

</div>


<div class="blurBackgroundsAdmin" id="blurBgUpdateLink">
    <div id="closeUpdateLinkFormHolder">
        <div id="closeUpdateLinkForm"></div>
    </div>
    <div id="updateLinkHolder">
        <p class="adminFormHeadline">Update Link</p>
        <form id="updateLinkForm" action="#" method="POST">
            @csrf
            <input type="hidden" id="linkIdHidden" name="linkIdHidden"/>
            <div class="labelInputHolder">
                <label class="inputAdminLabel">Text</label>
                <div class="labelInputHolderMultiple">
                    <input type="text" placeholder="Link text.." class="inputAdminClass" id="textLinkUpd" name="textLinkUpd"/>
                    <label class="inputAdminLabel inputAdminLabelSecond">Path</label>
                    <input type="text" placeholder="Link path.." class="inputAdminClass" id="pathLinkUpd" name="pathLinkUpd"/>
                </div>
            </div>
            <div class="labelInputHolder">
                <label class="inputAdminLabel">In header</label>
                <div class="labelInputHolderMultiple">
                   <select id="headerLinkUpd" name="headerLinkUpd" class="inputAdminClass">
                       <option value="0">No.</option>
                       <option value="1">Yes.</option>
                   </select>
                    <label class="inputAdminLabel inputAdminLabelSecond">In footer</label>
                    <select id="footerLinkUpd" name="footerLinkUpd" class="inputAdminClass">
                        <option value="0">No.</option>
                        <option value="1">Yes.</option>
                    </select>
                </div>
            </div>
            <div class="labelInputHolder">
                <label class="inputAdminLabel">Parent link</label>
                <div class="labelInputHolderMultiple">
                    <select id="parentLinkUpd" name="parentLinkUpd" class="inputAdminClass">
                        <option value="0">None.</option>
                        @foreach($links as $l)
                            <option value="{{$l->menu_id}}">{{$l->text}}</option>
                            @endforeach
                    </select>
                    <label class="inputAdminLabel inputAdminLabelSecond">Admin menu</label>
                    <div class="linkChbHolder">
                        <input type="checkbox" id="adminLinkUpd" name="adminLinkUpd"/>
                    </div>
                </div>
            </div>
            <input type="submit" value="Update" id="updLink"/>
            <p class="errors error"></p>
            <p class="success"></p>
        </form>
    </div>

</div>

<div class="blurBackgroundsAdmin" id="blurBgInsertLink">
    <div id="closeInsertLinkFormHolder">
        <div id="closeInsertLinkForm"></div>
    </div>
    <div id="insertLinkHolder">
        <p class="adminFormHeadline">Insert Link</p>
        <form id="insertLinkForm" action="#" method="POST">
            @csrf
            <div class="labelInputHolder">
                <label class="inputAdminLabel">Text</label>
                <div class="labelInputHolderMultiple">
                    <input type="text" placeholder="Link text.." class="inputAdminClass" id="textLinkIns" name="textLinkIns"/>
                    <label class="inputAdminLabel inputAdminLabelSecond">Path</label>
                    <input type="text" placeholder="Link path.." class="inputAdminClass" id="pathLinkIns" name="pathLinkIns"/>
                </div>
            </div>
            <div class="labelInputHolder">
                <label class="inputAdminLabel">In header</label>
                <div class="labelInputHolderMultiple">
                    <select id="headerLinkIns" name="headerLinkIns" class="inputAdminClass">
                        <option value="0">No.</option>
                        <option value="1">Yes.</option>
                    </select>
                    <label class="inputAdminLabel inputAdminLabelSecond">In footer</label>
                    <select id="footerLinkIns" name="footerLinkIns" class="inputAdminClass">
                        <option value="0">No.</option>
                        <option value="1">Yes.</option>
                    </select>
                </div>
            </div>
            <div class="labelInputHolder">
                <label class="inputAdminLabel">Parent link</label>
                <div class="labelInputHolderMultiple">
                    <select id="parentLinkIns" name="parentLinkIns" class="inputAdminClass">
                        <option value="0">None.</option>
                        @foreach($links as $l)
                            <option value="{{$l->menu_id}}">{{$l->text}}</option>
                        @endforeach
                    </select>
                    <label class="inputAdminLabel inputAdminLabelSecond">Admin menu</label>
                    <div class="linkChbHolder">
                        <input type="checkbox" id="adminLinkIns" name="adminLinkIns" selected="false"/>
                    </div>
                </div>
            </div>
            <input type="submit" value="Insert" id="insLink"/>
            <p class="errors error"></p>
            <p class="success"></p>
        </form>
    </div>

</div>


    <div id="adminHeader">
        <div id="adminHeaderHolder">
            <div id="topAdminHeader">
                <div id="rightAdminHeaderDiv">
                    <p id="helloAdmin">Hello
                        @if(session()->has('user'))
                            @if(session('user')->role_id == 2)
                                {{ session('user')->username."!"}}
                            @endif
                        @endif
                        <span class="fa fa-heart-o"></span>
                        <a href='{{ url("/logout") }}' id="logoutlink">Logout</a>
                </div>
                <div id="logoMessg">
                    <a href={{url('admin')}}>
                        <div id="logoHeader" class="logo">
                            <div id="popcornHeader" class="popcorn"></div>
                            <h1>MovieBlackout</h1>
                        </div>
                    </a>
                </div>
                <div class="cleaner"></div>
            </div>
            <div id="menuAdminDiv">
                <div id="menuBtnDivAdm">
                    <button id="menuBtnAdm">
                        <i class="fa fa-list"></i>Menu
                    </button>
                </div>
                <ul id="menuAdmin">
                    @foreach($menu as $m)
                        <li><a href="{{url(''.$m->href)}}">{{$m->text}}</a></li>
                        @endforeach
                </ul>
            </div>
        </div>
    </div>


