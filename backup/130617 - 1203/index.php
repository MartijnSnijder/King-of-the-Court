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
        <link rel="stylesheet" type="text/css" href="style.css?<?php echo rand(); ?>">
    </head>
    <body>
        <h1>Welcome to King of the Court!</h1>
        <div id="setup">
            <button id="create-game">Maak een nieuw spel aan</button>
            <button id="start-game">Start een spel</button><br />
        </div>
        <div id="creation">
            <form id="team-creation-form" method="POST" enctype="multipart/form-data">
                <?php for ($i = 0; $i < 5; $i++) { ?>
                    <br /><div id="team<?php echo $i; ?>">
                        Team <?php echo $i + 1; ?> naam: <input type="text" name="team<?php echo $i; ?>-name" /><br />
                        Team <?php echo $i + 1; ?> foto: <input type="file" name="team<?php echo $i; ?>-foto" accept="image/*" /><br />
                        Team <?php echo $i + 1; ?> kleur: <input type="color" name="team<?php echo $i; ?>-color" value="#FFFFFF" /><br />
                    </div>
                <?php } ?>
                <input type="submit" name="submit" value="Opslaan"/>
            </form>
            Herlaad de pagina als de gegevens niet correct updaten
        </div>
        <div id="in-game">
            <?php
            if (isset($_COOKIE['team1-info'])) {
                for ($i = 0; $i < 5; $i++) {
                    $c = $_COOKIE["team$i-info"];
                    $expl = explode('--', $c);
                    $info[$i]['name'] = explode('=', $expl[0])[1];
                    $info[$i]['color'] = explode('-', explode('=', $expl[1])[1])[0];
                    $info[$i]['img'] = explode('=', $expl[2])[1];
                }
                ?>
                <br />
                <button id="start-round">Start de ronde</button>
                <br />
                <div id="round-info">
                    <h1 id="roundnr">Round 1</h3><br />
                        <span id="time-left">20:00</span>
                </div>

                <div>
                    <table class="master-table" id="master-table">
                        <tr>
                            <td id="currently-playing">
                                <table class="nested-table">
                                    <tr><th>WINNERS SIDE</th></tr>
                                    <tr>
                                        <td class="order-0" id="winnersside"><img class="big-img order-0" src="<?php echo $info[0]['img']; ?>" /></td>
                                    </tr>
                                    <tr>
                                        <td class="order-1" id="challengers"><img class="big-img order-1" src="<?php echo $info[1]['img']; ?>" /></td>
                                    </tr>
                                    <tr><th>CHALLENGERS</th></tr>
                                </table>
                            </td>
                            <td id="up-next">
                                <table class="nested-table">
                                    <tr><th>UP NEXT</th></tr>
                                    <tr>
                                        <td class="order-2"><img class="small-img order-2" src="<?php echo $info[2]['img']; ?>" /></td>
                                    </tr>
                                    <tr>
                                        <td class="order-3"><img class="small-img order-3" src="<?php echo $info[3]['img']; ?>" /></td>
                                    </tr>
                                    <tr>
                                        <td class="order-4"><img class="small-img order-4" src="<?php echo $info[4]['img']; ?>" /></td>
                                    </tr>
                                </table>
                            </td>
                            <td id="ranking">
                                <table class="nested-table">
                                    <tr><td>RANKING</td><td>POINTS</td></tr>
                                    <?php
                                    for ($i = 0; $i < 5; $i++) {
                                        $name = $info[$i]['name'];
                                        $bgcolor = $info[$i]['color'];
                                        $color = calculateTextColor($bgcolor);
                                        echo "<tr id=\"nr$i\"><td style=\"background-color: $bgcolor; color: $color\">$name</td><td>0</td></tr>";
                                    }
                                    ?>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>
            <?php }?>
        </div>
    </body>
</html>