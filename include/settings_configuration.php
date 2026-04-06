<?php
    print("<h3>Odznaki</h3>");
    $badges = array_slice(scandir(__DIR__."/../badges"),2);

    echo('<div id="gamification_settings_badges" style="display: flex; gap: 1vmax; justify-content: center; width: 100%;">');
    foreach($badges as $badge_path) {

        print("<img src='../img/plugins/gamification/badges/".$badge_path."' style='height: 3vmax;'>");
    }
    echo('</div>');
?>