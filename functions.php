<?php

function handle_post() {
    $ret = '';
    $target_dir = "teamimages/";
    $fileindex = json_decode(file_get_contents("$target_dir/fileindex.json"), TRUE);

    for ($i = 0; $i < 5; $i++) {
        $ret[$i]["name"] = ($_POST["team$i-name"] == '') ? "team ".($i+1) : $_POST["team$i-name"];
        $ret[$i]["color"] = ($_POST["team$i-color"] == '') ? "#FFFFFF" : $_POST["team$i-color"];

        $uploadOk = TRUE;
        $ret[$i]['foto'] = &$uploadOk;
        $target_file = $target_dir . time() . "-team$i." . pathinfo($_FILES["team$i-foto"]["name"], PATHINFO_EXTENSION);

        if (@getimagesize($_FILES["team$i-foto"]["tmp_name"]) === FALSE) {
            $uploadOk = FALSE; //not an img
        }
        else {
            if (move_uploaded_file($_FILES["team$i-foto"]["tmp_name"], $target_file) === FALSE) {
                $uploadOk = FALSE;
            }
        }

        if ($uploadOk === FALSE) {
            $ret[$i]["img"] = "$target_dir" . $fileindex['default']["team$i"];
        }
        else {
            $ret[$i]["img"] = $target_file;
        }
        setcookie("team$i-info", "name=" . $ret[$i]['name'] . "--color=" . $ret[$i]['color'] . "-" . calculateTextColor($ret[$i]['color']) . "--img=" . $ret[$i]['img']);
    }

    return $ret;
}

function calculateTextColor($color) {
    $c = str_replace('#', '', $color);
    $rgb[0] = hexdec(substr($c, 0, 2));
    $rgb[1] = hexdec(substr($c, 2, 2));
    $rgb[2] = hexdec(substr($c, 4, 2));
    if ($rgb[0] + $rgb[1] + $rgb[2] < 382) {
        return '#FFFFFF';
    }
    else {
        return '#000000';
    }
}
?>