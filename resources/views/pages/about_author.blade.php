@extends("template")
@section("title")
    About Author
@endsection
@section("mainContent")
    <div id="centeredAboutAuthor">
        <h2>About Author</h2>
        <div class="decorationalDiv">
            <span></span>
        </div>
        <div id="author">
            <div id="picAuthor">
                <img src="{{asset('images/me.png')}}" alt="author"/>
            </div>
            <div id="authorAbout">
                <?= $author ?>
            </div>

        </div>
    </div>
@endsection
