@extends("template")
@section("title")
    Home
@endsection
@section("mainContent")
    <div id="slider">
        <img src="{{ asset('images/tenet3.jpg') }}" alt="slider" id="sliderPicture" height="600"/>
        <div id="sliderInfoContainer">
            <div id="sliderInfoWrapper">
                <a href="#" class="arrowsSlider" id="leftArrow"><span class="fa fa-angle-left"></span></a>
                <div id="sliderInfo">
                    <div id="sliderActors">
                    </div>
                    <div id="centerSliderInfo">
                    </div>
                    <div id="sliderGrades">
                    </div>
                </div>
                <a href="#" class="arrowsSlider" id="rightArrow"><span class="fa fa-angle-right"></span></a>
        </div>
        <ul id="sliderCircles">
        </ul>
        </div>
    </div>
    <div id="movies">
        <div id="headlineSearchCont">
            <div id="headlineDecorationalMovies">
                <h2>What's on</h2>
                <div class="decorationalDiv">
                    <span></span>
                </div>
            </div>
            <div id="searchCont">
                <input type="text" name="search" id="extendSearch" class="extend" placeholder="Search for movies..">
                <span class="fa fa-search searchicon" aria-hidden="true"></span>
                <span class="fa fa-close notVisible" aria-hidden="true"></span>
            </div>
            <div class="cleaner"></div>
        </div>
        <div id="filterSortMovies">
            <?php date_default_timezone_set('Europe/Belgrade');?>
            <?php
//            echo date("Y-m-d H:i:s");
//            $todayDate = date("d.m.Y.");
            $todayDate = date("d.m.Y.", strtotime("2020-12-26"));
            $user = 0;
            if(session()->has("user")){
                $user = 1;
            }
            ?>
            <input type="hidden" value="<?=$user ?>" id="hiddenUserExists"/>
{{--                needed when filtering movies and printing them and projections  in js--}}
                <select id="dateFilter" class="ddlFilter">
                    <option value="<?=  $todayDate ?>">Today, <?=  date("D d.m.Y.", strtotime( $todayDate)); ?></option>
                    <option value="<?= date("Y-m-d", strtotime( $todayDate . "1 day" )); ?>">Tomorrow, <?= date("D d.m.Y.", strtotime( $todayDate . "1 day" )); ?></option>
                    <?php for($i = 2;$i <= 6;$i++){ ?>
                    <option value="<?= date("Y-m-d", strtotime( $todayDate . $i . " day" )); ?>"><?= date("D d.m.Y.", strtotime( $todayDate . $i . " day" )); ?></option>
                    <?php } ?>
                </select>
                <select id="technologyFilter" class="ddlFilter ddlChangingOptionsColor ddlDefaultOption">
                    <option value="0" class="greyOption">Technology..</option>
                    @foreach($technologies as $t)
                        <option value="{{ $t->id }}" class="alwaysWhiteOptions">{{ $t->name }}</option>
                    @endforeach
                </select>
                <select id="genreFilter" class="ddlFilter ddlChangingOptionsColor ddlDefaultOption">
                    <option value="0" class="greyOption">Genre..</option>
                    @foreach($genres as $g)
                        <option value="{{ $g->id }}" class="alwaysWhiteOptions">{{ $g->genre }}</option>
                        @endforeach
                </select>
                <div id="sortContainer">
                    <span class="fa fa- fa-sort-alpha-asc"></span>Sort by:
                    <label class="container containerMoviesRadio">
                        <input type="radio" checked="checked" name="sortMovies" value="ASC" id="ascOrder"/>Ascending order
                        <span class="checkmark checkmarkMovies"></span>
                    </label>
                    <label class="container containerMoviesRadio">
                        <input type="radio" name="sortMovies" value="DESC" id="descOrder">Descending order
                        <span class="checkmark checkmarkMovies"></span>
                    </label>
                </div>
        </div>
        <div id="deleteFiltersDiv">
            <div id="deleteFilters"></div>
            <p>Delete filters.</p>
        </div>
        <div id="moviesContainer">
            <p id="ticketsMeaning">
                <span><span class="fa fa-ticket" id="greenTicket"></span> Reservation available</span>
                <span><span class="fa fa-ticket" id="redTicket"></span> Reservation not available</span>
            </p>
            @foreach($movies as $m)
                @component("partials.movie",["movie" => $m])
                    @endcomponent
                @endforeach
        </div>
        <div id="paginationDiv">
            <ul id="pagination">
                <?php
                for($i = 0; $i < $pagination; $i++):
                ?>
                <li>
                    <a href="#" class="paginationLinks <?php if($i == 0){ echo "activePagination";}?>" data-limit="<?= $i ?>"><?= $i+1 ?></a>
                </li>
                <?php endfor;  ?>
            </ul>
        </div>
    </div>
{{--    <form id="pokusaj" name="pokusaj" action="{{url('pokusaj')}}" method="post" enctype="multipart/form-data">--}}
{{--        @csrf--}}
{{--        <input type="file" name="pokusaj"/>--}}
{{--        <input type="submit" value="Posalji"/>--}}
{{--    </form>--}}
    <img src="https://res.cloudinary.com/dls0cb0e2/image/upload/v1610063581/dxycs5jjypxw3faeb0ea.jpg"/>
    <?php
//    $smallerFileName = 'edited_' . "mica.jpg";
//    $path = $folder . $finalFileName;
//    $smallerFilePath = "images/edited/" . $smallerFileName;
//    $file = fopen ("images/tenet5.jpg", "rb");
//    if ($file) {
//        //SLIKA je vec uploadovana na server tako da je ovo nepotrebno
//        //echo "Slika je upload-ovana na server!";
//        $newf = fopen ($smallerFilePath, "a"); // to overwrite existing file
//
//        if ($newf){
////            dd("mica");
//            while(!feof($file)) {
//                fwrite($newf, fread($file, 1024 * 8 ), 1024 * 8 );
//
//            }
//        }
//        if ($file) {
//            fclose($file);
//        }
//
//        if ($newf) {
//            fclose($newf);
//        }
//        }
    ?>
    @endsection
