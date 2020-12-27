@extends("template")
@section("title")
Contact Admin
@endsection
@section("mainContent")
<div id="centeredContactAdmin">
    <h2>Contact Admin</h2>
    <div class="decorationalDiv">
        <span></span>
    </div>
    <div id="contact">
        <div id="contactAdminDiv">
            <div id="adm">
                Please feel free to contact our sweet admin if you have any trouble or have suggestions for better
                perfomance of our website! :)
                <div id="deadpool"><img src="{{ asset('images/superhero.svg') }}" alt="hero" class="cute" width="70" height="70"/></div>
                <img src="{{ asset('images/purplehero.svg') }}" alt="hero" class="cute" id="purplehero" width="70" height="70"/>
                <div class="cleaner"></div>
            </div>
            <form id="contactAdmin" action="{{url('/contact-admin')}}" method="post">
                @csrf
                <input type="text" id="emailAddress" name="emailAddress" placeholder="Your email address.." value="@if(session()->has('user')){{session('user')->email}}@endif" />
                <p class="error" id="emailAddressErr"></p>
                <textarea id="body" name="body" placeholder="Body.."></textarea>
                <p class="error" id="bodyErr"></p>
                @if(session()->has("success"))
                    <p class="success">{{session("success")}}</p>
                @endif
                @if(session()->has("error"))
                    <p class="error">{{session("error")}}</p>
                @endif
                <div id="sendAdminDiv">
                    <input type="submit" value="Send" id="sendAdmin"/>
                </div>
                <img src="{{ asset('images/girlhero.svg') }}" alt="hero" class="cute" width="70" height="70"/>
                <p class="success"></p>
                <p class="error"></p>
                <img src="{{ asset('images/spearehero.svg') }}" alt="hero" id="spearehero" class="cute" width="70" height="70"/>
                <div class="cleaner"></div>
            </form>
        </div>
    </div>
</div>
@endsection
