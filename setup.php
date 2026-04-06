<?php
    function install() {
        global $pdo;
        echo("[INFO] Plugin installation...");
        
        ### MySQL database setup ###

        try {
            $db_query = $pdo->prepare('CREATE TABLE PLUGIN_GAMIFICATION_BADGES
            (
                `BADGE_ID` int(11) NOT NULL,
                `badge_name` int(11) NOT NULL,
                `badge_path` text NOT NULL
            );');
            $db_query->execute();

            $db_query = $pdo->prepare('CREATE TABLE PLUGIN_GAMIFICATION_ACHIEVEMENTS
            (
                `ID` int(11) NOT NULL,
                `user_id` int(11) NOT NULL,
                `badge_id` int(11) NOT NULL
            );');
            $db_query->execute();

            $db_query = $pdo->prepare('ALTER TABLE `PLUGIN_GAMIFICATION_BADGES`
            ADD PRIMARY KEY (`BADGE_ID`);');
            $db_query->execute();

            $db_query = $pdo->prepare('ALTER TABLE `PLUGIN_GAMIFICATION_ACHIEVEMENTS`
            ADD PRIMARY KEY (`ID`);');
            $db_query->execute();

            $db_query = $pdo->prepare('ALTER TABLE `PLUGIN_GAMIFICATION_BADGES`
            MODIFY `BADGE_ID` int(11) NOT NULL AUTO_INCREMENT;');
            $db_query->execute();

            $db_query = $pdo->prepare('ALTER TABLE `PLUGIN_GAMIFICATION_ACHIEVEMENTS`
            MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;');
            $db_query->execute();

            $db_query = $pdo->prepare('ALTER TABLE `PLUGIN_GAMIFICATION_ACHIEVEMENTS`
            ADD CONSTRAINT `user_id` FOREIGN KEY (`user_id`) REFERENCES `USERS` (`USER_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
            ADD CONSTRAINT `badge_id` FOREIGN KEY (`badge_id`) REFERENCES `PLUGIN_GAMIFICATION_BADGES` (`BADGE_ID`) ON DELETE CASCADE ON UPDATE CASCADE;');
            $db_query->execute();

        } catch (Exception $e) {
            print($e);
            return False;
        }

        ### Add plugin's status to proper table ###
        $db_query = $pdo->prepare('INSERT INTO PLUGINS (plugin_name, value_category, value) VALUES ("gamification", "installed", "true")');
        $db_query->execute();

        ### Setup of badges' imgs public directory ###
        copy_directory(__DIR__."/badges", __DIR__."/../img/badges");

        ### Installation finished ###
        return True;
    }

    function uninstall() {
        global $pdo;
        
        try {
            $db_query = $pdo->prepare('DROP TABLE `PLUGIN_GAMIFICATION_ACHIEVEMENTS`;');
            $db_query->execute();
            $db_query = $pdo->prepare('DROP TABLE `PLUGIN_GAMIFICATION_BADGES`;');
            $db_query->execute();
            $db_query = $pdo->prepare('DELETE FROM PLUGINS WHERE plugin_name="gamification"');
            $db_query->execute();
        } catch (Exception $e) {
            print($e);
            return False;
        }
        return True;
    }
?>