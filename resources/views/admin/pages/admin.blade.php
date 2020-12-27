@extends("admin.admin_template")
@section("title")
    Admin
@endsection
@section("mainContent")
    <div id="centeredAdmin">
        <div id="adminMovies">
            <h2>Movies</h2>
            <div class="decorationalDiv">
                <span></span>
            </div>
            <button id="insertMovie"><span class="fa fa-plus"></span>New</button>
            <div id="searchContAdm">
                <input type="text" name="search" id="extendSearchAdm" class="extended" placeholder="Search for movies..">
                <span class="fa fa-search searchicon" aria-hidden="true"></span>
                <span class="fa fa-close notVisible" aria-hidden="true"></span>
            </div>
            <div class="cleaner"></div>
            <div id="adminMoviesHolder">
                @foreach($movies as $m)
                    @component("admin.partials.movie",["m" => $m])
                        @endcomponent
                    @endforeach
            </div>
            <div id="paginationDiv" class="paginationAdminDiv">
                <ul id="pagination">
                    <?php
                    for($i = 0; $i < $pages; $i++):
                    ?>
                    <li>
                        <a href="#" class="<?php if($i == 0){ echo "activePagination";}?> paginationAdmMov" data-limit="<?= $i ?>"><?= $i+1 ?></a>
                    </li>
                    <?php endfor;  ?>
                </ul>
            </div>
        </div>
        <div id="adminProjections">
            <h2>Projections</h2>
            <div class="decorationalDiv">
                <span></span>
            </div>
            <div id="projectionsNumDiv">
                <p id="projNumP">Number of projections:</p>
                <input type="number" id="numOfProjections" name="numOfProjections" class="inputAdminClass" min="1" max="5" value="1"/>
            </div>
            <div id="projectionsToInsertDiv">
                <form method="POST" action="{{url("insertProjections")}}" id="projectionsForm" name="projectionsForm">
                    @csrf
                    <div class="adminProjection">
                        <div class="projectionRow">
                            <div class="projectionMovieLabel projectionLabel">
                                <label class="projectionLab">Movie:</label>
                                <select name="projectionMovie[]" class="projectionMovie inputAdminClass">
                                    <option value="0">Choose movie..</option>
                                    @foreach($allMovies as $m)
                                        <option value="{{$m->id}}">{{$m->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="projectionDateLabel projectionLabel">
                                <label class="projectionLab">Projection date:</label>
                                <input type="date" name="projectionDate[]" class="projectionDate inputAdminClass"/>
                            </div>
                            <div class="projectionTimeLabel projectionLabel">
                                <label class="projectionLab">Projection time:</label>
                                <input type="text" name="projectionTime[]" class="projectionTime inputAdminClass" placeholder="Projection time.."/>
                            </div>
                            <div class="projectionTechnologyLabel projectionLabel">
                                <label class="projectionLab">Technology:</label>
                                <select name="projectionTechnology[]" class="projectionTechnology inputAdminClass">
                                    <option value="0">Choose technology..</option>
                                </select>
                            </div>
                            <div class="projectionHallLabel projectionLabel">
                                <label class="projectionLab">Hall:</label>
                                <select name="projectionHall[]" class="projectionHall inputAdminClass">
                                    <option value="0">Choose hall..</option>
                                    @foreach($halls as $h)
                                        <option value="{{$h->id}}">{{$h->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="projectionResAvailableLabel projectionLabel">
                                <label class="projectionLab">Reservation:</label>
                                <select name="projectionResAvailable[]" class="projectionResAvailable inputAdminClass">
                                    <option value="0">Not available.</option>
                                    <option value="1" selected="true">Available.</option>
                                </select>
                            </div>
                            <div class="cleaner"></div>
                        </div>
                        <p class="error"></p>
                    </div>
                    @isset($errors)
                        <p class="error">
                            @foreach($errors->all() as $err)
                                {{ $err }}
                            @endforeach
                        </p>
                    @endisset
                    @if(session()->has('errorProjectionInsert'))
                        <p class="error">
                            {{session("errorProjectionInsert")}}
                        </p>
                    @endif
                    @if(session()->has('successProjectionInsert'))
                    <p class="success">
                        {{session("successProjectionInsert")}}
                    </p>
                    @endif
                    <input type="submit" value="Confirm" id="projectionsInsert" name="projectionsInsert"/>
                </form>
                <a href="#" id="seeProjections">
                    View projections <span class="fa fa-hand-o-down"></span>
                </a>
            </div>
            <div id="viewProjections">
                <input type="search" placeholder="Movie name.." id="searchProjections" name="searchProjections"/>
                <div id="admProj">
                    <div id="projectionLabels">
                        <label>Movie</label>
                        <label>Projection time</label>
                        <label>Technology</label>
                        <label>Hall</label>
                        <label>Reservation</label>
                        <label class="lastPr"></label>
                    </div>
                    <div id="projectionViews">
                        @foreach($projections as $p)
                            <?php
                            $toDate = date_create($p->starts_at);
                            $formattedDate = date_format($toDate, 'd.m.Y.  H:i');
                            ?>
                            <div class="projectionViewRow">
                                <div class="prMovie prInfo">{{$p->name}}</div>
                                <div class="prDate prInfo">{{$formattedDate}}</div>
                                <div class="prTechn prInfo">{{$p->technName}}</div>
                                <div class="prHall prInfo">{{$p->hallName}}</div>
                                <div class="prRes prInfo">
                                    @if($p->reservation_available)
                                        Available.
                                    @else
                                        Not available.
                                    @endif
                                </div>
                                <div class="prUPdDel prInfo lastPr">
                                    <span class="fa fa-edit" data-id="{{$p->id}}"></span>
                                   <a href="{{url("deleteProjection/". $p->id)}}"><span class="fa fa-remove"></span></a>
                                </div>
                            </div>
                            <div class="projAdmBorder"></div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div id="adminUsers">
            <div id="adminUsersBg">
                <h2>Users</h2>
                <div class="decorationalDiv">
                    <span></span>
                </div>
                <div id="admUsersTableDiv">
                    <table id="tableUsers">
                        <tr>
                            <th>Num.</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Password</th>
                            <th>Role</th>
                            <th>Send news</th>
                            <th>Gender</th>
                            <th></th>
                        </tr>
                        <?php $i = 0; ?>
                        @foreach($users as $u)
                            <?php ++$i; ?>
                            <tr>
                                <td>{{$i}}.</td>
                                <td>{{$u->username}}</td>
                                <td>{{$u->email}}</td>
                                <td>{{$u->password}}</td>
                                <td>{{$u->roleName}}.</td>
                                <td>
                                    @if($u->send_via_mail)
                                        {{"Send."}}
                                        @else{{"Don't send."}}
                                        @endif
                                </td>
                                <td>
                                    @if($u->genderName == 'f')
                                        {{"Female."}}
                                        @else{{"Male."}}
                                        @endif
                                </td>
                                <td>
                                    <div><span class="fa fa-edit" data-id="{{$u->idUser}}"></span></div>
                                    <div><a href="{{url('deleteUser/'.$u->idUser)}}"><span class="fa fa-remove"></span></a></div>
                                </td>
                            </tr>
                            @endforeach
                    </table>
                </div>
            </div>
        </div>
        <div id="commentsLinksAdmin">
            <div id="commentsAdmin">
                <h2>Comments</h2>
                <div class="decorationalDiv">
                    <span></span>
                </div>
                <div id="commentsHolderAdmin">
                    @foreach($comments as $c)
                        <div class="adminComment">
                                <div class="comment">
                                    <div class="userFaHolder">
                                        <span class="fa fa-user
                                        @if($c->gender_id == 1)
                                        {{ "femaleUser " }}
                                        @else
                                        {{"maleUser "}}
                                        @endif
                                            "></span>
                                        <p class="memberSince">Member since</p>
                                        <?php
                                        $toDate = date_create($c->registered_at);
                                        $formattedDate = date_format($toDate, 'd.m.Y');
                                        ?>
                                        <p class="memberDate">{{$formattedDate}}</p>
                                    </div>
                                    <div class="commentRight">
                                        <div class="topPartComment">
                                            <span class="usernameComment">{{$c->username}}</span>
                                            <?php
                                            $toDate = date_create($c->posted_at);
                                            $formattedDate = date_format($toDate, 'd.m.Y H:i');
                                            ?>
                                            <span class="commPosted">{{$formattedDate}}</span>
                                            @if($c->updated_at)
                                                <span class="editedComm">Edited</span>
                                            @endif
                                        </div>
                                        <div class="commentTextDiv">
                                            <div class="commText">{{$c->text}}</div>
                                        </div>
                                    </div>
                                    <span class="fa fa-remove" data-id="{{$c->id}}"></span>
                                </div>
                        </div>
                        @endforeach
                </div>
            </div>
            <div class="decorationalAdminDiv"></div>
            <div id="linksAdmin">
                <h2>Links</h2>
                <div class="decorationalDiv">
                    <span></span>
                </div>
                <button id="insertLink"><span class="fa fa-plus"></span>New</button>
                <div id="tableLinksDiv">
                    <table id="linksTable">
                        <tr>
                            <th>Num.</th>
                            <th>Text</th>
                            <th>Path</th>
                            <th>In header</th>
                            <th>In footer</th>
                            <th>Admin menu</th>
                            <th></th>
                        </tr>
                        <?php $i = 0; ?>
                        @foreach($links as $l)
                            <?php $i++; ?>
                            <tr>
                                <td>{{$i}}.</td>
                                <td>{{$l->text}}</td>
                                <td>{{$l->href}}</td>
                                <td>
                                    @if($l->in_header)
                                        {{"Yes."}}
                                    @else
                                        {{"No."}}
                                    @endif
                                </td>
                                <td>
                                    @if($l->in_footer)
                                        {{"Yes."}}
                                    @else
                                        {{"No."}}
                                    @endif
                                </td>
                                <td>
                                    @if($l->admin_link)
                                        {{"Yes."}}
                                    @else
                                        {{"No."}}
                                    @endif
                                </td>
                                <td>
                                    <div><span class="fa fa-edit" data-id="{{$l->menu_id}}"></span></div>
                                    <div><a href="{{url('deleteLink/'.$l->menu_id)}}"><span class="fa fa-remove"></span></a></div>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
        <div id="activity">
            <h2>Activity</h2>
            <div class="decorationalDiv">
                <span></span>
            </div>
            <div id="activityListHolder">
                <select id="activityList" name="activityList" class="inputAdminClass">
                    <option value="DESC">Newest</option>
                    <option value="ASC">Oldest</option>
                </select>
            </div>
            <div id="userActivity">
                <div id="userActivityAbs">
                    <table id="activityTable">
                        <tr><th>Activity</th><th>Date</th></tr>
                                            @foreach($activities as $a)
                                                <tr>
                                                    <td>{{ $a->text }}</td>
                                                    <td>{{ $a->activity_time }}</td>
                                                </tr>
                                            @endforeach
                    </table>
                </div>

            </div>
        </div>
    </div>
    <div id="top">
        <a href="#" target="_top"> <span class="fa fa-arrow-up"></span></a>
    </div>
    @endsection
