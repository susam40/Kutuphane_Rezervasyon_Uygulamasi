<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header('Location: ../../login.html');
    exit;
}
include_once 'room_controller.php';
include_once 'reservation.php';



function heading(){?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
    <title>Rezervasyon</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/css/welcome.css" />
    </head>
    <body>

    <nav class="navbar navbar-light" style="background-color: black;">
    <div class="container-fluid">
        <ul class="nav navbar-nav">
        <li><a href="reservation_page.php">Anasayfa</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
        <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Çıkış Yap</a></li>
        </ul>
    </div>
    </nav>
<?php
} ?>
<?php
function footer(){ ?>
    <!-- Bootstrap scripts-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
     <!-- scripts for Carousel slider-->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    </body>
    </html>

<?php 
}?>
<?php

function buildReservations(){?>
    <?php
        $reservation = new reservation();
        $reservations = $reservation->listCurrentReservations();
        $format = 'd-m-Y';
    ?>

    <div class="container">
    <h2>Çalışma Odaları İçin Mevcut Rezervasyonlar</h2><br>
    <?php
        for($i = -1; $i < 7; $i++){
            $date = date($format, strtotime("+$i days"));
            $thisDayReservations = array();
            $isNoReservationsToday = true;
            foreach($reservations as $key=>$r){
                if(date($format, strtotime($r->date)) == date($format, strtotime($date))){
                    $thisDayReservations[] = $r;
                    unset($reservations[$key]);
                    $isNoReservationsToday = false;
                }    
            }
            
            if($isNoReservationsToday){?>
                <div class="row">
                    <div class="col-2">
                        <?php echo $date .' '.'için rezervasyonlar' ?>
                    </div><br>
                    <div class="col-10">
                            <table class="table table-bordered table-dark">
                                    <thead >
                                    <tr>
                                        <th scope="col">Oda</th>

                                        <th scope="col">10:00</th>
                                        <th scope="col">11:00</th>
                                        <th scope="col">12:00</th>
                                        <th scope="col">13:00</th>
                                        <th scope="col">14:00</th>
                                        <th scope="col">15:00</th>
                                        <th scope="col">16:00</th>
                                        <th scope="col">17:00</th>
                                        <th scope="col">18:00</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                        <?php
                                        $rc = new RoomController();
                                        $rooms = $rc->read();
                                        foreach($rooms as $room){?>
                                            <tr>
                                                <th scope="row"><?php echo $room->room_number ?></th>
                                                <?php
                                                for($ii = 0; $ii < 10; $ii++){
                                                        $start_time = $ii + 9;
                                                        $start_time_string = $start_time . ':00:00';
                                                        $end_time = $start_time + 1;
                                                        $end_time_string = $end_time . ':00:00';
                                                        $date_string = date('Y-m-d H:i:s', strtotime($date));
                                                        if($i != -1 && $i != 0){
                                                            echo '<td><a href="reserve_room.php?start_time='.$start_time_string.'&end_time='.$end_time_string.'&date='.$date_string.'&room_id='.$room->id.'">Reserve</a></td>';
                                                        }
                                                        else{
                                                            echo '<td>Rezerve Edilmiş</td>';
                                                        }
                                                    }
                                                ?>
                                            </tr>
                                        <?php    
                                        }
                                        ?>

                                    </tbody>
                            </table>
                    </div>
                </div> 
            <?php
            } else {?>
                <div class="row">
                    <div class="col-2">
                       <?php echo $date .' '.'için rezervasyonlar' ?>
                    </div>
                    <div class="col-10">
                            <table class="table table-bordered table-dark">
                                    <thead >
                                    <tr>
                                        <th scope="col">Room</th>
                                        <th scope="col">9:00</th>
                                        <th scope="col">10:00</th>
                                        <th scope="col">11:00</th>
                                        <th scope="col">12:00</th>
                                        <th scope="col">13:00</th>
                                        <th scope="col">14:00</th>
                                        <th scope="col">15:00</th>
                                        <th scope="col">16:00</th>
                                        <th scope="col">17:00</th>
                                        <th scope="col">18:00</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $rc = new RoomController();
                                        $rooms = $rc->read();
                                        foreach($rooms as $room){
                                            $thisRoomReservations = array();
                                            $isNoReservationsThisRoom = true;
                                            foreach($thisDayReservations as $key2=>$tr){
                                                if($tr->room_number == $room->room_number){
                                                    $thisRoomReservations[] = $tr;
                                                    $isNoReservationsThisRoom = false;
                                                    unset($thisDayReservations[$key2]);
                                                }
                                            }
                                            if($isNoReservationsThisRoom){?>
                                                <tr>
                                                <th scope="row"><?php echo $room->room_number; ?></th>
                                                <?php
                                                    for($ii = 0; $ii < 10; $ii++){
                                                        $start_time = $ii + 9;
                                                        $start_time_string = $start_time . ':00:00';
                                                        $end_time = $start_time + 1;
                                                        $end_time_string = $end_time . ':00:00';
                                                        $date_string = date('Y-m-d H:i:s', strtotime($date));
                                                        if($i != -1 && $i != 0){
                                                            echo '<td><a href="reserve_room.php?start_time='.$start_time_string.'&end_time='.$end_time_string.'&date='.$date_string.'&room_id='.$room->id.'">Reserve</a></td>';
                                                        }else{
                                                            echo '<td>Unavailable</td>';
                                                        }
                                                    }
                                            } else{?>
                                                <tr>
                                                <th scope="row"><?php echo $room->room_number; ?></th>
                                                <?php
                                                    $adaptedReservationArray = array();
                                                    foreach($thisRoomReservations as $rr){
                                                        foreach($rr->getReservationTimeArrayAsInteger() as $index){
                                                            $adaptedReservationArray[$index] = $rr;
                                                        }
                                                    }
                                                    ksort($adaptedReservationArray);
                                                    for($ii=0; $ii < 10; $ii++){
                                                        if(isset($adaptedReservationArray[$ii])){
                                                            $name = $adaptedReservationArray[$ii]->stud_name;
                                                            echo "<td>$name</td>";
                                                        }else{
                                                            $start_time = $ii + 9;
                                                            $start_time_string = $start_time . ':00:00';
                                                            $end_time = $start_time + 1;
                                                            $end_time_string = $end_time . ':00:00';
                                                            $date_string = date('Y-m-d H:i:s', strtotime($date));
                                                            if($i != -1 && $i != 0){
                                                                echo '<td><a href="reserve_room.php?start_time='.$start_time_string.'&end_time='.$end_time_string.'&date='.$date_string.'&room_id='.$room->id.'">Reserve</a></td>';
                                                            }
                                                            else{
                                                                echo '<td>Unavailable</td>';
                                                            }
                                                        }
                                                    }
                                                ?>
                                                </tr>
                                            <?php        
                                            }    
                                        }
                                        ?>
                                    </tbody>
                            </table>
                    </div>
                </div>
            <?php
            }
            ?>
            
        <?php                        
        }
    ?>
    </div>
<?php
}?>

<?php

heading();
buildReservations();
footer();



?>