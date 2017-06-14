<?php
require_once 'functions.php';

$postresult = '';
if (isset($_POST['submit'])) {
    $postresult = handle_post();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>King of the Court</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="functions.js?<?php echo rand(); ?>"></script>
    <script src="script.js?<?php echo rand(); ?>"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-black.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="style.css?<?php echo rand(); ?>">
</head>
<!--<body style="background-color:rgba(0,0,0,0.47);">-->
<body style="background-image:url(background.jpg)">
<!-- Links (sit on top) -->
<!-- Navbar -->
<nav class="navbar navbar-default" role="navigation">
    <div class="navbar-collapse navbar-ex1-collapse">
        <ul class="nav navbar-nav">
            <!-- Notice each of these tab elements points to a certain ID -->
            <li class='active'><a class='open-tab' href="#" data-tab='a'>Setup teams</a></li>
            <li><a class='open-tab' href="#" data-tab='b'>Game</a></li>
        </ul>
    </div>
</nav>
<div id='content'>
    <!-- The data-tab attribute will be used by the tab that is clicked to identify the content to show -->
    <div class='tab' data-tab='a'>
        <div class="w3-col m12" >
            <div class="w3-container w3-center">
                <form id="team-creation-form" method="POST" enctype="multipart/form-data">
                    <?php for ($i = 0; $i < 5; $i++) { ?>
                        <div class="w3-container w3-card-4 w3-white w3-padding-16 w3-margin-left w3-margin-top w3-col m3" id="team<?php echo $i; ?>">
                            Team <?php echo $i + 1; ?> name: <input class="w3-input"  type="text" name="team<?php echo $i; ?>-name" /><br />
                            Team <?php echo $i + 1; ?> picture: <input class="w3-input"  type="file" name="team<?php echo $i; ?>-foto" accept="image/*" /><br />
                            Team <?php echo $i + 1; ?> color: <input class = "w3-color" type="color" name="team<?php echo $i; ?>-color" value="#FFFFFF" /><br />
                        </div>
                    <?php } ?>
                    <input type="submit" name="submit" class="w3-button w3-right w3-theme" value="Save"/>
                </form>
            </div>
        </div>
    </div>
    <div class='tab' data-tab='b' style='display: none'>
        <div class="w3-col m12 w3-padding-32">
            <?php
            if ($postresult !== '' OR isset($_COOKIE['team1-info'])) {
            if($postresult === ''){
                for ($i = 0; $i < 5; $i++) {
                    $c = $_COOKIE["team$i-info"];
                    $expl = explode('--', $c);
                    $info[$i]['name'] = explode('=', $expl[0])[1];
                    $info[$i]['color'] = explode('-', explode('=', $expl[1])[1])[0];
                    $info[$i]['img'] = explode('=', $expl[2])[1];
                }
            }else{
                $info = $postresult;
            }
            ?>
            <div class="w3-col m5">
                <!--<div class="w3-col m6">
                    <div class="w3-container">
                        <div class="w3-card-4 w3-white" id="winnersside" style="width:100%">
                            <img class="order-0" src="<?php echo $info[0]['img']; ?>" alt="Team on winners side" style="width:100%">
                            <div class="w3-container w3-center">
                                <p>Winners' side</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="w3-col m6">
                    <div class="w3-container">
                        <div class="w3-card-4 w3-white" id="challengers" style="width:100%">
                            <img class="order-1" src="<?php echo $info[1]['img']; ?>" alt="Challenging team" style="width:100%">
                            <div class="w3-container w3-center">
                                <p>Challengers</p>
                            </div>
                        </div>
                    </div>
                </div>-->
                <img src="logo.png" alt="logo" style="width:90%;">
                <div class="w3-card-4 w3-margin-left" id="currently-playing" style="width:90%;">
                    <header class="w3-container w3-col m6">
                        <h1 style="color: white">Winners' side</h1>
                    </header>
                    <header class="w3-container w3-col m6">
                        <h1 style="color: white">Challengers</h1>
                    </header>
                    <div class="w3-white">
                        <div class="w3-card w3-white w3-col m6" id="winnersside">
                            <img class="order-0" src="<?php echo $info[0]['img']; ?>" alt="Challenging team" style="width:100%">
                        </div>
                        <div class="w3-card w3-white w3-col m6" id="challengers">
                            <img class="order-1" src="<?php echo $info[1]['img']; ?>" alt="Challenging team" style="width:100%">
                        </div>
                    </div>
                </div>

                <div class="w3-container">
                    <h1 style="color: white">Up next</h1>

                    <div class="w3-col m4">
                        <div class="w3-container">
                            <div class="w3-card-4 w3-white" style="width:90%">
                                <img class="order-2" src="<?php echo $info[2]['img']; ?>" style="width:100%">
                            </div>
                        </div>
                    </div>
                    <div class="w3-col m4">
                        <div class="w3-container">
                            <div class="w3-card-4 w3-white" style="width:90%">
                                <img class="order-3" src="<?php echo $info[3]['img']; ?>" style="width:100%">
                            </div>
                        </div>
                    </div>
                    <div class="w3-col m4">
                        <div class="w3-container">
                            <div class="w3-card-4 w3-white" style="width:90%">
                                <img class="order-4" src="<?php echo $info[4]['img']; ?>" style="width:100%">
                            </div>
                        </div>
                    </div>
                </div>
                <button class="w3-button w3-left w3-theme w3-margin" id="start-round">Start round</button>
            </div>
            <div class="w3-col m7 w3-margin-bottom">
                <div class="w3-card-4" style="width:100%">
                    <header class="w3-container w3-white w3-col m6">
                        <h1 style="font-size: 70px" id="roundnr">Round 1</h1>
                    </header>
                    <header class="w3-container w3-white w3-col m6">
                        <h1 style="font-size: 70px" id="time-left">20:00</h1>
                    </header>
                </div>
            </div>
            <div class="w3-col m7 w3-padding-right">
                <div class="w3-card" id="ranking" style="width:100%;">
                    <header class="w3-container w3-col m10">
                        <h1 style="color: white">Ranking</h1>
                    </header>
                    <header class="w3-container w3-col m2">
                        <h1 style="color: white">Points</h1>
                    </header>
                    <?php
                    for ($i = 0; $i < 5; $i++) {
                        $name = $info[$i][ 'name'];
                        $bgcolor = $info[$i]['color'];
                        $color = calculateTextColor($bgcolor);
                        echo "<div id=\"nr$i\"><h1 style=\"background-color: $bgcolor; color: $color; font-size: 70px\" class=\"w3-col m10\">$name</h1><h1 class=\"w3-col m1\"> </h1><h1 class=\"w3-col m1\" style=\"color:white; font-size: 70px\" >0</h1></div>";
                    }
                    ?>
                </div><br />
                <!--<td id="ranking">
                    <table class="nested-table">
                        <tr><td>Ranking</td><td>Points</td></tr>
                        <?php
                for ($i = 0; $i < 5; $i++) {
                    $name = $info[$i]['name'];
                    $bgcolor = $info[$i]['color'];
                    $color = calculateTextColor($bgcolor);
                    echo "<tr id=\"nr$i\"><td style=\"background-color: $bgcolor; color: $color\">$name</td><td>0</td></tr>";
                }
                ?>
                    </table>
                </td>-->
            </div>
        </div>
        <?php }?>
    </div>
</div>
<script type='text/javascript'>
    $(function(){
        // When an open tab item from your menu is clicked
        $(".open-tab").click(function(){
            // Hide any of the content tabs
            $(".tab").hide();
            // Show your active tab (read from your data attribute)
            $('[data-tab ="' + $(this).data('tab') + '"]').show();
            // Optional: Highlight the selected tab
            $('li.active').removeClass('active');
            $(this).closest('li').addClass('active');
        });
    });
</script>
</body>
</html>