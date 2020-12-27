@extends("template")
@section("title")
    Account Access
@endsection
@section("mainContent")
    <div id="centeredAccountAccessBg">
        <div id="centeredAccountAccess">
            <h2>Regain account access</h2>
            <div class="decorationalDiv">
                <span></span>
            </div>
            <div id="accountAccess">
                <div id="accountAccessFormDiv">
                    <form id="accountAccessForm" action="{{ url('/account-access') }}" method="POST">
                        @csrf
                        <p id="helloAccountAccess">Hello {{session("username")->username}}!</p>
                        <input type="text" id="accountAccessEmail" name="accountAccessEmail" placeholder="Your email address.." value="{{session()->has('email')?session('email'):''}}" disabled/>
                        <p class="error" id="accountAccessEmailErr"></p>
                        <input type="text" id="accountAccessCode" name="accountAccessCode" placeholder="Recieved code.."/>
                        <p class="error" id="accountAccessCodeErr"></p>
                        <input type="password" id="accountAccessPass" name="accountAccessPass" placeholder="New password.."/>
                        <p class="error" id="accountAccessPassErr"></p>
                        <p class="error">
                            @if(session()->has('error'))
                                {{session('error')}}
                            @endif
                        </p>
                        <p class="success">
                            @isset($successfullyChangedPass)
                                {{$successfullyChangedPass}}
                                @endisset
                        </p>
                        <input type="submit" id="accountAccessSubmit" name="accountAccessSubmit" value="Confirm"/>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
