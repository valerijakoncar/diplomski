@extends("template")
@section("title")
    Contact Us
@endsection
@section("mainContent")
    <div id="centeredContactCinema">
        <div id="curtain">

        </div>
        <div id="contactCinemaHolderOpacity">
            <h2>Contact Us</h2>
            <div class="decorationalDiv">
                <span></span>
            </div>
            <div id="contCinNoticeDiv">
                <p id="contCinNotice">* If you have a question feel free to send us an email or give as a call :</p>
{{--                <img src="{{ asset('images/repply.svg') }}" alt="repply" id="repply" width="30" height="30"/>--}}
                <div class="phoneHolder"><img src="{{ asset('images/mobile-phone.svg') }}" alt="phone" id="" width="20" height="30"/><p>+381 62 626 22 22</p></div>
                <div class="phoneHolder"><img src="{{ asset('images/telephone.svg') }}" alt="phone" id="" width="20" height="30"/><p>+011 2333 333</p></div>
            </div>
            <div id="contactCinemaHolder">
                <p id="contCinSendMail">Send us a message</p>
                <form id="contactCinema" action="{{url('/contact-cinema')}}" method="post">
                    @csrf
                    <div id="nameHolderContCinema">
                        <input type="text" id="firstnameContCin" name="firstnameContCin" placeholder="Firstname.."/>
                        <input type="text" id="lastnameContCin" name="lastnameContCin" placeholder="Lastname.."/>
                    </div>
                    <p class="error" id="firstnameContCinErr"></p>
                    <p class="error" id="lastnameContCinErr"></p>
                    <input type="text" id="emailAddressContCin" name="emailAddressContCin" placeholder="Your email address.." value="@if(session()->has('user')){{session('user')->email}}@endif" />
                    <p class="error" id="emailAddressContCinErr"></p>
                    <textarea id="question" name="question" placeholder="Describe ur issue or question.."></textarea>
                    <p class="error" id="questionErr"></p>
                    @if(session()->has("success"))
                        <p class="success">{{session("success")}}</p>
                        @endif
                    @if(session()->has("error"))
                        <p class="error">{{session("error")}}</p>
                    @endif
                    <div id="sendContCinDiv">
                        <input type="submit" value="Send" id="sendContCin"/>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
