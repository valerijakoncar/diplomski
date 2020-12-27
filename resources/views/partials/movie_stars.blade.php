<ul>
    <?php
    $gradeNumber = intval($movie->grade);
    $firstDecimal = intval(substr($movie->grade,2,1));
//    dd($firstDecimal);
    for($i=0;$i<$gradeNumber;$i++){
    ?>
    <li><span class="fa fa-star"></span></li>
    <?php
    }
    if(($firstDecimal != 0) && ($firstDecimal >= 3)){
    if($firstDecimal <= 7){
    $i++;
    ?>
    <li><span class="fa fa-star-half-o"></span></li>
    <?php
    }else{
    $i++;
    ?>
    <li><span class="fa fa-star"></span></li>
    <?php
    }
    }
    for($i;$i < 10; $i++){
    ?>
    <li><span class="fa fa-star-o"></span></li>
    <?php
    }
    ?>
</ul>
