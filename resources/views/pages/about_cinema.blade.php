@extends("template")
@section("title")
    About Cinema
@endsection
@section("mainContent")
    <div id="aboutCinemaSlider">

    </div>
    <div id="centeredAboutCinema">
        <h2>About Our Cinema</h2>
        <div class="decorationalDiv">
            <span></span>
        </div>
        <div id="abtCinemaInfo">
                <?php echo $text; ?>
                <img src="{{asset('images/cinema1.jpg')}}" alt="cinema" class="abtCinemaPic"/>
                <img src="{{asset('images/cinema2.jpg')}}" alt="cinema" class="abtCinemaPic"/>
        </div>
    </div>
    @endsection
