<?php
    print("<h3>Odznaki</h3>");
    $badges = array_slice(scandir("../badges"),2);

    foreach($badges as $badge_path) {

        print("<img src='../img/badges/".$badge_path."'>");
    }
?>