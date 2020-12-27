@extends("template")
@section("title")
    Reservation
@endsection
@section("mainContent")
    <div id="resWrapper">
        <h2>Reservation</h2>
        <div class="decorationalDiv">
            <span></span>
        </div>
        <ul id="projectionInfo">
            <li><span>Movie:</span> {{$projectionInfo->movieName}} ({{$projectionInfo->technName}})</li>
            <li><span>Hall:</span> {{$projectionInfo->hallName}}</li>
            <li><span>Projection time:</span> <span><?=  date("D, d.m.Y. H:i", strtotime($projectionInfo->starts_at)); ?></span></li>
            <li><span>Seats:</span> <span><input type="number" id="inputSeatsNum" value="{{$seats}}" min="1" max="10"/></span></li>
{{--            <span>{{$seats}}</span>--}}
        </ul>
        <input type="hidden" value="{{$projectionInfo->idProjection}}" id="projectionId" name="projectionId"/>
        <input type="hidden" value="{{$pricePerTicket}}" id="pricePerTicket" name="pricePerTicket"/>
        <div id="hallSeatsHolder">
            <div id="hallSeats">
                @foreach($hallRows as $hr)
                    <div class="hallRow" data-id="{{$hr->id}}" data-row="{{$hr->row}}">
                        @foreach($hr->seats as $s)
                            @if($s->is_available)
                                <span data-seat="{{$s->seat_number}}" data-id="{{$s->id}}" class="seat available_seat
                                <?php
                                    if($s->hallway_left){
                                        echo (" " . "hallwayLeft");
                                    }
                                    if($s->hallway_right){
                                        echo (" " . "hallwayRight");
                                    }
                                ?>
                                "></span>
                            @else
                                <span data-seat="{{$s->seat_number}}" data-id="{{$s->id}}" class="seat not_available_seat
                                 <?php
                                if($s->hallway_left){
                                    echo (" " . "hallwayLeft");
                                }
                                if($s->hallway_right){
                                    echo (" " . "hallwayRight");
                                }
                                ?>
                                "></span>
                            @endif
                        @endforeach
                    </div>
                @endforeach
                <p id="screenP">Screen</p>
                <div id="screen"></div>
            </div>
            <div id="seatsChosen">
                <p id="chosenSeatsP">Chosen seats: </p>
                <p id="selectMoreSeats">Select <span>{{$seats}}</span> more..</p>
                <ul id="seatsChosenList">

                </ul>
                <p id="resSum">Sum: <span>{{number_format($price, 2, ",", " ")}} $</span></p>
                <input type="button" value="Confirm" id="confirmReservation"/>
            </div>
        </div>
    </div>
    @endsection
