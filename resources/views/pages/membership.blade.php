@extends("template")
@section("title")
    Membership
@endsection
@section("mainContent")
    <div id="centeredMembershipBg">
        <div id="centeredMembership">
            <h2>Membership</h2>
            <div class="decorationalDiv">
                <span></span>
            </div>
            <p class="membershipNotice" id="membershipNotice1">* Become our member and get our <span>bonus card</span>. After submitting ur request, bonus card can be lifted at our box offices. </p>
                <div id="membformDiv">
                    @if(session()->has('successSentEmailMembership'))
                        <p class="success" class="noticeSuccErrMembership">{{session('successSentEmailMembership')}}</p>
                    @endif
                    @if(session()->has('errorSentEmailMembership'))
                        <p class="error" class="noticeSuccErrMembership">{{session('errorSentEmailMembership')}}</p>
                    @endif
                    @if(session()->has('successSentEmailMembership'))
                        <?php
                        $userInfo = null;
                        if(session()->has('userMembershipInfo')){
                            $userInfo = session('userMembershipInfo');
                        }
                        ?>
                        <form action="{{url('/becomeMemberRequest')}}" id="membershipRequestForm" method="post">
                            @csrf
                            <div>
                                <input type="text" id="memReqName" name="memReqName" placeholder="Firstname.." value="{{$userInfo?$userInfo['firstname']:''}}"/>
                                <p class="errror" id="memReqNameErr"></p>
                            </div>
                            <div>
                                <input type="text" id="memReqLastname" name="memReqLastname" placeholder="Lastname.." value="{{$userInfo?$userInfo['lastname']:''}}"/>
                                <p class="errror" id="memReqLastnameErr"></p>
                            </div>
                            <div>
                                <input disabled type="text" id="memReqEmail" name="memReqEmail" placeholder="Email address.." value="{{$userInfo?$userInfo['email']:''}}"/>
                                <p class="errror" id="memReqEmailErr"></p>
                            </div>
                            <div>
                                <input type="text" id="memReqCode" name="memReqCode" placeholder="Received verification code.."/>
                                <p class="errror" id="memReqCodeErr"></p>
                            </div>
                            <input type="hidden" id="memReqUserId" name="memReqUserId" value="{{$userInfo?$userInfo['userId']:''}}"/>
                            <div><input type="submit" id="sumbitReqMembership" name="sumbitMembership" value="Confirm"/></div>
                        </form>

                        @else

                        <form action="{{url('/becomeMember')}}" id="membershipForm" method="post">
                            @csrf
                            <?php
                            $user = null;
                            if(session()->has('user')){
                                $user = session('user');
                            }
                            ?>
                            <div><input type="text" id="memName" name="memName" placeholder="Firstname.."/></div>
                            <div><input type="text" id="memLastname" name="memLastname" placeholder="Lastname.."/></div>
                            <div><input type="text" id="memEmail" name="memEmail" placeholder="Email address.." value="{{ $user ? $user->email : '' }}"/></div>
                            <input type="hidden" id="membershipHidden" name="membershipHidden" value="{{ $user ? $user->id : '' }}"/>
                            <div><input type="submit" id="sumbitMembership" name="sumbitMembership" value="Confirm"/></div>
                            @isset($errors)
                                <p class="error">
                                    @foreach($errors->all() as $error)
                                        {{ $error }}<br/>
                                    @endforeach
                                </p>
                            @endisset
                            @if(session()->has('error'))
                                <p class="error">
                                    {{ session('error') }}
                                </p>
                            @endif
                            @if(session()->has('success'))
                                <p class="success">
                                    {{ session('success') }}
                                </p>
                            @endif
                        </form>
                        @endif
                </div>
            <p class="membershipNotice" id="membershipNotice2">For movie fans and foodies who love paying less. <span class="fa fa-heart-o"></span></p>
        </div>
    </div>
    @endsection
