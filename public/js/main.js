window.onload = function(){
    var url = window.location.href;
    if(url.indexOf("home") !== -1){

        console.log("dfg");

    }else if(url.indexOf("admin") !== -1){

        $("#top").click(function(){
            $("html,body").animate({ scrollTop: 0 }, 1000);
        });
        $(window).scroll(function(){
            if($(this).scrollTop()>170){
              $("#top").fadeIn();
            }else{
                $("#top").fadeOut();
            }
        });
        $("#menuAdmin a").on('click', function(e) {
            e.preventDefault();
            $('#menuAdmin li').removeClass('active');
            $(this).parent().addClass('active');
            var target = $(this).attr('href');
            $('html, body').animate({
                scrollTop: ($(target).offset().top)
            }, 2000);
        });
        $("#activityList").change(sortActivity);
        $("#insLink").click(checkInsert);
        $("#closeInsertLinkForm").click(function(){
            $('#blurBgInsertLink').fadeOut();
            $(document).unbind('scroll');
            $('body').css({'overflow':'visible'});
        });
        $("#linksAdmin #insertLink").click(function(){
            $('#blurBgInsertLink').fadeIn();
            $(document).bind('scroll');
            $('body').css({'overflow':'hidden'});
        });
        $("#closeUpdateLinkForm").click(function(){
            $('#blurBgUpdateLink').fadeOut();
            $(document).unbind('scroll');
            $('body').css({'overflow':'visible'});
        });
        $("#updLink").click(updateLink);
        $("#linksTable .fa-edit").click(editLinkClick);
        $("#commentsHolderAdmin .fa-remove").click(deleteAdminComment);
        $("#updUser").click(checkUpdateUser);
        $("#blurBgUpdateUser #closeUpdateUserForm").click(function(){
            $('#blurBgUpdateUser').fadeOut();
            $(document).unbind('scroll');
            $('body').css({'overflow':'visible'});
        });
        $("#tableUsers .fa-edit").click(getUser);
        $("#updateProjForm").submit(checkProjectionUpd);
        $("#searchProjections").keyup(searchProjectionsByMovie);
        $("#closeUpdateProjForm").click(function(){
            $('#blurUpdateProj').fadeOut();
            $(document).unbind('scroll');
            $('body').css({'overflow':'visible'});
        });
        $(".prInfo .fa-edit").click(editProjClick);
        $("#seeProjections").click(function(e){
            e.preventDefault();
            $("#viewProjections").toggle();
            if($("#viewProjections").is(":visible")){
                $(this).html("View less <span class='fa fa-hand-o-up'></span>");
            }else{
                $(this).html("View more <span class='fa fa-hand-o-down'></span>");
            }
        });
        $("body").on("change",".projectionMovie", function(){
            getMovieTechnologies($(this));
        });
        $("#projectionsForm").submit(checkProjectionsInsert);
        $("body").on("click", ".adminProjection .projectionX .fa-close",function(){
            $(this).parent().parent().remove();
            let num = $("#numOfProjections").val();
            $("#numOfProjections").val(num - 1);
        });
        $("#numOfProjections").change(printMoreProjections);
        // $("#btnDeleteMov").click(deleteMovie);
        $("#genresMovIns").change(addMovieGenreInsert);
        $("#actorsMovIns").change(addMovieActorInsert);
        $("#insertMovieForm").submit(checkMovieInsert);
        $("#closeInsertMovieForm").click(function(){
            $('#blurBgInsertMovie').fadeOut();
            $(document).unbind('scroll');
            $('body').css({'overflow':'visible'});
        })
       $("#insertMovie").click(function(){
           $('#blurBgInsertMovie').fadeIn();
           $('body').css({'overflow':'hidden'});
           $(document).bind('scroll',function () {
               window.scrollTo(0,0);
           });
       });
        $("#updateMovieForm").submit(checkMovieUpdate);
        $("body").on("click", ".movUpdActGenres .fa-close",function(){
            $(this).parent().remove();
        });
        $("#genresMovUpd").change(addMovieGenre);
        $("#actorsMovUpd").change(addMovieActor);
        $(".btnUpdateMov").click(getMovieData);
        $("#closeUpdateMovieForm").click(function(){
            $('#blurBgUpdateMovie').fadeOut();
            $(document).unbind('scroll');
            $('body').css({'overflow':'visible'});
        });
        $("body").on("click", ".paginationAdmMov",function(e){
            e.preventDefault();

            let offset = $(this).data("limit");
            let searched = $("#extendSearchAdm").val().trim();
            if(searched == ""){
                searched = 0;
            }
            $('.paginationAdmMov').removeClass('activePagination');
            $(this).addClass('activePagination');

            $.ajax({
                url:  "admin/moviesPage/" + offset + "/" + searched , // "api/home/" + offset
                method: "GET",
                dataType: 'json',
                success: function(data){
                    printMoviesAdmin(data.movies);
                    $("html, body").animate({ scrollTop: $('#adminMovies').position().top }, 1000);
                },
                error: function(error){
                    console.log(error);
                }
            });
        });
        $("#extendSearchAdm").focus();
        $("#extendSearchAdm").keyup(function(event){
            let searched = $("#extendSearchAdm").val().trim();
            searchMoviesAdm(searched);
        });

    }
    $("#membershipRequestForm").submit(becomeMemberRequest);
    $("#contactAdmin").submit(contactAdmin);
    $("#contactCinema").submit(contactCinema);
    $("#accountAccessForm").submit(checkAccountAccessForm);
    $("#forgetPassForm").submit(checkForgetPassEmail);
    $("#resetPass").click(resetPassClicked);
    $(".voteDiv .confirmVote").click(sendVote);
    $("body").on("click", ".giveVoteList .fa", function(){
        rateStarClicked($(this));
    });
    $(".faCloseRateCloud").click(closeRateDiv)
    $(".vote").click(showVoteDiv);
    // $("#abtMovieBook").click(scrollToMovieProj);
    $("#inputSeatsNum").change(changeSeatsNum);
    $("#confirmReservation").click(makeReservation);
    $("body").on("click", "#seatsChosenList .fa-close", function(){
        $(this).parent().remove();
        let moreSeats = $("#selectMoreSeats span").text();
        let numMoreSeats = parseInt(moreSeats);
        numMoreSeats++;
        $("#selectMoreSeats span").text(numMoreSeats);
    });
    $(".available_seat").click(chooseSeat);

    $("#menuList a[href$='reservation']").click(showReservation);
    $("#help").click(viewPrices);

    $('#closeForgetPassForm').click(function(){
        $('#blurBackgroundForgetPass').fadeOut();
        $(document).unbind('scroll');
        $('body').css({'overflow':'visible'});
    });
    $("#closePrices").click(function(){
        $('#blurBackgroundPrices').fadeOut();
        $(document).unbind('scroll');
        $('body').css({'overflow':'visible'});
    });
    $("#closeResForm").click(function(){
        $('#blurBackgroundReservation').fadeOut();
        $(document).unbind('scroll');
        $('body').css({'overflow':'visible'});
    });

    makeDdl();
    /* If the user clicks anywhere outside the select box,
    then close all select boxes: */
    document.addEventListener("click", closeAllSelect);

    $("#viewMoreCom").click(viewMoreComments);
    $("body").on("click", "#comments .fa-close", function(e){
       let currentTextInTa = $(this).parent().find('.updateCommArea').val();
        $(this).parent().find('.fa-edit').css("display","initial");
        let html = `<div class="commText">${currentTextInTa}</div>`;
        $(this).parent().find('.commentTextDiv').html(html);
        $(this).remove();
    });
    $(".bottomPartComment .fa-edit").click(updateComment);
    // $(".bottomPartComment .fa-trash").live("click",function(){
    //     $(".bottomPartComment .fa-trash").die("click");
    //     deleteComment();
    // });
    $(".bottomPartComment .fa-trash").click(deleteComment);
    $(".bottomPartComment .fa-angle-down").click(showRepplies);
    $(".bottomPartComment .fa-angle-up").click(hideRepplies);
    $(".comment .bottomPartComment .repply").click(repplyToComment);
    $("#myComment").keyup(function(event){
        if (event.keyCode === 13) {
            event.preventDefault();
            $("#leaveComm .fa-pencil").click();
        }
    });
    $("#leaveComm .fa-pencil").click(postComment);
    $('#logFormDiv').hide();
    $('#blurBackground').hide();
    $('#deleteFiltersDiv').hide();
    $("body").on("click", "#deleteFiltersDiv", function(e){
        deleteFilters();
    });
    $('#logReg #logRegList #logLink').click(function(){
            $('#logFormDiv').slideToggle();
    });
    $("#logFormX").click(function(){
        $("#logFormDiv").fadeOut();
    });
    $('#logReg #logRegList #regLink').click(function(){
        $('#blurBackground').fadeIn();
        $('body').css({'overflow':'hidden'});
        $(document).bind('scroll',function () {
            window.scrollTo(0,0);
        });
        document.querySelector('#btnRegistration').addEventListener("click",checkingRegData);
    });
    $("#menuList li a").click(showSubmenu);
    $("#searchCont .fa-search").click(extendSearch);
    if($("#slider").length){
        movieSlider();
    }
    $("#movies #extendSearch").keyup(showX);
    $("#movies .fa-close").click(emptySearchInput);
    $(".arrowsSlider").click(changeSliderMovie);

    var rbMoviesSort = document.getElementsByName("sortMovies");
    for(let rb of rbMoviesSort){
        if(rb.checked){
            rbMoviesSortChecked = rb.value;
        }
    }

    $(".containerMoviesRadio").click(filterMovies);
    $(".ddlFilter").change(filterMovies);
    $(".searchicon").click(function(){
        let searched = $("#extendSearch").val();
        if(searched.trim() !== ""){
            filterMovies();
            $("#deleteFiltersDiv").fadeIn();
        }
    });
    $(".ddlChangingOptionsColor").change(function(){
        let ddlId = $(this).attr("id");
        var index = $(this).prop("selectedIndex");
        let valueSelected = document.getElementById(ddlId)[index].value;
        if(valueSelected != '0'){
            $(this).removeClass('ddlDefaultOption');
            this.children[0].setAttribute("class","greyOption");
        }else{
            $(this).addClass('ddlDefaultOption');
            $(this).children().addClass('alwaysWhiteOptionAdded');
            this.children[0].setAttribute("class","greyOption");
        }
    });
    $("#reservationForm").submit(continueReservation);
    $("#closeRegForm").click(function(){
        $('#blurBackground').fadeOut();
        $(document).unbind('scroll');
        $('body').css({'overflow':'visible'});
    });
    $("body").on("click", ".paginationLinks", function(e){
        e.preventDefault();

        let offset = $(this).data("limit");
        $('.paginationLinks').removeClass('activePagination');
        $(this).addClass('activePagination');

        $.ajax({
            url:  "page/" + offset , // "api/home/" + offset
            method: "GET",
            dataType: 'json',
            success: function(data){
                 printMovies(data.movies);
                $("html, body").animate({ scrollTop: $('#movies').position().top }, 1000);
            },
            error: function(error){
                console.log(error);
            }
        });

    });
}

function becomeMemberRequest(){
    let firstname = $("#memReqName").val();
    let lastname = $("#memReqLastname").val();
    let email = $("#memReqEmail").val();
    let code = $("#memReqCode").val();

    let reName = /^[A-Z][a-z]{3,10}(\s[A-Z][a-z]{3,10})*$/;
    let reEmail=/^\w+([\.-]?\w+)*\@\w+([\.-]?\w+)*(\.\w{2,4})+$/;

    if(email === ""){
        document.querySelector("#memReqEmailErr").innerHTML="Email field is required!";
        errors++;
    }else if(!reEmail.test(email)){
        document.querySelector("#memReqEmailErr").innerHTML="Email is not in valid format.";
        errors++;
    }else{
        document.querySelector("#memReqEmailErr").innerHTML="";
    }

    if(firstname === ""){
        document.querySelector("#memReqNameErr").innerHTML="Firstname field is required!";
        errors++;
    }else if(!reName.test(firstname)){
        document.querySelector("#memReqNameErr").innerHTML="Firstname is not in valid format.";
        errors++;
    }else{
        document.querySelector("#memReqNameErr").innerHTML="";
    }

    if(lastname === ""){
        document.querySelector("#memReqLastnameErr").innerHTML="Lastname field is required!";
        errors++;
    }else if(!reName.test(lastname)){
        document.querySelector("#memReqLastnameErr").innerHTML="Lastname is not in valid format.";
        errors++;
    }else{
        document.querySelector("#memReqLastnameErr").innerHTML="";
    }

    if(code === ""){
        document.querySelector("#memReqCode").innerHTML="Cody field is required!";
        errors++;
    }else{
        document.querySelector("#memReqCode").innerHTML="";
    }

    if(errors){
        return false;
    }else{
        return true;
    }
}

function contactAdmin(){
    let email = $("#emailAddress").val();
    let body = $("#body").val().trim();
    let reEmail=/^\w+([\.-]?\w+)*\@\w+([\.-]?\w+)*(\.\w{2,4})+$/;
    let errors = 0;

    if(email == ""){
        document.querySelector("#emailAddressErr").innerHTML="Email field is required!";
        errors++;
    }else if(!reEmail.test(email)){
        document.querySelector("#emailAddressErr").innerHTML="Email is not in valid format.";
        errors++;
    }else{
        document.querySelector("#emailAddressErr").innerHTML="";
    }

    if(body == ""){
        document.querySelector("#bodyErr").innerHTML="Body cant't be empty.";
        errors++;
    }else{
        document.querySelector("#bodyErr").innerHTML="";
    }

    if(errors){
        return false;
    }else{
        return true;
    }
}

function contactCinema(){
    let firstname = $("#firstnameContCin").val();
    let reName = /^[A-Z][a-z]{3,10}(\s[A-Z][a-z]{3,10})*$/;
    let lastname =  $("#lastnameContCin").val();
    let email = $("#emailAddressContCin").val();
    let reEmail=/^\w+([\.-]?\w+)*\@\w+([\.-]?\w+)*(\.\w{2,4})+$/;
    let body = $("#question").val();
    let errors = 0;

    if(email === ""){
        document.querySelector("#emailAddressContCinErr").innerHTML="Email field is required!";
        errors++;
    }else if(!reEmail.test(email)){
        document.querySelector("#emailAddressContCinErr").innerHTML="Email is not in valid format.";
        errors++;
    }else{
        document.querySelector("#emailAddressContCinErr").innerHTML="";
    }

    if(firstname === ""){
        document.querySelector("#firstnameContCinErr").innerHTML="Firstname field is required!";
        errors++;
    }else if(!reName.test(firstname)){
        document.querySelector("#firstnameContCinErr").innerHTML="Firstname is not in valid format.";
        errors++;
    }else{
        document.querySelector("#firstnameContCinErr").innerHTML="";
    }

    if(lastname === ""){
        document.querySelector("#lastnameContCinErr").innerHTML="Lastname field is required!";
        errors++;
    }else if(!reName.test(lastname)){
        document.querySelector("#lastnameContCinErr").innerHTML="Lastname is not in valid format.";
        errors++;
    }else{
        document.querySelector("#lastnameContCinErr").innerHTML="";
    }

    if(body === ""){
        document.querySelector("#questionErr").innerHTML="Body field is required!";
        errors++;
    }else{
        document.querySelector("#questionErr").innerHTML="";
    }

    if(errors){
        return false;
    }else{
        return true;
    }
}

function checkAccountAccessForm(){
    let email = $("#accountAccessEmail").val();
    let reEmail=/^\w+([\.-]?\w+)*\@\w+([\.-]?\w+)*(\.\w{2,4})+$/;
    let pass = $("#accountAccessPass").val();
    let rePass=/[\d\w\@$\^\*\-\.\_\!\+\=\)\(\{\}\?\/\<\>]{6,13}/;
    let code = $("#accountAccessCode").val();
    let errors = 0;

    if(email === ""){
        document.querySelector("#accountAccessEmailErr").innerHTML="Email field is required!";
        errors++;
    }else if(!reEmail.test(email)){
        document.querySelector("#accountAccessEmailErr").innerHTML="Email is not in valid format.";
        errors++;
    }else{
        document.querySelector("#accountAccessEmailErr").innerHTML="";
    }

    if(pass === ""){
        document.querySelector("#accountAccessPassErr").innerHTML="Password field is required!";
        errors++;
    }else if(!rePass.test(pass)){
        document.querySelector("#accountAccessPassErr").innerHTML="Password is not in valid format.";
        errors++;
    }else{
        document.querySelector("#accountAccessPassErr").innerHTML="";
    }

    if(code === ""){
        document.querySelector("#accountAccessCodeErr").innerHTML="Verification code field is required!.";
        errors++;
    }else{
        document.querySelector("#accountAccessCodeErr").innerHTML="";
    }

    if(errors){
        return false;
    }else{
        return true;
    }
}

function checkForgetPassEmail(){
    let email = $("#forgetPassEmail").val();
    let reEmail=/^\w+([\.-]?\w+)*\@\w+([\.-]?\w+)*(\.\w{2,4})+$/;

    if(email == ""){
       return false;
    }else if(!reEmail.test(email)){
        return false;
    }else{
        return true;
    }
}

function resetPassClicked(e){
    e.preventDefault();
    $('#blurBackgroundForgetPass').fadeIn();
    $('body').css({'overflow':'hidden'});
    $(document).bind('scroll',function () {
        window.scrollTo(0,0);
    });
}

function viewPrices(e){
    e.preventDefault();
    $('#blurBackgroundPrices').fadeIn();
    $('body').css({'overflow':'hidden'});
    $(document).bind('scroll',function () {
        window.scrollTo(0,0);
    });
}

function sendVote(){
    let idMovie = $(this).data("movid");
    let grade = $(this).parent().find(".userChosenGrade").text();
    let gradeNum =parseFloat(grade);
    let obj = $(this).prev();

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: global_url+"rateMovie",
        method: "post",
        data: {
            grade: gradeNum,
            idMovie: idMovie
        },
        success: function(data,status, xhr){
            let html = "<p class='success'>Thank u for ur vote.</p>";
            obj.next().unbind("click");

            switch(xhr.status) {
                case 204:
                    html = "<p class='success'>Ur vote was updated.</p>";
                    break;
            }
            $(html).insertAfter(obj);
        },
        errors: function(xhr, textStatus, errorThrown){
            switch(xhr.status) {
                // case 404:
                //     error = "Page not found.";
                //     break;
            }
        }
    })
}

function rateStarClicked(obj){
    let index = obj.data('index');

    let html = "";
    for(let i = 0; i < 10; i++){
        if(i <= index){
            html += `<li><span class="fa fa-star" data-index="${i}"></span></li>`;
        }else{
            html += `<li><span class="fa fa-star-o" data-index="${i}"></span></li>`;
        }
    }
    index++;
    let grade = index.toFixed(1);
    obj.parent().parent().parent().find(".userChosenGrade").html(grade);
    obj.parent().parent().html(html);
}

function closeRateDiv(){
    $(this).parent().hide();
}

function showVoteDiv(e){
    // console.log("ddd");
    e.preventDefault();
    let isVisible = $(this).parent().find(".giveVote").is(':visible');

    if(isVisible){
        $(this).parent().find(".giveVote").hide();
    }else{
        $(this).parent().find(".giveVote").fadeIn();
    }
}

function scrollToMovieProj(e){
    e.preventDefault();
    $("html, body").animate({ scrollTop: $('#projectionsMovie').position().top }, 1000);
}

var inputSeatsNum = $("#projectionInfo li:eq(3) span:eq(1) #inputSeatsNum").length;
if(inputSeatsNum){
    var inputSeatsNumValue = parseInt($("#projectionInfo li:eq(3) span:eq(1) #inputSeatsNum").val());
}

function changeSeatsNum(e){
    let numberOfChosenSeats = $("#seatsChosenList li").length;
    let value = parseInt($(this).val());
    if(numberOfChosenSeats > value){
        $("#projectionInfo li:eq(3) span:eq(1) #inputSeatsNum").val(value+1);
    }else{
        let pricePerTicket = $("#pricePerTicket").val();
        let decimalPricePerTicket = parseFloat(pricePerTicket);
        let seatsLeftToChoose = $("#selectMoreSeats span").text();
        let seatsLeftToChooseNum = parseInt(seatsLeftToChoose);

        if(value > inputSeatsNumValue){
            seatsLeftToChooseNum++;
        }else{
            if(seatsLeftToChooseNum > 0){
                seatsLeftToChooseNum--;
            }
        }
        inputSeatsNumValue = value;
        let priceSum = (decimalPricePerTicket *  inputSeatsNumValue).toFixed(2);
        $("#resSum span").text(priceSum + " $");
        $("#selectMoreSeats span").text(seatsLeftToChooseNum);
    }
}

function makeReservation(){
    let seatsLeftToChoose = $("#selectMoreSeats span").text();
    let seatsLeftToChooseNum = parseInt(seatsLeftToChoose);
    let seats = $("#projectionInfo li:eq(3) span:eq(1) #inputSeatsNum").val();
    let seatsNum = parseInt(seats);
    let projectionId = $("#projectionId").val();
    let seatIdArray = [];
    let lis = document.querySelectorAll("#seatsChosenList li");
    for(let li of lis){
        seatIdArray.push(parseInt(li.dataset.id));
    }
   // console.log(seatIdArray);

    if(seatsLeftToChooseNum === 0){
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: global_url + "makeReservation",
            method: "post",
            data: {
                seatsNum: seatsNum,
                projectionId: projectionId,
                seatIdArray: seatIdArray
            },
            success: function(data){
                $("<p class='success'>Your reservation was successful. :)</p>").insertAfter("#resSum");
                $("#confirmReservation").unbind("click");
            },
            error: function(err){

            }

        })
    }
}

function chooseSeat() {
    let moreSeats = $("#selectMoreSeats span").text();
    let numMoreSeats = parseInt(moreSeats);

    if (numMoreSeats) {
        numMoreSeats--;
        console.log(numMoreSeats);
            let seat = $(this).data("seat");
            let seatId = $(this).data("id");
            let row = $(this).parent().data("row");
            let html = `<li data-id="${seatId}">Row: ${row}, Seat: ${seat}<span class="fa fa-close"></span></li>`;
            $("#selectMoreSeats span").text(numMoreSeats);
            $("#seatsChosenList").append(html);
    }

}

function continueReservation(){
    let si_movie = $("#reservationMovieDdl option:selected").index();
    let si_projection = $("#reservationProjectionDdl option:selected").index();

    if(si_movie && si_projection){
        return true;
    }else{
        return false;
    }
}

function makeDdl(printNewDdlFromIndex = -1){
    var x, i, j, l, ll, selElmnt, a, b, c;
    i=0;
    if(printNewDdlFromIndex > -1){
        i = printNewDdlFromIndex;
    }
    /* Look for any elements with the class "custom-select": */
    x = document.getElementsByClassName("custom-select");
    l = x.length;
    if(printNewDdlFromIndex > -1){
        l = printNewDdlFromIndex + 1;
    }
    for (i; i < l; i++) {
        selElmnt = x[i].getElementsByTagName("select")[0];
        ll = selElmnt.length;
        /* For each element, create a new DIV that will act as the selected item: */
        if(printNewDdlFromIndex === -1){
            a = document.createElement("DIV");
            a.setAttribute("class", "select-selected");
            a.innerHTML = selElmnt.options[selElmnt.selectedIndex].innerHTML;
            x[i].appendChild(a);
        }
        /* For each element, create a new DIV that will contain the option list: */
        b = document.createElement("DIV");
        b.setAttribute("class", "select-items select-hide");
        for (j = 0; j < ll; j++) {
            /* For each option in the original select element,
            create a new DIV that will act as an option item: */
            c = document.createElement("DIV");
            c.innerHTML = selElmnt.options[j].innerHTML;
            c.addEventListener("click", function(e) {
                /* When an item is clicked, update the original select box,
                and the selected item: */
                var y, i, k, s, h, sl, yl;
                s = this.parentNode.parentNode.getElementsByTagName("select")[0];
                sl = s.length;
                h = this.parentNode.previousSibling;
                for (i = 0; i < sl; i++) {
                    if (s.options[i].innerHTML == this.innerHTML) {
                        s.selectedIndex = i;
                        // console.log(s);
                        h.innerHTML = this.innerHTML;
                        y = this.parentNode.getElementsByClassName("same-as-selected");
                        yl = y.length;
                        for (k = 0; k < yl; k++) {
                            y[k].removeAttribute("class");
                        }
                        this.setAttribute("class", "same-as-selected");
                        break;
                    }
                }
                h.click();
                s.click();
            });
            b.appendChild(c);
        }
        x[i].appendChild(b);
        if(a){
            a.addEventListener("click", function(e) {
                /* When the select box is clicked, close any other select boxes,
                and open/close the current select box: */
                e.stopPropagation();
                closeAllSelect(this);
                this.nextSibling.classList.toggle("select-hide");
                this.classList.toggle("select-arrow-active");
            });
        }
        if(printNewDdlFromIndex > -1){
            selElmnt.selectedIndex = 0;
            if(printNewDdlFromIndex === 2){
                selElmnt.parentElement.children[1].innerHTML = "Choose projection..";
            }else{
                selElmnt.parentElement.children[1].innerHTML = "Choose movie..";
            }
            let optionsDivHolder = selElmnt.parentElement.children[2].getElementsByClassName("same-as-selected");
            let optL = optionsDivHolder.length;
            for (let l = 0; l < optL; l++) {
                optionsDivHolder[l].removeAttribute("class");
            }
            selElmnt.parentElement.children[2].children[0].setAttribute("class", "same-as-selected");

            let nextList = x[++i];
            if(nextList){
                let selectElement = nextList.getElementsByTagName("select")[0];
                selectElement.innerHTML = "<option value='0'>Choose projection..</option>";
                selectElement.selectedIndex = 0;
                selectElement.parentElement.children[1].innerHTML = "Choose projection..";

                let opts = selectElement.parentElement.children[2].getElementsByTagName("div");
                selectElement.parentElement.children[2].innerHTML = "<div class='same-as-selected'>Choose projection..</div>";
            }
        }
    }
    $(".custom-select #reservationDateDdl").unbind('click');
    $(".custom-select #reservationMovieDdl").unbind('click');
    $(".custom-select #reservationDateDdl").click(reservationDateDdlChanged);
    $(".custom-select #reservationMovieDdl").click(reservationMovieDdlChanged);
}

function reservationMovieDdlChanged(){
    let si = $(this)[0].selectedIndex;
    let selectedOptionValue = $(this)[0][si].attributes[0].nodeValue;
    let dateIndex = $("#reservationDateDdl")[0].selectedIndex;
    let date  =  $("#reservationDateDdl option")[dateIndex].attributes[0].nodeValue;

    if(selectedOptionValue !== '0'){
        updateReservationProjectionList(selectedOptionValue, date);
    }else{
        let selectElement = document.getElementById("reservationProjectionDdl");
        selectElement.innerHTML = "<option value='0'>Choose projection..</option>";
        selectElement.selectedIndex = 0;
        selectElement.parentElement.children[1].innerHTML = "Choose projection..";

        let opts = selectElement.parentElement.children[2].getElementsByTagName("div");
        selectElement.parentElement.children[2].innerHTML = "<div class='same-as-selected'>Choose projection..</div>";
    }
}

function  updateReservationProjectionList(selectedOptionValue, date){
    $.ajax({
        url: global_url + "getProjectionsDdl",
        method: "get",
        data: {
            movieId: selectedOptionValue,
            date: date
        },
        success: function(data){
             let ddl = $("#reservationProjectionDdl");//.find("option").first()
             $("#reservationProjectionDdl").parent().find(".select-items").remove();

             let html = `<option value='0'>Choose projection..</option>`;
            if(data.projections){
                for(let p of data.projections){
                    let dateObj = new Date(p.starts_at);
                    let dateArray = formatDate(dateObj);
                    html += `<option value="${p.id}">${dateArray["day"]}.${dateArray["month"]}.${dateArray["year"]}. ${dateArray["hours"]}.${dateArray["minutes"]}  (${p.technologyName})</option>`;
                }
            }

            ddl.html(html);

            makeDdl(printNewDdlFromIndex = 2);
        },
        error: function(err){

        }
    })
}

function reservationDateDdlChanged(){
    let si = $(this)[0].selectedIndex;
    let selectedOptionValue = $(this)[0][si].attributes[0].nodeValue;
    //console.log(selectedOptionValue);
    updateReservationMovieList(selectedOptionValue);
}

function updateReservationMovieList(selectedOptionValue){
    $.ajax({
        url: global_url + "getMoviesDdl",
        method: "get",
        data: {
            date: selectedOptionValue
        },
        success: function(data){
            let ddl = $("#reservationMovieDdl");//.find("option").first()
            $("#reservationMovieDdl").parent().find(".select-items").remove();

            let html = `<option value='0'>Choose movie..</option>`;
            if(data.movies){
                for(let m of data.movies){
                    html += `<option value="${m.id}">${m.name}</option>`;
                }
            }

            ddl.html(html);//<option value='0'>Choose movie..</option><option>dkdkdkdk</option>

             makeDdl(printNewDdlFromIndex = 1);
        },
        error: function(err){

        }
    })
}

function closeAllSelect(elmnt) {
    /* A function that will close all select boxes in the document,
    except the current select box: */
    var x, y, i, xl, yl, arrNo = [];
    x = document.getElementsByClassName("select-items");
    y = document.getElementsByClassName("select-selected");
    xl = x.length;
    yl = y.length;
    for (i = 0; i < yl; i++) {
        if (elmnt == y[i]) {
            arrNo.push(i)
        } else {
            y[i].classList.remove("select-arrow-active");
        }
    }
    for (i = 0; i < xl; i++) {
        if (arrNo.indexOf(i)) {
            x[i].classList.add("select-hide");
        }
    }
}

function showReservation(e){
    e.preventDefault();
    $('#blurBackgroundReservation').fadeIn();
    $('body').css({'overflow':'hidden'});
    $(document).bind('scroll',function () {
        window.scrollTo(0,0);
    });
}

var global_url = "https://diplomski-movie-blackout.herokuapp.com/";
function hideRepplies() {
    $(this).parent().parent().parent().parent().find(".repliesDiv").slideUp();
}

function showRepplies(){
    let repplies = $(this).parent().parent().parent().parent().find(".repliesDiv").find('.repplyComment').length;
    let newlyPosted = $(this).parent().parent().parent().parent().find(".repliesDiv").find('.newlyPosted').length;
    console.log("broj replajeva:"+ repplies);
    let parent_id = $(this).data('id');
    let repliesDivObj = $(this).parent().parent().parent().parent().find(".repliesDiv");
    console.log(repliesDivObj);

    if((repplies > 0) && (newlyPosted === 0)){
        $(this).parent().parent().parent().parent().find(".repplyComment").show();
        $(this).parent().parent().parent().parent().find(".repliesDiv").slideDown();
    }else{
        getReppliesOfComment(parent_id, repliesDivObj);
    }
}

function printRepplies(repplies, loggedUserId, isNewlyPosted=0){
    let html = ``;
    for(let r of repplies){
        html += `<div class="repplyComment `;
        if(isNewlyPosted){
            html += `newlyPosted`;
        }
        html+=`">
                    <div class="userFaHolder">
                        <span class="fa fa-user`;
        if (r.gender_id === 1){
            html += ` femaleUser`;
        }else{
            html += ` maleUser`;
        }
        html += `"></span>
                     <p class="memberSince">Member since</p>`;
        let dateObj = new Date(r.registered_at);
        let dateArray = formatDate(dateObj);
        html += `<p class="memberDate">${dateArray["day"]}.${dateArray["month"]}.${dateArray["year"]}.</p>
        </div>
        <div class="commentRight">
        <div class="topPartComment">
            <span class="usernameComment">${r.username}</span>`;
        dateObj = new Date(r.posted_at);
        dateArray = formatDate(dateObj);
        html += `<span class="commPosted">${dateArray["day"]}.${dateArray["month"]}.${dateArray["year"]}. ${dateArray["hours"]}.${dateArray["minutes"]}</span>
        </div>
        <div class="commentTextDiv">
            <div class="commText">${r.text}</div>
        </div>
        <div class="bottomPartComment">`;
        if(loggedUserId){
            html += `<span class="repply" data-id="${r.id}">Repply</span>`;
            if(loggedUserId === r.user_id){
                html += `<span class="fa fa-edit" data-id="${r.id}" data-movid="${r.movie_id}"></span>
                             <span class="fa fa-trash" data-id="${r.id}" data-movid="${r.movie_id}"></span>`;
            }
        }
        html += `</div>
                </div>
            </div>`;
    }
    return html;
}

function formatDate(dateObj){
    let dateArray = [];
    let day = dateObj.getDate();
    let month = dateObj.getMonth();
    let year = dateObj.getFullYear();
    let hours = dateObj.getHours();
    let minutes = dateObj.getMinutes();

    if(day < 10)
    {
        day = '0' + day;
    }
    if(month < 10){
        month = '0' + (month-1);
    }
    if(hours < 10){
        hours = '0' + hours;
    }
    if(minutes < 10){
        minutes = '0' + minutes;
    }
    dateArray["day"] = day;
    dateArray["month"] = month;
    dateArray["year"] = year;
    dateArray["hours"] = hours;
    dateArray["minutes"] = minutes;
    return dateArray;
}

function getReppliesOfComment(parent_id, repliesDivObj){
    $.ajax({
        url: "getReppliesOfComment/" + parent_id,
        method: "get",
        success: function (data) {
            let html = printRepplies(data.repplies, data.loggedUserId);
            repliesDivObj.html(html);
            $(".bottomPartComment .fa-edit").click(updateComment);
            $(".bottomPartComment .fa-trash").click(deleteComment);
            $(".repplyComment .repply").click(repplyToRepply);
        },
        error: function (err) {

        }
    })
}

function repplyToRepply(){
    let parent_id = $(this).parent().parent().parent().parent().parent().find(".comment").find(".fa-edit").data('id');
    $(".newRepply").remove();
    let repplyToUsername = $(this).parent().parent().find(".topPartComment").find(".usernameComment").text();

    let userFaHtml = $("#leaveComm .userFaHolder").html();
    let topCommHtml = $("#leaveComm .topPartComment").html();

    let html = `<div class="newRepply">
            <div class="userFaHolder">
               ${userFaHtml}
            </div>
            <div class="commentRightRepply">
                <div class="topPartCommentRepply">
                    ${topCommHtml}
                </div>
                <textarea class="myCommentRepply2" placeholder="Leave a repply...">@${repplyToUsername} </textarea>
            </div>
            <span class="fa fa-close"></span>
        </div>`;

    let firstRepplyObj = $(this).parent().parent().parent().parent().find(".repplyComment").first();
    $(html).insertBefore(firstRepplyObj);

    $(".myCommentRepply2").keyup(function(event){
        if (event.keyCode === 13) {
            let text = $(this).val();
            let movie_id = $("#viewMoreCom").data("movid");
            postRepply(parent_id, text, movie_id, $(this));
            let repplyObj = $(this).parent().parent();
            console.log(repplyObj);
            $(this).parent().html("Your repply was posted. <span class='fa fa-check'></span>");
            repplyObj.delay(2000).fadeOut(function(){
                repplyObj.remove();
            });
        }
    });
}

function repplyToComment(){
    let parent_id = $(this).data('id');
    $(".newRepply").remove();
    // let repllyToUsername = $(this).parent().parent().find(".topPartComment").find(".usernameComment").text();
    let userFaHtml = $("#leaveComm .userFaHolder").html();
    let topCommHtml = $("#leaveComm .topPartComment").html();
    // let repplies = $('.repplyComment').length;
    let repplies = $(this).parent().parent().parent().parent().find(".repliesDiv").find('.repplyComment').length;

    let html = `<div class="newRepply">
            <div class="userFaHolder">
               ${userFaHtml}
            </div>
            <div class="commentRightRepply">
                <div class="topPartCommentRepply">
                    ${topCommHtml}
                </div>
                <textarea class="myCommentRepply" placeholder="Leave a repply..."></textarea>
            </div>
            <span class="fa fa-close"></span>
        </div>`;

    if(repplies){
        console.log(repplies);
        $(this).parent().parent().parent().parent().find(".repliesDiv").hide();
        let firstRepplyObj = $(this).parent().parent().parent().parent().find(".repplyComment").first();
        $(this).parent().parent().parent().parent().find(".repplyComment").hide();
        $(html).insertBefore(firstRepplyObj);
        $(this).parent().parent().parent().parent().find(".repliesDiv").slideDown();
    }else{
        $(this).parent().parent().parent().parent().find(".repliesDiv").html(html);
    }
    if(!$(this).parent().parent().parent().parent().find(".repliesDiv").is(":visible")){
        $(this).parent().parent().parent().parent().find(".repliesDiv").slideDown();
    }
    $(".newRepply .fa-close").click(function(){
        console.log($(this).parent())
        $(this).parent().remove();
    });
    // $("body").on("click", ".newRepply .fa-close", function(e){
    //     console.log(e.target.parentElement);
    //     console.log($(e.target).parents());
    //    $(this).parent().remove();
    // });
    $(".myCommentRepply").keyup(function(event){
        if (event.keyCode === 13) {
            let text = $(this).val();
            let movie_id = $("#viewMoreCom").data("movid");
            postRepply(parent_id, text, movie_id, $(this));
            let repplyObj = $(this).parent().parent();
            console.log(repplyObj);
            $(this).parent().html("Your repply was posted. <span class='fa fa-check'></span>");
            repplyObj.delay(2000).fadeOut(function(){
                repplyObj.remove();
            });
        }
    });
}

function postRepply(parent_id, text, movie_id, obj){
    console.log(obj.parent().parent().parent());
    let repliesDivObj = obj.parent().parent().parent();
    let numOfRepplies = repliesDivObj.find(".repplyComment").length;

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: "postRepply",
        method: "post",
        data:{
            parent_id: parent_id,
            comment: text,
            idMovie: movie_id
        },
        success: function(data){
            let isNewlyPosted = 1;
            let html = printRepplies([data.newComment],data.loggedUserid, isNewlyPosted);
            if(numOfRepplies){
                let firstRepplyObj = repliesDivObj.find(".repplyComment").first();
                $(html).insertBefore(firstRepplyObj);
            }else{
                repliesDivObj.html(html);
            }

        },
        error: function(data){

        }
    })
}

var offsetComments = 0;

function viewMoreComments(e){
    e.preventDefault();
    let id= $(this).data('movid');
    offsetComments += 5;

    $.ajax({
        url:  "viewMoreComments/" + id + "/" + offsetComments,
        method: "GET",
        dataType: 'json',
        success: function(data){
                    if(data.comments.length){
                        let len = $('.moreCommentsHolder').length;
                        let html = printComments(data.comments, data.loggedUserId);
                        if(len){
                            let obj = $("#peopleComments .moreCommentsHolder").last();
                            $("<div class='moreCommentsHolder'></div>").insertAfter(obj);
                            let newObj = $("#peopleComments .moreCommentsHolder").last();
                            newObj.hide();
                            newObj.html(html);
                            newObj.fadeIn();
                        }else{
                            let obj = $("#peopleComments .commentReplyHolder").last();
                            $("<div class='moreCommentsHolder'></div>").insertAfter(obj);
                            $(".moreCommentsHolder").hide();
                            $(".moreCommentsHolder").html(html);
                            $(".moreCommentsHolder").fadeIn();

                        }
                        $(".bottomPartComment .fa-edit").click(updateComment);
                        $(".bottomPartComment .fa-trash").click(deleteComment);
                        $(".bottomPartComment .repply").click(repplyToComment);
                        $(".bottomPartComment .fa-angle-down").click(showRepplies);
                    }
        },
        error: function(error){
            console.log(error);
        }
    });
}

function  deleteComment(){
    let id = $(this).data('id');
    $(this).parent().parent().parent().parent().remove();//bilo je hide
console.log("fff");
    $.ajax({
        url:  "deleteComment/" + id,
        method: "GET",
        success: function(data){
            let stringNumComm = $("#commentsNumber").text();
            let numberComments = parseInt(stringNumComm);
            if(numberComments){
                numberComments--;
            }
            $("#commentsNumber").html(numberComments);
        },
        error: function(error){
            console.log(error);
        }
    });
}

function updateComment(){
    $(this).css("display", "none");
    let commentRightObj =  $(this).parent().parent().parent().find(".commentRight");
    let comment = $(this).parent().parent().find(".commentTextDiv").find(".commText").text();
    //console.log(comment);
    let ta_html =`<textarea class='updateCommArea'>${comment}</textarea>`;

    let commentId = $(this).data('id');

    $(this).parent().parent().parent().find(".commentTextDiv").html(ta_html);
    $("<span class='fa fa-close'></span>").insertAfter(commentRightObj);

    $("body").on("keyup", "#comments .updateCommArea", function(event){
        if (event.keyCode === 13) {
            let modifiedComm = $(this).val();
            let updateCommAreaObj = $(this);

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "updateComment",
                method: "post",
                data:{
                    newComment: modifiedComm,
                    commentId: commentId
                },
                success: function(data){
                    let commPostedObj = updateCommAreaObj.parent().parent().parent().find('.commPosted');
                    let editedObj =  commPostedObj.parent().find(".editedComm");

                    if(editedObj.length == 0){
                        $("<span class=\"editedComm\">Edited</span>").insertAfter(commPostedObj);
                    }
                    updateCommAreaObj.parent().parent().parent().find('.fa-close').css("display","none");
                    updateCommAreaObj.parent().parent().parent().find('.fa-edit').css("display", "initial");
                    updateCommAreaObj.parent().html(`<p class="commText">${modifiedComm}</p>`);
                },
                errors: function(err){

                }

            })
        }
    });
}

function postComment(){
    let comment = $("#myComment").val();
    let idMovie = $("#postCommentForm .fa-pencil").data('movid');
    let _token =  $("input[name='_token']").val();
    if(comment.trim() !== ""){
        $.ajax({
            url: "postComment",
            method: "post",
            data:{
                _token: _token,
                comment: comment,
                idMovie: idMovie
            },
            success: function(data){
                //console.log("uspeh");
                let numOfComments = $(".commentReplyHolder").length;
                console.log(numOfComments);
                if(numOfComments >= 5){
                    console.log($(".commentReplyHolder").eq(5));
                    $(".commentReplyHolder").eq(4).remove();
                }
                $("#myComment").val("");
                addNewlyPostedComment(data.newComment, data.loggedUserId);
            },
            error: function(error){
                //console.log("neuspeh");
            }
        })
    }
}

function addNewlyPostedComment(comment, loggedUserId){
    let html = "";
    let stringNumComm = $("#commentsNumber").text();
    let numberComments = parseInt(stringNumComm);
    numberComments++;
    $("#commentsNumber").html(numberComments);

    html = printComments([comment], loggedUserId);
    // naravno da je korisnik koji je postavio kom ulogovan, medjutim bitno je da se prosledi i ovaj parametar
    // zbog ispisa ajaxom klikom na view more kada se takodje poziva funkcija printComments()

    let obj = $("#peopleComments .commentReplyHolder").first();
    console.log(obj);
    if(obj.length){
        $(html).insertBefore(obj);
    }else{
        // $("#peopleComments").append(html);
        $(html).insertAfter("#postCommentForm");
    }
    $(".bottomPartComment .fa-edit").click(updateComment);
    $(".bottomPartComment .fa-trash").click(deleteComment);
    $(".bottomPartComment .repply").click(repplyToComment);
    $(".bottomPartComment .fa-angle-down").click(showRepplies);
    $(".bottomPartComment .fa-angle-up").click(hideRepplies);
}

function printComments(comments, loggedUserId){
    let html = ``;
    for(let comment of comments){
        html += `<div class="commentReplyHolder"><div class="comment">
                    <div class="userFaHolder">
                        <span class="fa fa-user`;
        if (comment.gender_id === 1){
            html += ` femaleUser`;
        }else{
            html += ` maleUser`;
        }
        html += `"></span>
                     <p class="memberSince">Member since</p>`;
        let dateObj = new Date(comment.registered_at);
        let dateArray = formatDate(dateObj);
        html += `<p class="memberDate">${dateArray["day"]}.${dateArray["month"]}.${dateArray["year"]}</p>
        </div>
        <div class="commentRight">
        <div class="topPartComment">
            <span class="usernameComment">${comment.username}</span>`;
        dateObj = new Date(comment.posted_at);
        dateArray = formatDate(dateObj);

        html += `<span class="commPosted">${dateArray["day"]}.${dateArray["month"]}.${dateArray["year"]}. ${dateArray["hours"]}.${dateArray["minutes"]}</span>
        </div>
        <div class="commentTextDiv">
            <div class="commText">${comment.text}</div>
        </div>
        <div class="bottomPartComment">
            <span class="fa fa-angle-down showReplies angle" data-id="${comment.id}"></span>
            <span class="fa fa-angle-up hideReplies angle" data-id="${comment.id}"></span>`;
        if(loggedUserId){
            html += `<span class="repply" data-id="${comment.id}">Repply</span>`;
            if(loggedUserId === comment.user_id){
                html += `<span class="fa fa-edit" data-id="${comment.id}" data-movid="${comment.idMovie}"></span>
                             <span class="fa fa-trash" data-id="${comment.id}" data-movid="${comment.idMovie}"></span>`;
            }
        }
        html += `</div>
                </div>
            </div>
            <div class="repliesDiv"></div>
            </div>`;
        //pred poslednji div <span class='fa fa-close'></span>
    }
    return html;
}

var rbMoviesSortChecked;

function filterMovies(){
    var indexDate = $("#dateFilter").prop("selectedIndex");
    let dateValue = document.getElementById("dateFilter")[indexDate].value;
    // console.log(dateValue);
    var indexTechnology = $("#technologyFilter").prop("selectedIndex");
    let technValue = document.getElementById("technologyFilter")[indexTechnology].value;
    var indexGenre = $("#genreFilter").prop("selectedIndex");
    let genreValue = document.getElementById("genreFilter")[indexGenre].value;
    let searched = $("#extendSearch").val();
    let rb = document.getElementsByName("sortMovies");

    for(let r of rb){
        if(r.checked){
            if(r.value !== rbMoviesSortChecked){
                rbMoviesSortChecked = r.value;
            }
        }
    }

    $.ajax({
        url:"filterMovies",
        method: "get",
        data:{
            date: dateValue,
            technology: technValue,
            genre: genreValue,
            searched: searched.trim(),
            sort: rbMoviesSortChecked
        },
        dataType: "json",
        success: function(data){
            if(!data.movies.length){
                $("#moviesContainer").html("<p id='noResult'>No result found. :(</p>");
            }else{
                printMovies(data.movies.slice(0,4));
                printPagination(data.movies, 4)
            }

            if($("#deleteFiltersDiv").hasClass("notVisibleFilterDiv")){
                $("#deleteFiltersDiv").removeClass("notVisibleFilterDiv");
                $("#deleteFiltersDiv").hide();
            }else{
                $("#deleteFiltersDiv").show();
            }

        },
        error:function(xhr, textStatus, errorThrown){
            //console.log(xhr.responseJSON.errors);
        }
    });
    console.log(dateValue + " " + technValue + " " + genreValue + " " + searched + " " + rbMoviesSortChecked);
}

function printPagination(movies, limit){
    var length = movies.length;
    var i;
    var paginationHtml ="";
    var numOfPagLinks = Math.ceil(length/limit);
    for(i = 0; i < numOfPagLinks; i++){
        paginationHtml += `<li>
    <a href="#" class="filteredPagination" data-limit="${i}"> ${i+1}</a>
    </li>`;
    }
    $('#paginationDiv #pagination').html(paginationHtml);
    document.getElementsByClassName('filteredPagination')[0].classList.add('activePagination');
    $('#paginationDiv #pagination .filteredPagination').click(function(e){
        e.preventDefault();
        $('.filteredPagination').removeClass('activePagination');
        $(this).addClass('activePagination');
        var offset = $(this).data('limit');
        clickedPaginationFiltered(movies, offset);
    });
}

function clickedPaginationFiltered(movies, offset){
    var limit = 4;
    var printStart = limit * offset + 1;
    var printEnd = printStart + (limit - 1);
    console.log(printStart);
    console.log(printEnd);
    var i = 0;
    let html = '';
    let arrayToPrint = [];
    for(movie of movies){
        i++;
        if((i>=printStart) && (i<=printEnd)){
            arrayToPrint.push(movie);
        }
    }
   printMovies(arrayToPrint);
    $("html, body").animate({ scrollTop: $('#movies').position().top }, 1000);
}

function printMovies(movies){
    let html = "";
    for(let movie of movies){
        html += `<div class="movie">
                    <div class="picGeneralMovieInfo">
                        <div class="moviePic">
                            <a href="${global_url}movie/${movie.idMovie}">
                            <img src="${urlPics}/${movie.picName}" alt="${movie.alt}" width="250" height="350"/>
                            </a>
                        </div>
                    <div class="generalMovieInfo">
                    <a href="${global_url}movie/${movie.idMovie}">
                        <h3> ${movie.movieName}<span class="ageLimit"> ${movie.age_limit}</span></h3>
                    </a>
                        <span class="movieGrade">
                                        <p class="numberMovieGrade"> ${movie.grade}</p>
                        <ul>`;
        html += writeStars(movie);
        html+=          `</ul></span>
                        <p class="movieDesc"> ${movie.description }</p>`;
        let i=0;
         for(let genre of movie.genres){
             i++;
             html += `<p>${genre.genre}`;
             if(movie.genres.length !== i){
                 html += `, `;
             }
         }
        html += `| <span class="fa fa-clock-o"></span>  ${movie.running_time} min
                        </p>
                        <p class="movieDate">In cinemas from:`;
        let dateObj = new Date(movie.in_cinemas_from);
        let dateArray = formatDate(dateObj);

        html += `<span>${dateArray["day"]}.${dateArray["month"]}.${dateArray["year"]}</span>
                        </p>
                        <a href="${global_url}movie/${movie.idMovie}" class="detailsLink">View details</a>
                    </div>
    </div>
    <div class="movieProjections">`;

        html += writeMovieProjections(movie.projections);

        html += `<div class="cleaner"></div>
    </div>
</div>
<div class="decorationalMovieDiv"></div>`;
    }
    $("#moviesContainer").html(html);
}

function writeMovieProjections(projections){
    let user = $("#hiddenUserExists").val();
    let html = "";
    for(let p of projections){
        console.log(p + " projekcija");
        console.log(p.reservation_available);
        console.log(p.projectionAlreadyStartedEnded);
        let toDate = new Date(p.starts_at);
        let hour = toDate.getHours();
        let minute = toDate.getMinutes();
        if(hour < 10)
        {
            hour = '0' + hour;
        }
        if(minute < 10){
            minute = '0' + minute;
        }
    html += `<div class="movieProjection`;
    if((!p.reservation_available) || p.projectionAlreadyStartedEnded)
        {
                    html += " disabledReservation";
        }
        html += `">`;
    if(user != '0') {
        if(p.reservation_available && (!p.projectionAlreadyStartedEnded)) {
            html += ` <a href="${global_url}continueReservation/${p.id}" data-id="${p.id}" class="projectionLink">`;
        }
    }
    html += `<p class="movieTime">
                ${hour}:${minute}`;

    if((!p.reservation_available) || p.projectionAlreadyStartedEnded){
        html += `<span class="fa fa-ticket redTicket"></span>`;
    }else{
        html += `<span class="fa fa-ticket greenTicket"></span>`;
    }
    html += ` </p>
        <p class="movieHall">${p.name}</p>
        <p class="movieTechn">${p.technologyName}</p>`;
        if(user != '0') {
            if(p.reservation_available && (!p.projectionAlreadyStartedEnded)) {
                html += `</a>`;
            }
        }
       html += `</div>`;
    }
    return html;
}

var slideShow1;

function changeSliderMovie(e){
    clearInterval(slideShow);
    clearInterval(slideShow2);
    console.log(indexPic + " " + moviesArray[indexPic].movieName);
    e.preventDefault();

    let idAttr = $(this).attr("id");
    console.log(idAttr);
    if(idAttr === "leftArrow"){
        if(!(indexPic === 0)){
            indexPic--;
        }else{
            indexPic = moviesArray.length - 1;
        }

    }else{
        if(indexPic >= moviesArray.length - 1){
            indexPic = 0;
        }else{
            indexPic++;
        }

    }
    console.log(indexPic);
    console.log(indexPic + " " + moviesArray[indexPic].movieName);
    printSliderInfo();
    clearInterval(slideShow1);
    slideShow1 = setInterval('slider()',4000);

}

function showSubmenu(e){
    let hrefAttr = $(this).attr("href");

    if(hrefAttr == "#"){
        let clickedOnSame = $(this).parent().find(".menuChildrenList:visible");

        if(clickedOnSame.length){
            $(this).parent().find(".menuChildrenList").removeClass("visible");
            $(this).parent().find(".menuChildrenList").addClass("notVisible");
            $(this).parent().removeClass("no-border");
        }else{
            $("#menuList .menuChildrenList").removeClass("visible");
            $("#menuList .menuChildrenList").addClass("notVisible");
            $("#menuList .menuChildrenList").removeClass("no-border");
            $(this).parent().find(".menuChildrenList").addClass("visible");
            $(this).parent().find(".menuChildrenList").removeClass("notVisible");
            $(this).parent().addClass("no-border");
        }
    }
}

function extendSearch(){
    $("#movies .searchicon").css("margin-left","0px");
    $("#movies #extendSearch").removeClass("extend");
    $("#movies #extendSearch").addClass("extended");
    $("#movies #extendSearch").focus();
}

function showX(){
    $("#searchCont .fa-close").removeClass("notVisible");
    $("#searchCont .fa-close").addClass("visible");
}

function emptySearchInput(){
    $("#movies #extendSearch").val("");
    $("#searchCont .fa-close").removeClass("visible");
    $("#searchCont .fa-close").addClass("notVisible");
    $("#movies #extendSearch").focus();
}

function deleteFilters(){
    $("#extendSearch").val("");
    $('.ddlFilter').find('option').each( function() {
        var $this = $(this);

            $this.removeAttr('selected');

    });
     document.getElementById("technologyFilter").children[0].setAttribute("selected","selected");
    document.getElementById("genreFilter").children[0].setAttribute("selected","selected");
    document.getElementById("dateFilter").children[0].setAttribute("selected","selected");
    $('#descOrder').prop('checked', false);
    $('#ascOrder').prop('checked', true);
    $("#deleteFiltersDiv").addClass("notVisibleFilterDiv")
    filterMovies();
}

function movieSlider(){
    $.ajax({
        url:"getSliderData",
        method: "get",
        dataType: "json",
        success: function(data){
            moviesArray = data.movies;
            slider();
        },
        error:function(xhr, textStatus, errorThrown){
            //console.log(xhr.responseJSON.errors);
            }
    });
}

var indexPic = -1;
var moviesArray = [];//dodati = 0 da ne izlazi greska u konzoli !!!
function slider(){
    indexPic++;
    if(indexPic >= moviesArray.length){
        indexPic = 0;
    }

   printSliderInfo();

}
if($("#slider").length){
    var slideShow = setInterval('slider()',4000);
}

function printSliderInfo(){
    var pic= document.getElementById('sliderPicture');
   if(moviesArray[indexPic]){
       pic.src = urlPics + "/" + moviesArray[indexPic].picName;
       writeSliderActors(moviesArray[indexPic].actors);
       writeCenterSliderInfo(moviesArray[indexPic]);
       writeRightSliderInfo(moviesArray[indexPic]);
       writeSliderCircles();
   }
}

function writeSliderActors(actors){
    let html = "<span id='with'>With</span>\n";
    for(let a of actors){
        html += "<p>"
        let nameArray = a.name.split(" ");
        for(var i = 0; i < nameArray.length - 1; i++){
            html += `${nameArray[i]} `;
        }
        html += `<span class=\"actorLastname\">${nameArray[i]}</span></p>`;
    }

    $("#sliderActors").html(html);
}

function writeCenterSliderInfo(movie){
    let dateObj = new Date(movie.in_cinemas_from);
    let day = dateObj.getDate();
    let month = dateObj.getMonth();
    let year = dateObj.getFullYear();
    if(day < 10)
    {
        day = '0' + day;
    }
    if(month < 10){
        month = '0' + month;
    }

    let html = `<h2>${movie.movieName}</h2>\n` +
        `<p id=\"director\">By ${movie.dirName}</p>\n` +
        `                        <p id=\"inCinemasFrom\"><span class=\"fa fa-calendar\"></span>In cinemas from ${day}.${month}.${year}</p>\n` +
        `                        <a href="${global_url}movie/${movie.idMovie}"><button id=\"bookSliderMovie\">View more<span class=\"fa fa-angle-right\"></span></button></a>`;
    $("#centerSliderInfo").html(html);
}

function writeRightSliderInfo(movie){
    let html = `<span id="sliderGrade">${movie.grade}</span>
                        <ul>`;
    html += writeStars(movie);
    html += `</ul>
                        <span id="voters">${movie.voters} voters</span>
                        <p id="sliderTime"><span class="fa fa-clock-o"></span>${movie.running_time} min</p>
                        <p id="sliderGenres">`;
    for(let j = 0; j < movie.genres.length; j++){
        html += `${movie.genres[j].genre}`;
        if(movie.genres.length - 1 !== j){
            html += ", ";
        }
    }
    $("#sliderGrades").html(html);
}

function writeStars(movie){
    let gradeNumber = parseInt(movie.grade);
    let firstDecimal = parseInt(movie.grade.substr(2,1));

    let html = "";
    let i = 0;
    for(i; i < gradeNumber; i++){
        html += `<li><span class="fa fa-star"></span></li>`;
    }
    if((firstDecimal != 0) && (firstDecimal >= 3)){
        if(firstDecimal <= 7){
            i++;
            html += `<li><span class="fa fa-star-half-o"></span></li>`;
        }else{
            i++;
            html += `<li><span class="fa fa-star"></span></li>`;
        }
    }
    for(i;i < 10; i++){
        html += `<li><span class="fa fa-star-o"></span></li>`;
    }
    return html;
}

function writeSliderCircles(){
    let html = "";
    for(let i = 0; i < moviesArray.length; i++){
        if(i === indexPic){
            html += `<li><a href="#" data-id="${i}"><span class="fa fa-circle"></span></a></li>`
        }else{
            html += `<li><a href="#" data-id="${i}"><span class="fa fa-circle-o"></span></a></li>`;
        }
    }
    $("#sliderCircles").html(html);
    $("#sliderCircles li a").click(clickedSliderCircle);
}

var slideShow2;

function clickedSliderCircle(e){
    e.preventDefault();
    let idAttr = $(this).data("id");
    let numOfCircle = parseInt(idAttr);
    console.log(numOfCircle);
    clearInterval(slideShow);
    clearInterval(slideShow1);
    clearInterval(slideShow2);

   indexPic = numOfCircle;
   printSliderInfo();
   slideShow2 = setInterval('slider()', 4000);
}

function checkingRegData(){
    var name = document.querySelector("#regName").value.trim();
    var pass = document.querySelector("#regPass").value.trim();
    var pass1 = document.querySelector("#regPass1").value.trim();
    var email = document.querySelector("#email").value.trim();
    var tel = document.querySelector("#tel").value.trim();
    var genderArray=document.getElementsByName('gender');
    if(document.querySelector('#chbMail').checked){
        var sendViaMail=1;
    }else{
        sendViaMail=null;
    }

    var nameError = document.querySelector("#nameError");
    var passError = document.querySelector("#passError");
    var pass1Error = document.querySelector("#regPass1Error");
    var emailError = document.querySelector("#mailError");
    var telError = document.querySelector("#telError");
    var genderError = document.querySelector("#genderError");
    var townError = document.querySelector("#townError");
    var _token = $("input[name='_token']").val();

    var reName=/^[A-Za-z]{6,15}[\d]{1,5}$/;
    var rePass=/[\d\w\@$\^\*\-\.\_\!\+\=\)\(\{\}\?\/\<\>]{6,13}/;
    var reEmail=/^\w+([\.-]?\w+)*\@\w+([\.-]?\w+)*(\.\w{2,4})+$/;
    var reTel=/^06[\d]\-[\d]{3}\-[\d]{3,4}$/;


    var errors = 0;
    if(name==""){
        nameError.innerHTML="Username field is required!";
        errors++;
    }else if(!reName.test(name)){
        nameError.innerHTML="Username must contain at least 6 characters and at least 1 number.";
        errors++;
    }else{
        nameError.innerHTML="";
    }

    if(pass==""){
        passError.innerHTML="Password field is required.";
        errors++;
    }else if(!rePass.test(pass)){
        passError.innerHTML="Password must contain at least 6 characters..";
        errors++;
    }else{
        passError.innerHTML="";
    }

    if(pass1!=pass){
        errors++;
        pass1Error.innerHTML="You must type in your password again.";
    }else if(pass1==""){
        pass1Error.innerHTML="You must type in your password again.";
        errors++;
    }else{
        pass1Error.innerHTML="";
    }

    if(email==""){
        emailError.innerHTML="Email field is required!";
        errors++;
    }else if(!reEmail.test(email)){
        emailError.innerHTML="Email is not in valid format.";
        errors++;
    }else{
        emailError.innerHTML="";
    }

    if(tel==""){

    }else if(!reTel.test(tel)){
        telError.innerHTML="Tel needs to be in this format 06*-***-****.";
        errors++;
    }else{
        telError.innerHTML="";
    }

    var selectedGender="";
    for(var i=0;i<genderArray.length;i++){
        if(genderArray[i].checked){
            selectedGender=genderArray[i].value;
            break;
        }
    }
    if(selectedGender==""){
        genderError.innerHTML="Choose gender.";
        errors++;
    }else{
        genderError.innerHTML="";
    }
    console.log(errors);
    if(errors === 0){
        $.ajax({
            url: global_url +"registration",
            method: "post",
            data: {
                _token: _token,
                username: name,
                pass: pass,
                pass1: pass1,
                email: email,
                tel: tel,
                selectedGender: selectedGender,
                sendViaMail: sendViaMail
            },
            success: function(data){
                successReg();
            },
            error:function(xhr, textStatus, errorThrown){
                //console.log(xhr.responseJSON.errors);
                //console.log(textStatus);
                //console.log(errorThrown);
                var error="An error occurred.";
                switch(xhr.status){
                    case 404:
                        error="Page not found.";
                        break;
                    case 422:
                        error="Your data is not in valid format.";
                        break;
                    case 500:
                        error="There was an error.Try again.";
                        break;
                    case 409:
                        error="<span class='fa fa-exclamation-triangle' aria-hidden='true'> </span> Someone with same username or email already exists.";
                        break;

                }
                console.log(error);
                let errorsResponse = xhr.responseJSON;
                let errorsResponseText = "";
                $.each(errorsResponse.errors,function (k,v) {
                    errorsResponseText += v + "<br/>";
                });
                let allErrors = errorsResponseText + "<br/>" + error;
                document.querySelector("#registrationForm .success").innerHTML=allErrors;
                document.querySelector("#registrationForm .success").classList.add('errorRegistration');
            }
        });
    }else{
        document.querySelector("#registrationForm .success").innerHTML="";
    }
    function successReg(){
        document.querySelector("#registrationForm .success").innerHTML='<span class="fa fa-check"></span> You are successfully registrated.';
        if($("#registrationForm .success").hasClass('errorRegistration'))
            document.querySelector("#registrationForm .success").classList.remove('errorRegistration');
        disappearReg=setInterval('disappear()',3000);
    }
}

function disappear(){
    $("#blurBackground").fadeOut();
    clearInterval(disappearReg);
}

                            // ****************** ADMIN *********************

function sortActivity(){
    let sort = document.getElementById('activityList').options[document.getElementById("activityList").selectedIndex].value;
    $.ajax({
        url: "sortActivity",
        method: "GET",
        data: {
            sort: sort
        },
        success: function (data) {
            console.log(data);
            printActivities(data.activities);
        },
        error: function (data) {
            console.log(data);
        }
    });
}

function printActivities(activities){
    let html = "<tr><th>Activity</th><th>Date</th></tr>";
    for(let a of activities){
        html += `<tr>
                      <td>${ a.text }</td>
                       <td>${ a.activity_time }</td>
                  </tr>`;
    }
    $("#activityTable").html(html);
}

function deleteAdminComment(){
    let id = $(this).data("id");
    let obj = $(this);
    $.ajax({
        url: "deleteComment/" + id,
        method: "get",
        success: function(data){
            obj.parent().parent().remove();
        },
        error: function(err){

        }

    });
}

function checkInsert(e){
    e.preventDefault();
    let text = $("#textLinkIns").val().trim();
    let path = $("#pathLinkIns").val().trim();
    let header = $("#headerLinkIns option:selected").val();
    let footer = $("#footerLinkIns option:selected").val();
    let parent = $("#parentLinkIns option:selected").val();
    let admin = 0;
    if($("#adminLinkIns").is(":checked")){
        admin = 1;
    }
    var _token = $("input[name='_token']").val();
    let errors = [];

    if(text == ""){
        errors.push("Text field is required!");
    }
    if(path == ""){
        errors.push("Path field is required!");
    }

    if(errors.length){
        let errHtml = "";
        for(let e of errors){
            errHtml += e + " ";
        }
        $("#insertLinkForm .error").html(errHtml);
        $("#insertLinkForm .success").html("");
    }else{
        $("#insertLinkForm .error").html("");
        $.ajax({
            url: "insertLink",
            method: "POST",
            data: {
                _token: _token,
                text: text,
                path: path,
                header: header,
                footer: footer,
                parent: parent,
                admin: admin
            },
            dataType: "json",
            success: function(data){
                $("#insertLinkForm .error").html("");
                $("#insertLinkForm .success").html("Link was successfully inserted.");
                printLinks(data.links);
            },
            error: function(err){
                $("#insertLinkForm .success").html("");
                $("#insertLinkForm .error").html("There was an error.");
            }

        })
    }
}

function updateLink(e){
    e.preventDefault();
    let id = $("#linkIdHidden").val();
    let text = $("#textLinkUpd").val().trim();
   let path = $("#pathLinkUpd").val().trim();
   let header = $("#headerLinkUpd option:selected").val();
   let footer = $("#footerLinkUpd option:selected").val();
   let parent = $("#parentLinkUpd option:selected").val();
   let admin = 0;
   if($("#adminLinkUpd").is(":checked")){
       admin = 1;
   }
   var _token = $("input[name='_token']").val();
   let errors = [];

   if(text == ""){
       errors.push("Text field is required!");
   }
    if(path == ""){
        errors.push("Path field is required!");
    }

    if(errors.length){
        let errHtml = "";
        for(let e of errors){
            errHtml += e + " ";
        }
        $("#updateLinkForm .error").html(errHtml);
        $("#updateLinkForm .success").html("");
    }else{
        $("#updateLinkForm .error").html("");
        $.ajax({
            url: "updateLink",
            method: "POST",
            data: {
                _token: _token,
                id: id,
                text: text,
                path: path,
                header: header,
                footer: footer,
                parent: parent,
                admin: admin
            },
            success: function(data){
                $("#updateLinkForm .error").html("");
                $("#updateLinkForm .success").html("Link was successfully updated.");
               getLinks();
            },
            error: function(err){
                $("#updateLinkForm .success").html("");
                $("#updateLinkForm .error").html("There was an error.");
            }

        })
    }
}

function getLinks(){
    $.ajax({
        url: "getLinks",
        method: "GET",
        success: function(data){
           printLinks(data.links);
        },
        error: function(err){

        }

    })
}

function printLinks(links){
    let html = `<tr>
                    <th>Num.</th>
                    <th>Text</th>
                    <th>Path</th>
                    <th>In header</th>
                    <th>In footer</th>
                    <th>Admin menu</th>
                    <th></th>
                </tr>`;
    let i = 0;
    for(let l of links){
        i++;
        html += ` <tr>
                    <td>${i}.</td>
                    <td>${l.text}</td>
                    <td>${l.href}</td>
                    <td>`;
        if(l.in_header){
            html += `Yes.`;
        }else{
            html += `No.`;
        }

          html += `</td>
                   <td>`;

        if(l.in_footer){
            html += `Yes.`;
        }else{
            html += `No.`;
        }
         html += ` </td>
                    <td>`;
        if(l.admin_link){
            html += `Yes.`;
        }else{
            html += `No.`;
        }

       html += ` </td>
        <td>
            <div><span class="fa fa-edit" data-id="${l.menu_id}"></span></div>
            <div><a href="${global_url}deleteLink/${l.menu_id}"><span class="fa fa-remove"></span></a></div>
        </td>
    </tr>`;
    }
    $("#linksTable").html(html);
    $("#linksTable .fa-edit").click(editLinkClick);
}

function editLinkClick(){
    let id = $(this).data("id");
    $.ajax({
        url: "getLinkData/" + id,
        method: "get",
        dataType: "json",
        success: function(data){
            console.log(data.link);
            let link = data.link[0];
            $("#linkIdHidden").val(id);
            $("#textLinkUpd").val(link.text);
            $("#pathLinkUpd").val(link.href);
            $("#headerLinkUpd option[value='" + link.in_header + "']").prop('selected', true);
            $("#footerLinkUpd option[value='" + link.in_footer + "']").prop('selected', true);
            $("#parentLinkUpd option[value='" + link.idParent + "']").prop('selected', true);
            if(link.admin_link){
                $("#adminLinkUpd").prop("checked", true);
            }else{
                $("#adminLinkUpd").prop("checked", false);
            }
            $('#blurBgUpdateLink').fadeIn();
            $(document).bind('scroll');
            $('body').css({'overflow':'hidden'});

        },
        error: function(err){
        }
    })
}

function printUsers(users){
    let html = `<tr>
                            <th>Num.</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Password</th>
                            <th>Role</th>
                            <th>Send news</th>
                            <th>Gender</th>
                            <th></th>
                        </tr>`;
    for(let i = 0; i < users.length; i++){
        html += `<tr>
                    <td>${i}.</td>
                    <td>${users[i].username}</td>
                    <td>${users[i].email}</td>
                    <td>${users[i].password}</td>
                    <td>${users[i].roleName}.</td>
                    <td>`;
        if(users[i].send_via_mail){
            html += `Send.`;
        }else{
            html += `Don't send.`;
        }

            html += `</td>
            <td>`;
        if(users[i].genderName == 'f'){
            html += `Female.`;
        }else{
            html += `Male.`;
        }

       html += `</td>
        <td>
            <div><span class="fa fa-edit" data-id="${users[i].idUser}"></span></div>
            <div><a href="${global_url}deleteUser/${users[i].idUser}"><span class="fa fa-remove"></span></a></div>
        </td>
    </tr>`;
    }
    $("#tableUsers").html(html);
}

function getUsers(){
    $.ajax({
        url: "getUsers",
        method: "GET",
        dataType: "json",
        success: function(data){
           printUsers(data.users);
        },
        error: function(err){
        }
    });
}

function checkUpdateUser(e){
    e.preventDefault();
    let id = $("#userIdHidden").val();
    let username = $("#usernameUpd").val();
    let password = $("#passwordUpd").val().trim();
    let role = $("#roleUserUpd option:selected").val();
    let email = $("#emailUserUpd").val();
    let gender = $("#genderUserUpd option:selected").val();
    let news =  $("#newsUserUpd option:selected").val();
    var _token = $("input[name='_token']").val();
    let errors = [];

    var reName=/^[A-Za-z]{6,15}[\d]{1,5}$/;
    var rePass=/[\d\w\@$\^\*\-\.\_\!\+\=\)\(\{\}\?\/\<\>]{6,13}/;
    var reEmail=/^\w+([\.-]?\w+)*\@\w+([\.-]?\w+)*(\.\w{2,4})+$/;

    if(username==""){
        errors.push("Username field is required.")
    }else if(!reName.test(username)){
        errors.push("Username field is not valid.")
    }

    if(password!="") {
        if (!rePass.test(password)) {
            errors.push("Password field is not valid.")
        }
    }
    console.log(errors);
    if(errors.length){
        let errHtml  =``;
        for(let e of errors){
            errHtml += e;
        }
        $("#updateUserForm .errors").html(errHtml)
    }else{
       $.ajax({
           url: "updateUser",
           method: "POST",
           data:{
               _token: _token,
               id: id,
               username: username,
               password: password,
               email: email,
               role: role,
               gender: gender,
               news: news
           },
           dataType: "json",
           success: function(data){
               $("#updateUserForm .error").html("");
               $("#updateUserForm .success").html("User update was successful.");
               getUsers();
           },
           error: function(err){
               $("#updateUserForm .success").html("");
               $("#updateUserForm .error").html("There was an error.");
           }
       });
    }

}

function getUser(){
    let id = $(this).data("id");
    $.ajax({
        url: "getUser/" + id,
        method: "get",
        success: function(data){
            console.log(data);
            $("#userIdHidden").val(data.user[0].id);
            $("#usernameUpd").val(data.user[0].username);
            $("#roleUserUpd option[value='" + data.user[0].role_id + "']").prop('selected', true);
            $("#emailUserUpd").val(data.user[0].email);
            $("#genderUserUpd option[value='" + data.user[0].gender_id + "']").prop('selected', true);
            $("#newsUserUpd option[value='" + data.user[0].send_via_mail + "']").prop('selected', true);
            $('#blurBgUpdateUser').fadeIn();
            $(document).bind('scroll');
            $('body').css({'overflow':'hidden'});
        },
        error: function(err){

        }
    });
}

function checkProjectionUpd(){
    let listIndex = $("#movieProjectionUpdate option:selected").index();
    let errors = [];

    if(!listIndex){
        errors.push("Choose movie. ");
    }
    let dateProj = $("#dateProjectionUpdate").val();
    if(dateProj == ""){
        errors.push(" Choose date. ");
    }
    let timeProj = $("#timeProjectionUpdate").val();
    let reTime = /^[\d]{2}\:[\d]{2}$/;
    if(timeProj==""){
        errors.push(" Choose projection time. ");
    }else if(!reTime.test(timeProj)){
        errors.push(" Projection time is not valid ");
    }
    let technProjIndex = $("#technProjectionUpdate option:selected").index();
    //console.log(technProjIndex);
    if(!technProjIndex){
        errors.push(" Choose technology. ");
    }
    let hallProjIndex = $("#hallProjectionUpdate option:selected").index();
    if(!hallProjIndex){
        errors.push(" Choose hall. ");
    }
    console.log(errors);
    if(errors.length){
        let errHtml  =``;
        for(let e of errors){
            errHtml += e;
        }
        $("#updateProjForm .errors").html(errHtml)
        return false;
    }else{
        return true;
    }
}

function searchProjectionsByMovie(event){
    if (event.keyCode === 13) {
        event.preventDefault();
       let searched = $("#searchProjections").val().trim();
       $.ajax({
           url: "getProjections",
           method: "GET",
           data: {
               searched: searched
           },
           success: function(data){
                // console.log(data.projections);
                printProjectionsAdmin(data.projections);
               $(".prInfo .fa-edit").click(editProjClick);
           },
           error: function(err){

           }
       })
    }
}

function printProjectionsAdmin(projections){
    let html = ``;
    for(let p of projections){
        let dateObj = new Date(p.starts_at);
        let dateArray = formatDate(dateObj);
        html += `<div class="projectionViewRow">
                                <div class="prMovie prInfo">${p.name}</div>
                                <div class="prDate prInfo">${dateArray["day"]}.${dateArray["month"]}.${dateArray["year"]}.  ${dateArray["hours"]}:${dateArray["minutes"]}</div>
                                <div class="prTechn prInfo">${p.technName}</div>
                                <div class="prHall prInfo">${p.hallName}</div>
                                <div class="prRes prInfo">`;
        if(p.reservation_available){
            html += `Available.`;
        }else{
            html += `Not available.`;
        }

        html += `</div>
                <div class="prUPdDel prInfo lastPr">
                    <span class="fa fa-edit" data-id="${p.id}"></span>
                    <a href="${global_url}deleteProjection/${p.id}"><span class="fa fa-remove"></span></a>
                </div>
            </div>
            <div class="projAdmBorder"></div>`;
    }
    $("#projectionViews").html(html);
}

function editProjClick(){
    let id = $(this).data("id");
   $.ajax({
       url: "getProjectionData/" + id,
       method: "GET",
       dataType: "json",
       success: function(data){
           let projection = data.projection;
           console.log(projection);
          let html = `<option value="0">Choose technology..</option>`;
           console.log(data.technologies);
           for(let t of data.technologies){
               html += `<option value="${t.id}">${t.name}</option>`;
           }
           $("#technProjectionUpdate").html(html);
           $("#movieProjectionUpdate option[value='" + projection.idMovie + "']").prop('selected', true);
           $("#hallProjectionUpdate option[value='" + projection.idHall + "']").prop('selected', true);
           $("#technProjectionUpdate option[value='" + projection.idTechnology + "']").prop('selected', true);
           $("#resProjectionUpdate option[value='" + projection.reservation_available + "']").prop('selected', true);
           // let dateobj = new Date(projection.starts_at);
           // console.log(dateobj);
           let startsAt = projection.starts_at.split(" ");
           let dateArray = startsAt[0].split("-");
           let timeArray = startsAt[1].split(":");

           $("#dateProjectionUpdate").val(dateArray[0] + "-" + dateArray[1] + "-" + dateArray[2]);
           $("#timeProjectionUpdate").val(timeArray[0] + ":" + timeArray[1]);
           $("#idProjHidden").val(id);
           $("#blurUpdateProj").fadeIn();
           $('body').css({'overflow':'hidden'});
           $(document).bind('scroll',function () {
               window.scrollTo(0,0);
           });
       },
       error: function(err){

       }
   })
}

function getMovieTechnologies(obj){
    let index = obj.find("option:selected")[0].index;
    let movieId = obj.find("option:selected")[0].value;
    if(index){
        $.ajax({
            url: "getMovieTechnologies/" + movieId,
            method: "get",
            dataType: "json",
            success: function(data){
                // console.log(data.technologies);
                let html = `<option value="0">Choose technology..</option>`;
                for(let t of data.technologies){
                    html += `<option value="${t.id}">${t.name}</option>`;
                }
                obj.parent().parent().find(".projectionTechnology").html(html);
            },
            error: function(err){
            }
        })
    }else{
        obj.parent().parent().find(".projectionTechnology").html("<option value='0'>Choose technology..</option>");
    }
}

function checkProjectionsInsert(){
    let projections = $(".adminProjection").length;
    let errors = 0;
    for(let i = 0; i < projections; i++){
        let listIndex = $(".projectionMovie")[i].selectedIndex;
        let errorHtml = "";
        let error = "";
        if(!i){
            error = $(".projectionMovie").eq(i).parent().parent().parent().children()[1];
        }else{
           error = $(".projectionMovie").eq(i).parent().parent().parent().children()[2];
        }

        error.innerHTML = "";
        if(!listIndex){
            errors++;
            error.innerHTML = "Choose movie. ";
        }
        let dateProj = $(".projectionDate").eq(i).val();
        if(dateProj == ""){
            errors++;
            errorHtml = error.innerHTML;
            error.innerHTML = errorHtml + " Choose date.";
        }
        let timeProj = $(".projectionTime").eq(i).val();
        let reTime = /^[\d]{2}\:[\d]{2}$/;
        if(timeProj==""){
            errors++;
            errorHtml = error.innerHTML;
            error.innerHTML = errorHtml + " Choose projection time. ";
        }else if(!reTime.test(timeProj)){
            errors++;
            errorHtml = error.innerHTML;
            error.innerHTML = errorHtml + " Projection time is not valid.";
        }
        let technProjIndex = $(".projectionTechnology")[i].selectedIndex;
        if(!technProjIndex){
            errors++;
            errorHtml = error.innerHTML;
            error.innerHTML = errorHtml + "Choose technology.";
        }
        let hallProjIndex = $(".projectionHall")[i].selectedIndex;
        if(!hallProjIndex){
            errors++;
            errorHtml = error.innerHTML;
            error.innerHTML = errorHtml + "Choose hall.";
        }
        if(errors){
            return false;
        }else{
            return true;
        }
    }
}

function printMoreProjections(){
    let num = $(this).val();
    let counted = $("#projectionsForm .adminProjection").length;
    let numToPrint = num - counted;
    let optionsFirstDdlMovie = $("#projectionsForm .adminProjection").first().find(".projectionMovie").html();
    let optionsFirstDdlHall =  $("#projectionsForm .adminProjection").first().find(".projectionHall").html();
    // console.log(optionsFirstDdlMovie);
    //  console.log(numToPrint);
    let html = ``;
    if(numToPrint > 0){
        for(let i = numToPrint; i <= numToPrint; i++){
            html += `<div class="adminProjection">
                    <div class="projectionX"><span class="fa fa-close"></span></div>
                    <div class="projectionRow">
                        <div class="projectionMovieLabel projectionLabel">
                            <label class="projectionLab">Movie:</label>
                             <select name="projectionMovie[]" class="projectionMovie inputAdminClass">
                                   ${optionsFirstDdlMovie}
                            </select>
                        </div>
                        <div class="projectionDateLabel projectionLabel">
                            <label class="projectionLab">Projection date:</label>
                            <input type="date" name="projectionDate[]" class="projectionDate inputAdminClass"/>
                        </div>
                       <div class="projectionTimeLabel projectionLabel">
                           <label class="projectionLab">Projection time:</label>
                           <input type="text" name="projectionTime[]" class="projectionTime inputAdminClass" placeholder="Projection time.."/>
                       </div>
                       <div class="projectionTechnologyLabel projectionLabel">
                           <label class="projectionLab">Technology:</label>
                           <select name="projectionTechnology[]" class="projectionTechnology inputAdminClass">
                               <option value="0">Choose technology..</option>
                           </select>
                       </div>
                        <div class="projectionHallLabel projectionLabel">
                                <label class="projectionLab">Hall:</label>
                                <select name="projectionHall[]" class="projectionHall inputAdminClass">
                                   ${optionsFirstDdlHall}
                                </select>
                        </div>
                       <div class="projectionResAvailableLabel projectionLabel">
                           <label class="projectionLab">Reservation?</label>
                           <select name="projectionResAvailable[]" class="projectionResAvailable inputAdminClass">
                               <option value="0">Not available.</option>
                               <option value="1" selected="true">Available.</option>
                           </select>
                       </div>
                    </div>
                    <p class="error"></p>
                </div>`;
        }
        let lastObj = $("#projectionsForm .adminProjection").last();
        $(html).insertAfter(lastObj);
    }else{
        $("#projectionsForm .adminProjection").last().remove();
    }
}

function checkMovieInsert(){
    let name = $("#nameMovIns").val().trim();
    let running_time = $("#timeMovIns").val().trim();
    let desc = $("#taShortDescIns").val().trim();
    let detailed_desc = $("#taDetailedDescIns").val().trim();
    let distributer = $("#distributerMovIns option:selected").index();
    let director = $("#directorMovIns option:selected").index();
    let country = $("#countryMovIns option:selected").index();
    let age_limit = $("#ageMovIns").val();
    let actors = $("#actorsListMovIns").find(".movUpdActGenres").length;
    let genres  = $("#genresListMovIns").find(".movUpdActGenres").length;
    let date = $("#dateMovIns").val();

    let reTime = /^[\d]{2,3}$/;

    var errors = [];

    if(date == ""){
        errors.push("In cinemas from field is required!");
    }
    if(name==""){
        errors.push("Movie name field is required!");
    }

    if(running_time==""){
        errors.push("Running time field is required!");
    }else if(!reTime.test(running_time)){
        errors.push("Running time is not valid.");
    }

    if(desc === ""){
        errors.push("Description cant't be empty.");
    }

    if(detailed_desc === ""){
        errors.push("Description detailed cant't be empty.");
    }

    if(!distributer){
        errors.push("Choose distributer.");
    }
    if(!director){
        errors.push("Choose director.");
    }
    if(!country){
        errors.push("Choose country.");
    }
    if(!actors){
        errors.push("Choose actors.");
    }
    if(!genres){
        errors.push("Choose genres.");
    }

    if(age_limit==""){
        errors.push("Age limit field is required!");
    }else if(!reTime.test(age_limit)){
        errors.push("Age limit is not valid.");
    }

    if(errors.length){
        let errHtml = "";
        for(let e of errors){
            errHtml += e + " ";
        }
        $("#insertMovieForm .errors").html(errHtml);
        return false;
    }else{
        return true;
    }
}

function addMovieActorInsert(){
    let index = $(this).prop('selectedIndex');
    if(index){
        let id = $("#actorsMovIns option:selected").val();
        let name =  $("#actorsMovIns option:selected").text();
        let last = $("#actorsListMovIns").find(".movUpdActGenres").last();
        let write = `<div class=\"movUpdActGenres\"><a href=\"#\" data-id=\"${id}\">${name}</a><span class=\"fa fa-close\"></span>
                    <input type="hidden" class="actorInsertHidden" name="actorInsertHidden[]" value="${id}"/>
                    </div>`;
        if(last.length){
            $(write).insertAfter(last);
        }else{
            write += `<div class='cleaner'></div>`;
            $("#actorsListMovIns").append(write);
        }
    }
}

function addMovieGenreInsert(){
    let index = $(this).prop('selectedIndex');
    if(index){
        let id = $("#genresMovIns option:selected").val();
        let name =  $("#genresMovIns option:selected").text();
        let last = $("#genresListMovIns").find(".movUpdActGenres").last();
        let write = `<div class=\"movUpdActGenres\"><a href=\"#\" data-id=\"${id}\">${name}</a><span class=\"fa fa-close\"></span>
                    <input type="hidden" class="genreInsertHidden" name="genreInsertHidden[]" value="${id}"/>
                    </div>`;
        if(last.length){
            $(write).insertAfter(last);
        }else{
            write += `<div class='cleaner'></div>`;
            $("#genresListMovIns").append(write);
        }

    }
}

function checkMovieUpdate(){
    let name = $("#nameMovUpd").val().trim();
    let running_time = $("#timeMovUpd").val().trim();
    let desc = $("#taShortDesc").val().trim();
    let detailed_desc = $("#taDetailedDesc").val().trim();
    let distributer = $("#distributerMovUpd option:selected").index();
    let director = $("#directorMovUpd option:selected").index();
    let country = $("#countryMovUpd option:selected").index();
    let age_limit = $("#ageMovUpd").val();
    let actors = $("#actorsListMovUpd").find(".movUpdActGenres").length;
    let genres  = $("#genresListMovUpd").find(".movUpdActGenres").length;
    let date = $("#dateMovUpd").val();

    let reTime = /^[\d]{2,3}$/;

    var errors = [];

    if(date == ""){
        errors.push("In cinemas from field is required!");
    }
    if(name==""){
        errors.push("Movie name field is required!");
    }

    if(running_time==""){
        errors.push("Running time field is required!");
    }else if(!reTime.test(running_time)){
        errors.push("Running time is not valid.");
    }

    if(desc === ""){
        errors.push("Description cant't be empty.");
    }

    if(detailed_desc === ""){
        errors.push("Description detailed cant't be empty.");
    }

    if(!distributer){
        errors.push("Choose distributer.");
    }
    if(!director){
        errors.push("Choose director.");
    }
    if(!country){
        errors.push("Choose country.");
    }
    if(!actors){
        errors.push("Choose actors.");
    }
    if(!genres){
        errors.push("Choose genres.");
    }

    if(age_limit==""){
        errors.push("Age limit field is required!");
    }else if(!reTime.test(age_limit)){
        errors.push("Age limit is not valid.");
    }

    if(errors.length){
        let errHtml = "";
        for(let e of errors){
            errHtml += e + " ";
        }
        $("#updateMovieForm .errors").html(errHtml);
        return false;
    }else{
        return true;
    }

}

function addMovieGenre(){//UPDATE MOVIE
    let index = $(this).prop('selectedIndex');
    if(index){
        let id = $("#genresMovUpd option:selected").val();
        let name =  $("#genresMovUpd option:selected").text();
        let last = $("#genresListMovUpd").find(".movUpdActGenres").last();
        let write = `<div class=\"movUpdActGenres\"><a href=\"#\" data-id=\"${id}\">${name}</a><span class=\"fa fa-close\"></span>
                    <input type="hidden" class="genreHidden" name="genreHidden[]" value="${id}"/>
                    </div>`;
        if(last.length){
            $(write).insertAfter(last);
        }else{
            write += `<div class='cleaner'></div>`;
            $("#genresListMovUpd").append(write);
        }

    }
}

function addMovieActor(){
    let index = $(this).prop('selectedIndex');
    if(index){
        let id = $("#actorsMovUpd option:selected").val();
        let name =  $("#actorsMovUpd option:selected").text();
        let last = $("#actorsListMovUpd").find(".movUpdActGenres").last();
        // let count = $("#actorsListMovUpd").find(".movUpdActGenres").length;
        let write = `<div class=\"movUpdActGenres\"><a href=\"#\" data-id=\"${id}\">${name}</a><span class=\"fa fa-close\"></span>
                    <input type="hidden" class="actorHidden" name="actorHidden[]" value="${id}"/>
                    </div>`;
        //id="actorHidden${count}"
        if(last.length){
            $(write).insertAfter(last);
        }else{
            write += `<div class='cleaner'></div>`;
            $("#actorsListMovUpd").append(write);
        }
    }
}

function getMovieData(){
    let id = $(this).data("id");

    $.ajax({
        url: "getMovieData",
        method: "get",
        data: {
           id: id
        },
        success: function (data) {
            console.log(data);
            let movie = data.movie;
            $('#blurBgUpdateMovie').fadeIn();
            $('body').css({'overflow':'hidden'});
            $(document).bind('scroll',function () {
                window.scrollTo(0,0);
            });
            $("#updateMovieForm #movieIdHidden").val(id);
            $("#nameMovUpd").val(movie.movieName);
            $("#timeMovUpd").val(movie.running_time);
            $("#taShortDesc").val(movie.description);
            $("#taDetailedDesc").val(movie.description_detailed);
            $("#distributerMovUpd option[value='" + movie.distributer_id + "']").prop('selected', true);
            $("#directorMovUpd option[value='" + movie.director_id + "']").prop('selected', true);
            let technologies = movie.technologies;
            console.log(technologies);
            if(technologies.length > 1){
                $("#technologiesMovUpd option[value='" + 3 + "']").prop('selected', true);
            }else{
                $("#technologiesMovUpd option[value='" + technologies[0].id + "']").prop('selected', true);
            }
            $("#countryMovUpd option[value='" + movie.country_id + "']").prop('selected', true);
            $("#dateMovUpd").val(movie.in_cinemas_from);
            $("#ageMovUpd").val(movie.age_limit);
            $("#activeSliderMovUpd option[value='" + movie.is_active_slider + "']").prop('selected', true);
            let actors = "";
            for(let a of movie.actors){
                actors += `<div class="movUpdActGenres"><a href="#" data-id="${a.id}">${a.name}</a><span class="fa fa-close"></span>
                            <input type="hidden" class="actorHidden" name="actorHidden[]" value="${a.id}"/>
                            </div>`;
                //id="actorHidden${movie.actors.length}"
            }
            actors += `<div class="cleaner"></div>`;
            $("#actorsListMovUpd").html(actors);
            let genres = "";
            for(let g of movie.genres){
                genres += `<div class="movUpdActGenres"><a href="#" data-id="${g.id}">${g.genre}</a><span class="fa fa-close"></span>
                            <input type="hidden" class="genreHidden" name="genreHidden[]" value="${g.id}"/>
                            </div>`;
                //id="genderHidden${movie.genres.length}"
            }
            genres += `<div class="cleaner"></div>`;
            $("#genresListMovUpd").html(genres);
        },
        error: function (xhr, textStatus, errorThrown) {
        }
    });
}

function printAdminMoviePagination(movies){
    var length = movies.length;
    var i;
    var paginationHtml ="";
    var numOfPagLinks = Math.ceil(length/5);
    console.log(numOfPagLinks);
    for(i = 0; i < numOfPagLinks; i++){
        paginationHtml += `<li>
    <a href="#" class="paginationAdmMov" data-limit="${i}"> ${i+1}</a>
    </li>`;
    }
    $('#adminMovies #pagination').html(paginationHtml);
    document.getElementsByClassName('paginationAdmMov')[0].classList.add('activePagination');
}

function searchMoviesAdm(searched){
    if(searched == ""){
        let limit= 0;
        $.ajax({
            url: "admin/moviesPage/" + 0 + "/" + 0,
            method: "GET",
            dataType: 'json',
            success: function(data){
                printMoviesAdmin(data.movies);
                printAdminMoviePagination(data.movies);
            },
            error: function(error){
                console.log(error);
            }
        });
    }else{
        $.ajax({
            url: "admin/moviesPage/" + 0 + "/" + searched,
            method: "GET",
            dataType: 'json',
            success: function(data){
               // console.log(data.movies);
                printMoviesAdmin(data.movies);
                printAdminMoviePagination(data.movies);
            },
            error: function(error){
                console.log(error);
            }
        });
    }
}

function printMoviesAdmin(movies){
    // console.log(urlPics);
    let html = '';
    for(let m of movies){
        html += `<div class="movieAdmin">
                        <div class="moviePicAdmin movieInfoAdmin">
                            <img src="${global_url}${m.path}${m.picName}" alt="${m.alt}" width="120" height="180"/>
                            <p class="movieDateAdmin">Date aired:`;
        let dateObj = new Date(m.in_cinemas_from);
        let dateArray = formatDate(dateObj);

        html += `<span>${dateArray["day"]}.${dateArray["month"]}.${dateArray["year"]}</span>
                </p>
                <p>`;
        for(let i=0; i< m.genres.length; i++){
            html += `${m.genres[i].genre}`;
            if(m.genres.length-1 != i){
                html += ",";
            }
        }

        html += `| <span class="fa fa-clock-o"></span> ${m.running_time} min
            </p>
        </div>
        <div class="movieNameAdmin movieInfoAdmin">
            <p class="headlineAdmMovie">Movie name</p>
            ${m.movieName}
            <p class="headlineAdmMovie headlineAdmActors">Actors</p>
            <p class="actorsAdmMovie">`;
        for(let i=0; i<m.actors.length; i++){
            if(i === m.actors.length){
                html += `${m.actors[i].name}`;
            }else{
                html += `${m.actors[i].name}, `;
            }
        }

       html += `</p>
    </div>
    <div class="movieRatingAdmin movieInfoAdmin">
        <p class="headlineAdmMovie">Rating</p>
        <p class="numberMovieGrade">${m.grade}</p><ul>`;
        html+= writeStars(m);

        html += `</ul></div>
        <div class="movieDirectorAdmin movieInfoAdmin">
            <p class="headlineAdmMovie">Director</p>
            ${m.dirName}
        </div>
        <div class="movieDescAdmin movieInfoAdmin">
            <p class="headlineAdmMovie">Description</p>
            <p class="admDescP">${m.description}</p>
        </div>
        <div class="movieDirectorAdmin movieInfoAdmin btnsAdminMovies">
            <div><input type="button" value="Update" class="btnUpdateMov" data-id="${m.idMovie}"/></div>
            <div><a href="${global_url}deleteMovie/'${m.idMovie}" data-id="${m.idMovie}" class="btnDeleteMov">Delete</a></div>
        </div>
    </div>`;
    }
    $("#adminMoviesHolder").html(html);
    $(".btnUpdateMov").click(getMovieData);
}
