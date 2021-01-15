<body>
    <div id="blurBackground">
        <div id="closeRegFormHolder">
            <div id="closeRegForm"></div>
        </div>
        <div id="registrationHolder">
            <div id="regHeadline">
                <div id="regHeadlineOpacity">
                    <div id="popcornRegForm" class="popcorn"></div>
                    <p id="regP">Registration</p>
                </div>
            </div>
            <form id="registrationForm" action="#" method="POST">
                @csrf
                <table>
                    <tr><td colspan="2"><input type="text" id="regName" name="regName" placeholder="Username *"/><p class="error" id="nameError"></p></td></tr>
                    <tr><td colspan="2"><input type="password" id="regPass" name="regPass" placeholder="Password *"/><p class="error" id="passError"></p></td></tr>
                    <tr><td colspan="2"><input type="password" id="regPass1" name="regPass1" placeholder="Type in password again *"/><p class="error" id="regPass1Error"></p></td></tr>
                    <tr><td><input type="text" id="email" name="email" placeholder="E-mail *"/><p class="error" id="mailError"></p></td>
                        <td class="marginTd"><input type="text" id="tel" name="tel" placeholder="Phone (recommended)"/><p class="error" id="telError"></p></td></tr>
                    <tr>
                        <td>Gender: *<p class="error" id="genderError"></p></td>
                        <td>
{{--                            <input type="radio" id="female" name="gender" value="f"/>Female<input type="radio" id="male" name="gender"value="m"/>Male--}}
                            <label class="container" id="firstContainer">Female
                                <input type="radio" checked="checked" name="gender" value="1" id="female"/>
                                <span class="checkmark"></span>
                            </label>
                            <label class="container">Male
                                <input type="radio" name="gender" value="2" id="male">
                                <span class="checkmark"></span>
                            </label>
                        </td>
                    </tr>
                    <tr><td colspan="2">
{{--                            <input type="checkbox" id="chbMail" checked="checked "value="send" name="chbMail"/>Send news to email--}}
                            <label class="containerChb">Send news to email
                                <input type="checkbox" id="chbMail" checked="checked "value="send" name="chbMail"/>
                                <span class="checkmarkChb"></span>
                            </label>
                        </td></tr>
                    <tr><td colspan="2"><input type="button" id="btnRegistration" value="Registrate"/></td></tr>
                    <tr><td><p class="success"></p></td></tr>
                </table>
            </form>
        </div>

    </div>

<div id="blurBackgroundPrices">
    <div id="closePricesHolder">
        <div id="closePrices"></div>
    </div>
    <div id="pricesHolder">
        <div id="pricesHeadline">
            <div id="pricesHeadlineOpacity">
                <div id="popcornPrices" class="popcorn"></div>
                <p id="pricesP">Our prices</p>
            </div>
        </div>
        <table id="pricesTable">
            <tr>
                <th>Weekday (Technology)</th>
                <th>Price</th>
            </tr>
            @foreach($prices as $p)
                <tr>
                    <td>{{$p->text}}</td>
                    <td>{{$p->price}} $</td>
                </tr>
            @endforeach
        </table>
    </div>

</div>

    <div id="blurBackgroundReservation">
        <div id="closeResFormHolder">
            <div id="closeResForm"></div>
        </div>
        <div id="reservationHolder">
            <div id="resHeadline">
                <div id="resHeadlineOpacity">
                    <div id="popcornResForm" class="popcorn"></div>
                    <p id="resP">Reservation</p>
                </div>
            </div>
            <p id="alertRes"><span class="fa fa-exclamation-triangle"></span>Please wear musks during ur visit. Safety first!</p>
            @if(session()->has('user'))
                <form id="reservationForm" action="{{ url('/continueReservation') }}" method="GET">
{{--                    @csrf--}}
                    <?php date_default_timezone_set('Europe/Belgrade');?>
                    <?php
                    $todayDate = date("d.m.Y.", strtotime("2020-12-26"));
                    ?>
                    <p id="chooseInfoRes">Please choose your info :</p>
                    <div id="resDdlHolder">
                        <div class="custom-select" id="reservationDateDdlDiv">
                            <select id="reservationDateDdl" name="reservationDateDdl">
                                <option value="<?=date('Y-m-d',strtotime($todayDate));?>">Today, <?=  date("D d.m.Y.", strtotime( $todayDate)); ?></option>
                                <option value="<?= date("Y-m-d", strtotime( $todayDate . "1 day" )); ?>">Tomorrow, <?= date("D d.m.Y.", strtotime( $todayDate . "1 day" )); ?></option>
                                <?php for($i = 2;$i <= 6;$i++){ ?>
                                <option value="<?= date("Y-m-d", strtotime( $todayDate . $i . " day" )); ?>"><?= date("D d.m.Y.", strtotime( $todayDate . $i . " day" )); ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="custom-select" id="reservationMovieDdlDiv">
                            <select id="reservationMovieDdl" name="reservationMovieDdl">
                                <option value="0">Choose movie..</option>
                                @foreach($moviesResDdl as $m)
                                    <option value="{{$m->id}}">{{$m->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="custom-select" id="reservationProjectionDdlDiv">
                            <select id="reservationProjectionDdl" name="reservationProjectionDdl">
                                <option value="0">Choose projection..</option>
                            </select>
                        </div>
                    </div>
                    <div id="chooseNumSeats">Number of seats : <input type="number" id="numSeats" name="numSeats" min="1" max="10" value="1"></div>
                    <div id="continueReservationDiv">
                        {{--                    <a href="#" id="continueReservation"><span class="fa fa-hand-o-right"></span>Proceed with reservation</a>--}}
                        <span class="fa fa-hand-o-right"></span><input type="submit" id="continueReservation" value="Next"/>
                    </div>
                </form>
                @else
                <p class="notLoggedIn">You are not logged in.</p>
                @endif
        </div>

    </div>


    <div id="blurBackgroundForgetPass">
        <div id="closeForgetPassFormHolder">
            <div id="closeForgetPassForm"></div>
        </div>
        <div id="forgetPassHolder">
            <div id="forgetPassHeadline">
                <div id="forgetPassHeadlineOpacity">
                    <div id="popcornForgetPassForm" class="popcorn"></div>
                    <p id="forgetPassP">Forgotten password</p>
                </div>
            </div>
            <p id="alertForgetPass"><span class="fa fa-exclamation-triangle"></span>Confirmation email will be sent to given email address.</p>
                <form id="forgetPassForm" action="{{ url('/forget-password') }}" method="POST">
                    @csrf
                    <input type="text" id="forgetPassEmail" name="forgetPassEmail" placeholder="Your email address.."/>
                    <p class="error"></p>
                    <p class="success"></p>
                    <input type="submit" id="forgetPassSubmit" name="forgetPassSubmit" value="Send"/>
                </form>
        </div>

    </div>


    <div id="headerWrapper">
        <div id="header">
            <div id="topHeader">
                <div id="logReg">
                    <ul id="logRegList">
                        <?php if(session()->has('user')){ ?>
                        <li><a><?= session('user')->username?></a></li>
{{--                            <span class="fa fa-heart-o"></span>--}}
{{--                            <li id="help"><a href="">Need help?</a></li>--}}
                            <li><a href="{{ url('/logout') }}" id="logout">Logout</a></li>
                            <li id="help"><span id="ourPrices"></span><a href="#" id="help">Our prices</a></li>
                         <?php }else{ ?>
                            <li><a href="#" id="logLink"><span class="fa fa-sign-in"></span>Log In</a></li>
                            <li><a href="#" id="regLink"><span class="fa fa-user"></span>Sign Up</a></li>
{{--                            <li id="help"><a href="">Need help?</a></li>--}}
                            <li><span id="ourPrices"></span><a href="#" id="help">Our prices</a></li>
                         <?php } ?>
                    </ul>

                   <div id="logFormDiv">
                       <div id="closeLogForm">
                           <div id="logFormX"></div>
                       </div>
                       <form method="POST" action="{{ url('/login') }}" id="logForm">
                           @csrf
                           <input type="text" name="logUsername" id="logUsername" placeholder="Username.."/><p class="error" id="logUsernameError"></p>
                           <input type="password" name="logPass" id="logPass" placeholder="Password.."/><p class="error" id="logPassError"></p>
                           <input type="submit" name="logIn" id="logIn" value="Log in" />
                           <a href="#" id="resetPass">Forgot password?</a>

                           <p class="error" id="logError">
                               @isset($errors)
                                   @foreach($errors->all() as $error)
                                       {{ $error }}<br/>
                                   @endforeach
                               @endisset
                               @if(session()->has('message'))
                                   {{ session('message') }}
                               @endif

                           </p>
                       </form>
                   </div>
                </div>
                <a href="{{url('home')}}">
                    <div id="logoMessg">
                           <div id="logoHeader" class="logo">
                               <div id="popcornHeader" class="popcorn"></div>
                               <h1>MovieBlackout</h1>
                           </div>
                           <div id="messageContainer">
                               <p class="message">Be kind. Be well. </p>
                               <p class="message">Stay safe.</p>
                           </div>
                    </div>
                </a>
                <div class="cleaner"></div>
            </div>
        </div>
            <div id="menu">
                    <div id="menuBtnDiv">
                        <button id="menuBtn">
                            <i class="fa fa-list"></i>Menu
                        </button>
                    </div>
                    <ul id="menuList">
                        @foreach($menuLinks as $link)
                            @if($link->in_header && $link->parent_id == NULL)
                                    <li>
                                        <a href="{{ url(''.$link->href) }}">
                                            {{ $link->text }}
                                            @if(count( $link->childrenLinks))
                                                <span class="fa fa-angle-down"></span>
                                                @endif
                                        </a>
                                        @component("partials.menu_children",[
                                                                'children' => $link->childrenLinks,
                                                                'menuLinks' => $menuLinks
                                                                    ])
                                            @endcomponent
                                    </li>
                            @endif
                            @endforeach
                        @if(session()->has("user"))
                            @if(session("user")->role_id == 2)
                                    <li><a href="{{ url('/admin') }}">Admin</a></li>
                            @endif
                        @endif
                    </ul>
            </div>
{{--            <ul id="hireList">--}}
{{--                <li><span id="ourPrices"></span><a href="#">Our prices</a></li>--}}
{{--                <li><span id="hireUs"></span><a href="#">Hire us</a></li>--}}
{{--            </ul>--}}
        </div>



