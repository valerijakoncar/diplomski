    <div id="footerContainer">
        <div class="decorationalFooterDiv">
            <span></span>
            <div class="decorationalFooterChild"></div>
            <span></span>
        </div>
        <div id="footer">
            <div id="footerInfoCont">
                <div id="logoSocialsDiv">
                    <div id="footerLogo" class="logo">
                        <div id="popcornFooter" class="popcorn"></div>
                        <h3>MovieBlackout</h3>
                    </div>
                    <div id="followSocials">
                        <p id="followUs">Follow us on social media<span class="fa fa-heart-o"></span></p>
                        <ul id="footerSocials">
                            @foreach($socials as $social)
                                <li><a href="{{$social->href}}"><span class="{{$social->icon_class}}"></span></a></li>
                                @endforeach
                        </ul>
                    </div>
                </div>
                <div id="footerInfos">
                    @foreach($footerHeadlines as $fh)
                        @component('partials.footer_section',[
                                            'footerHeadline' => $fh,
                                            'footerSectionMenu' => $menuLinks
                                        ])
                            @endcomponent
                        @endforeach
                    <div class="cleaner"></div>
                </div>
                </div>
            <p id="copyright">Copyright ©&nbsp;&nbsp;MovieBlackout&nbsp;&nbsp;<?php echo date("Y");?></p>
        </div>
        <div class="decorationalFooterDiv">
            <span></span>
            <div class="decorationalFooterChild" id="decorationalFooterChildBottom"></div>
            <span></span>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script type="text/javascript">
        var urlPics = '{{ URL::asset('/images/edited') }}';
    </script>
    <script type="text/javascript" src="{{asset('js/main.js')}}"></script>
</body>
