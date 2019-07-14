<?php
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

try {
    $SQLServer = "localhost";
    $DBName = "xxxxxxxxxx";
    $DBUser = "xxxxxxxxxx";
    $DBPass = "xxxxxxxxxx";
    $mysqli = new mysqli($SQLServer, $DBUser, $DBPass, $DBName);
    $pdo = new PDO("mysql:host=".$SQLServer.";dbname=".$DBName, $DBUser, $DBPass);
    
    function SendPushNotificationAndroid($deviceToken, $message, $title) {
        $apiKey = "xxxxxxxxxx";
        $url = 'https://android.googleapis.com/gcm/send';
        $fields = array('registration_ids' => array($deviceToken), 'data' => array("message" => $message, "title" => $title),);
        $headers = array('Authorization: key='.$apiKey, 'Content-Type: application/json');
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        curl_close($ch);
        echo $result."\n";
    }
    function SendPushNotificationAndroidFCM($deviceToken, $message) {
        $apiKey = "xxxxxxxxxx";
        $url = "https://fcm.googleapis.com/fcm/send";
        $fields = array("to" => $deviceToken, "notification" => array("body" => $message),);
        $headers = array("Authorization: key=".$apiKey, "Content-Type: application/json");
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        curl_close($ch);
        echo $result;
    }
    function SendPushNotificationiOS($deviceToken, $message) {
        $cert = "xxxxxxxxxx";
        $ctx = stream_context_create();
        stream_context_set_option($ctx, 'ssl', 'local_cert', $cert);
        stream_context_set_option($ctx, 'ssl', 'passphrase', 'xxxxxxxxxx');
        $fp = stream_socket_client('ssl://gateway.push.apple.com:2195', $err, $errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);
        if (!$fp) {
            echo "Failed to connect: $err $errstr";
            return;
        }
        $body['aps'] = array('alert' => $message);
        $payload = json_encode($body);
        $msg = chr(0).pack('n', 32).pack('H*', $deviceToken).pack('n', strlen($payload)).$payload;
        $result = fwrite($fp, $msg, strlen($msg));
        fclose($fp);
    }
    
    $noOfLocksModified = 0;
    
    // PICK FROM 99 TO 499 LOCKEES TO UPDATE. NUMBERS ARE THIS LOW TO REDUCE THE RUN TIME
    $sqlLimit = rand(99, 499);
    $query = $pdo->prepare("select * from Locks_V2 where (bot_chosen > 0 or shared_id = 'S2Y5CZ848P75X26' or shared_id = '258V78632ZHKQ2F' or shared_id = 'V83KZYUL9359329') and unlocked = 0 and deleted = 0 order by rand() limit ".$sqlLimit);
    $query->execute();
    if ($query->rowCount() > 0) {
        foreach ($query as $row) {
            $lockID = $row["id"];
            $botChosen = $row["bot_chosen"];
            $userID = $row["user_id"];
            $fixed = $row["fixed"];
            $timestampLocked = $row["timestamp_locked"];
            $timestampNow = time();
            $regularity = $row["regularity"];
            $cardInfoHidden = $row["card_info_hidden"];
            $cardInfoHiddenModifiedBy = 0;
            $noOfReds = $row["red_cards"];
            $timestampLastReset = $row["timestamp_last_reset"];
            $unit = 3600 * $regularity;
            // IF FIXED LOCK AND FINISHED, DO NOT UPDATE
            if ($fixed == 1 && ($timestampNow - $timestampLocked >= $unit * $noOfReds)) {
                continue;
            }
            $timerHidden = $row["timer_hidden"];
            $timerHiddenModifiedBy = 0;
            $redCardsModifiedBy = 0;
            $yellowCardsModifiedBy = 0;
            $unlocked = $row["unlocked"];
            $timestampUnlocked = $row["timestamp_unlocked"];
            $dateUnlocked = $row["date_unlocked"];
            $userEmoji = $row["user_emoji"];
            $keyholderEmoji = $row["keyholder_emoji"];
            $build = $row["build"];
            $emoji = array();
            // THESE EMOJI REACTIONS WERE BASED ON THE REACTIONS BETWEEN REAL LOCKEES AND KEYHOLDERS
            // NOT THE BEST WAY TO DO IT. AND IT HASN'T BEEN UPDATED IN ABOUT A YEAR OR SO
            if ($userEmoji == 0) { array_push($emoji, 0, 1, 4, 5); }
            if ($userEmoji == 1) { array_push($emoji, 0, 0, 1, 2, 3, 4, 5, 6, 7, 9); }
            if ($userEmoji == 2) { array_push($emoji, 0, 1, 5, 6, 7, 8); }
            if ($userEmoji == 3) { array_push($emoji, 0, 1, 5); }
            if ($userEmoji == 4) { array_push($emoji, 0, 1, 5, 6); }
            if ($userEmoji == 5) { array_push($emoji, 0, 0, 1, 2, 3, 4, 5, 6); }
            if ($userEmoji == 6) { array_push($emoji, 0, 0, 1, 2, 4, 5, 6, 7, 9); }
            if ($userEmoji == 7) { array_push($emoji, 0, 0, 1, 2, 3, 5, 6, 8); }
            if ($userEmoji == 8) { array_push($emoji, 0, 2, 3, 7); }
            if ($userEmoji == 9) { array_push($emoji, 0, 0, 1, 3, 4, 5, 7, 9); }
            if ($userEmoji == 10) { array_push($emoji, 0, 5, 6); }
            if ($userEmoji == 11) { array_push($emoji, 0, 5, 6); }
            if ($userEmoji == 12) { array_push($emoji, 0, 1, 7, 8); }
            if ($userEmoji == 13) { array_push($emoji, 0, 2, 5, 6, 7); }
            if ($userEmoji == 14) { array_push($emoji, 0, 1, 7, 8); }
            if ($userEmoji == 15) { array_push($emoji, 0, 5, 7); }
            if ($userEmoji == 16) { array_push($emoji, 0, 5, 7, 9); }
            if ($userEmoji == 17) { array_push($emoji, 0, 3, 5, 7); }
            if ($userEmoji == 18) { array_push($emoji, 0, 3, 5, 7); }
            if ($userEmoji == 19) { array_push($emoji, 0, 6); }
            if ($userEmoji == 20) { array_push($emoji, 0, 7); }
            if ($userEmoji == 21) { array_push($emoji, 0, 7, 24); }
            if ($userEmoji == 22) { array_push($emoji, 0, 0, 5, 6, 7, 8, 9, 24); }
            if ($userEmoji == 23) { array_push($emoji, 0, 4, 6); }
            if ($userEmoji == 24) { array_push($emoji, 0, 2, 3, 6, 9); }
            if ($userEmoji == 25) { array_push($emoji, 0, 1, 2, 3, 4, 5); }
            $newKeyholderEmoji = $emoji[mt_rand(0, count($emoji) - 1)];
            if ($botChosen == 1) { $sharedID = "BOT01"; }
            if ($botChosen == 2) { $sharedID = "BOT02"; }
            if ($botChosen == 3) { $sharedID = "BOT03"; }
            if ($botChosen == 4) { $sharedID = "BOT04"; }
            if ($row["shared_id"] == "S2Y5CZ848P75X26") { // YELLOW PIG DAY (CUSTOM BOT LOCK FROM ZOE)
                $botChosen = 3;
                $sharedID = "S2Y5CZ848P75X26";
            }
            if ($row["shared_id"] == "258V78632ZHKQ2F") { // SELF BONDAGE LOCK (CUSTOM BOT LOCK FROM CHASE)
                $botChosen = 4;
                $sharedID = "258V78632ZHKQ2F";
            }
            if ($row["shared_id"] == "V83KZYUL9359329") { // SELF BONDAGE LOCK V2 (CUSTOM BOT LOCK FROM CHASE)
                $botChosen = 4;
                $sharedID = "V83KZYUL9359329";
                if ($cardInfoHidden == 0) {
                    $cardInfoHidden = 1;
                    $cardInfoHiddenModifiedBy = 1;
                }
            }
            // 25% CHANCE OF ANY UPDATE BEING MADE
            if (rand(1, 100) <= 25) {
                $noOfYellows = $row["yellow_cards"];
                $initialRedCards = $row["initial_red_cards"];
                $timestampExpectedUnlock = $timestampLocked + ($unit * $initialRedCards);
                if ($botChosen == 1 || $botChosen == 2) {
                    $minReds = $initialRedCards - floor(($initialRedCards / 100.0) * 20.0);
                    $maxReds = $initialRedCards + ceil(($initialRedCards / 100.0) * 35.0);
                } elseif ($botChosen == 3 || $botChosen == 4) {
                    $minReds = $initialRedCards - floor(($initialRedCards / 100.0) * 48.0);
                    $maxReds = $initialRedCards + ceil(($initialRedCards / 100.0) * 80.0);
                }
                // CALCULATE TIMESTAMP TO UNLOCK. ON A CUSTOM LOCK THESE ARE ADJUSTED SO THEY DON'T UNLOCK TOO EARLY.
                if ($sharedID == "258V78632ZHKQ2F" || $sharedID == "V83KZYUL9359329") {  // SELF BONDAGE LOCK (CUSTOM BOT LOCK FROM CHASE) || SELF BONDAGE LOCK V2 (CUSTOM BOT LOCK FROM CHASE)
                    if ($timestampLastReset > 0) {
                        $timestampToUnlock = rand($timestampLastReset + ($unit * ($minReds + 1)), $timestampLastReset + ($unit * ($maxReds + 3)));
                    } else {
                        $timestampToUnlock = rand($timestampLocked + ($unit * ($minReds + 1)), $timestampLocked + ($unit * ($maxReds + 3)));
                    }
                } elseif ($shareID == "S2Y5CZ848P75X26") { // YELLOW PIG DAY (CUSTOM BOT LOCK)
                    if ($timestampLastReset > 0) {
                        $timestampToUnlock = rand($timestampLastReset + ($unit * ($minReds + 24)), $timestampLastReset + ($unit * ($maxReds + 48)));
                    } else {
                        $timestampToUnlock = rand($timestampLocked + ($unit * ($minReds + 24)), $timestampLocked + ($unit * ($maxReds + 48)));
                    }
                } else {
                    if ($timestampLastReset > 0) {
                        $timestampToUnlock = rand($timestampLastReset + ($unit * $minReds), $timestampLastReset + ($unit * $maxReds));
                    } else {
                        $timestampToUnlock = rand($timestampLocked + ($unit * $minReds), $timestampLocked + ($unit * $maxReds));
                    }    
                }
                if ($timestampNow >= $timestampToUnlock) { // IF TIMESTAMP NOW IS GREATER THAN THE CALCULATED TIMESTAMP TO UNLOCK THEN TRIGGER AN UNLOCK.
                    $unlocked = 1;
                    $timestampUnlocked = time();
                    $dateUnlocked = date("d/m/Y");
                } else {
                    if ($botChosen == 1 || $botChosen == 2) { // IF HAILEY OR BLAINE
                        if (rand(1, 100) <= 40) { // 40% CHANCE OF REMOVING RED CARDS OR TIME (FIXED LOCKS USE THE SAME RED CARD VARIABLES IN THE DATABASE)
                            $redCardsUsed = ceil($timestampNow - $timestampLocked) / $unit;
                            $redCardsLeft = $noOfReds - $redCardsUsed;
                            $cards = array();
                            // ONLY ADD A CHANCE TO REMOVE A NUMBER OF RED CARDS IF THERE'S ENOUGH RED CARDS TO REMOVE
                            if ($redCardsLeft > 2) { array_push($cards, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1); }
                            if ($redCardsLeft > 3) { array_push($cards, -2, -2, -2, -2, -2, -2, -2, -2, -2, -2, -2, -2, -2, -2, -2, -2, -2, -2); }
                            if ($redCardsLeft > 4) { array_push($cards, -3, -3, -3, -3, -3, -3, -3, -3, -3, -3, -3, -3, -3, -3, -3, -3); }
                            if ($redCardsLeft > 5) { array_push($cards, -4, -4, -4, -4, -4, -4, -4, -4, -4, -4, -4, -4, -4, -4); }
                            if ($redCardsLeft > 6) { array_push($cards, -5, -5, -5, -5, -5, -5, -5, -5, -5, -5, -5, -5); }
                            if ($redCardsLeft > 7) { array_push($cards, -6, -6, -6, -6, -6, -6, -6, -6, -6, -6); }
                            if ($redCardsLeft > 8) { array_push($cards, -7, -7, -7, -7, -7, -7, -7, -7); }
                            if (count($cards) > 0) { 
                                $randomCard = $cards[mt_rand(0, count($cards) - 1)]; // STILL A POSSIBILITY THAT NO CARDS ARE ADDED BECAUSE OF THE ZERO IN THE RANDOM RANGE
                                $redCardsModifiedBy = $randomCard;
                            }
                        } else { // 60% CHANCE OF ADDING RED CARDS OR TIME (FIXED LOCKS USE THE SAME RED CARD VARIABLES IN THE DATABASE)
                            $cards = array();
                            array_push($cards, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
                            array_push($cards, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2);
                            array_push($cards, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3);
                            array_push($cards, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4);
                            array_push($cards, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5);
                            array_push($cards, 6, 6, 6, 6, 6, 6, 6, 6, 6, 6);
                            array_push($cards, 7, 7, 7, 7, 7, 7, 7, 7);
                            $randomCard = $cards[mt_rand(0, count($cards) - 1)]; // STILL A POSSIBILITY THAT NO CARDS ARE ADDED BECAUSE OF THE ZERO IN THE RANDOM RANGE
                            $redCardsModifiedBy = $randomCard;
                        }
                        if ($fixed == 0) { // IF VARIABLE LOCK (CARDS SYSTEM)
                            if (rand(1, 100) <= 33) { // 33% CHANCE OF ADDING YELLOW CARDS
                                if (rand(1, 100) <= 40) { // 40% CHANCE OF ADDING YELLOWS THAT REMOVE REDS
                                    $cards = array();
                                    // ONLY ADD A CHANCE TO ADD YELLOW CARDS THAT REMOVE REDS IF THERE'S ENOUGH REDS TO REMOVE
                                    if ($noOfReds > 2) { array_push($cards, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1); }
                                    if ($noOfReds > 3) { array_push($cards, -2, -2, -2, -2, -2, -2, -2, -2, -2, -2, -2, -2, -2, -2, -2, -2, -2, -2); }
                                    if ($noOfReds > 4) { array_push($cards, -3, -3, -3, -3, -3, -3, -3, -3, -3, -3, -3, -3, -3, -3, -3, -3); }
                                    if (count($cards) > 0) { 
                                        $randomCard = $cards[mt_rand(0, count($cards) - 1)]; // STILL A POSSIBILITY THAT NO CARDS ARE ADDED BECAUSE OF THE ZERO IN THE RANDOM RANGE
                                        $yellowCardsModifiedBy = $randomCard;
                                    }
                                } else { // 60% CHANCE OF ADDING YELLOWS THAT ADD RED CARDS
                                    $cards = array();
                                    array_push($cards, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
                                    array_push($cards, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2);
                                    array_push($cards, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3);
                                    $randomCard = $cards[mt_rand(0, count($cards) - 1)]; // STILL A POSSIBILITY THAT NO CARDS ARE ADDED BECAUSE OF THE ZERO IN THE RANDOM RANGE
                                    $yellowCardsModifiedBy = $randomCard;
                                }
                            }
                        }
                    }
                    if ($botChosen == 3 || $botChosen == 4) { // IF ZOE OR CHASE
                        if (rand(1, 100) <= 25) { // 25% CHANCE OF REMOVING RED CARDS OR TIME (FIXED LOCKS USE THE SAME RED CARD VARIABLES IN THE DATABASE)
                            $redCardsUsed = ceil($timestampNow - $timestampLocked) / $unit;
                            $redCardsLeft = $noOfReds - $redCardsUsed;
                            $cards = array();
                            // ONLY ADD A CHANCE TO REMOVE A NUMBER OF RED CARDS IF THERE'S ENOUGH RED CARDS TO REMOVE
                            if ($redCardsLeft > 2) { array_push($cards, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1); }
                            if ($redCardsLeft > 3) { array_push($cards, -2, -2, -2, -2, -2, -2, -2, -2, -2, -2, -2, -2, -2, -2, -2, -2, -2, -2); }
                            if ($redCardsLeft > 4) { array_push($cards, -3, -3, -3, -3, -3, -3, -3, -3, -3, -3, -3, -3, -3, -3, -3); }
                            if ($redCardsLeft > 5) { array_push($cards, -4, -4, -4, -4, -4, -4, -4, -4, -4, -4, -4, -4); }
                            if (count($cards) > 0) { 
                                $randomCard = $cards[mt_rand(0, count($cards) - 1)]; // STILL A POSSIBILITY THAT NO CARDS ARE ADDED BECAUSE OF THE ZERO IN THE RANDOM RANGE
                                $redCardsModifiedBy = $randomCard;
                            }
                        } else { // 75% CHANCE OF ADDING RED CARDS OR TIME (FIXED LOCKS USE THE SAME RED CARD VARIABLES IN THE DATABASE)
                            $cards = array();
                            array_push($cards, 1, 1, 1);
                            array_push($cards, 2, 2, 2, 2, 2, 2);
                            array_push($cards, 3, 3, 3, 3, 3, 3, 3, 3, 3);
                            array_push($cards, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4);
                            array_push($cards, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5);
                            array_push($cards, 6, 6, 6, 6, 6, 6, 6, 6, 6, 6, 6, 6, 6, 6, 6, 6, 6, 6);
                            array_push($cards, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7);
                            $randomCard = $cards[mt_rand(0, count($cards) - 1)]; // STILL A POSSIBILITY THAT NO CARDS ARE ADDED BECAUSE OF THE ZERO IN THE RANDOM RANGE
                            $redCardsModifiedBy = $randomCard;
                        }
                        if ($fixed == 0) { // IF VARIABLE LOCK (CARDS SYSTEM)
                            if (rand(1, 100) <= 33) { // 33% CHANCE OF ADDING YELLOW CARDS
                                if (rand(1, 100) <= 25) { // 25% CHANCE OF ADDING YELLOW CARDS THAT REMOVE REDS
                                    $cards = array();
                                    // ONLY ADD A CHANCE TO ADD YELLOW CARDS THAT REMOVE REDS IF THERE'S ENOUGH REDS TO REMOVE
                                    if ($noOfReds > 2) { array_push($cards, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1); }
                                    if ($noOfReds > 3) { array_push($cards, -2, -2, -2, -2, -2, -2, -2, -2, -2, -2, -2, -2, -2, -2, -2, -2, -2, -2); }
                                    if ($noOfReds > 4) { array_push($cards, -3, -3, -3, -3, -3, -3, -3, -3, -3, -3, -3, -3, -3, -3, -3); }
                                    if (count($cards) > 0) { 
                                        $randomCard = $cards[mt_rand(0, count($cards) - 1)]; // STILL A POSSIBILITY THAT NO CARDS ARE ADDED BECAUSE OF THE ZERO IN THE RANDOM RANGE
                                        $yellowCardsModifiedBy = $randomCard;
                                    }
                                } else { // 75% CHANCE OF ADDING YELLOW CARDS THAT ADD REDS
                                    $cards = array();
                                    array_push($cards, 1, 1, 1);
                                    array_push($cards, 2, 2, 2, 2, 2, 2);
                                    array_push($cards, 3, 3, 3, 3, 3, 3, 3, 3, 3);
                                    $randomCard = $cards[mt_rand(0, count($cards) - 1)]; // STILL A POSSIBILITY THAT NO CARDS ARE ADDED BECAUSE OF THE ZERO IN THE RANDOM RANGE
                                    $yellowCardsModifiedBy = $randomCard;
                                }
                            }
                        }
                    }
                }
            }
            // ONLY MODIFY THEIR LOCK IF THEY HAVEN'T ALREADY HAD THEIR LOCK MODIFIED RECENTLY.
            $timestampModified = $timestampNow - ($unit * rand(1, floor(($noOfReds / 100) * 20) + 3));
            $query2 = $pdo->prepare("select * from ModifiedLocks_V2 where user_id = :userID and shared_id = :sharedID and lock_id = :lockID and timestamp_modified > :timestampModified");
            $query2->execute(array('userID' => $userID, 'sharedID' => $sharedID, 'lockID' => $lockID, 'timestampModified' => $timestampModified));
            if ($query2->rowCount() == 0) { 
                $yellowCards = array();
                // IF THE ABOVE CODE ADDED/REMOVED RED CARDS (OR TIME), YELLOW CARDS, CARD INFO HIDDEN/SHOWN, TIMER HIDDEN, OR UNLOCKED
                if ($redCardsModifiedBy != 0 || $yellowCardsModifiedBy != 0 || $cardInfoHiddenModifiedBy != 0 || $timerHiddenModifiedBy != 0 || $unlocked == 1) {
                    // QUERY THE DATABASE FOR THE LOCKEES INFORMATION AND DATA FROM THEIR LOCK THAT'S BEING MODIFIED
                    // NOT 100% SURE WHY I'M QUERYING THE LOCK RECORD AGAIN
                    $query2 = $pdo->prepare("select u.id, u.user_id as u_user_id, u.platform as u_platform, u.status as u_status, u.push_notifications_disabled as u_push_notifications_disabled, u.token as u_token, u.build_number_installed as u_build_number_installed, l.id, l.user_id, l.shared_id, l.no_of_add_1_cards as l_no_of_add_1_cards, l.no_of_add_2_cards as l_no_of_add_2_cards, l.no_of_add_3_cards as l_no_of_add_3_cards, l.no_of_minus_1_cards as l_no_of_minus_1_cards, l.no_of_minus_2_cards as l_no_of_minus_2_cards, l.timer_hidden as l_timer_hidden from UserIDs_V2 as u, Locks_V2 as l where l.id = :lockID and l.user_id = u.user_id and u.user_id = :userID");
                    $query2->execute(array('lockID' => $lockID, 'userID' => $userID));
                    if ($query2->rowCount() == 1) {
                        $noOfLocksModified++;
                        foreach ($query2 as $row2) {
                            $lockedUserID = $row2["u_user_id"];
                            $lockedUserPlatform = $row2["u_platform"];
                            $lockedUserStatus = $row2["u_status"];
                            $lockedUserPushNotificationsDisabled = $row2["u_push_notifications_disabled"];
                            $lockedUserToken = $row2["u_token"];
                            $lockedUserBuildNumberInstalled = $row2["u_build_number_installed"];
                            $noOfAdd1Cards = $row2["l_no_of_add_1_cards"];
                            $noOfAdd2Cards = $row2["l_no_of_add_2_cards"];
                            $noOfAdd3Cards = $row2["l_no_of_add_3_cards"];
                            $noOfMinus1Cards = $row2["l_no_of_minus_1_cards"];
                            $noOfMinus2Cards = $row2["l_no_of_minus_2_cards"];
                            $lockedTimerHidden = $row2["l_timer_hidden"];
                            // I CAN'T REMEMBER THE REASON FOR THIS FOR LOOP BLOCK OF CODE :(
                            for ($i = 1; $i <= 3; $i++) {
                                if ($noOfAdd1Cards >= $i) { array_push($yellowCards, 1); }
                                if ($noOfAdd2Cards >= $i) { array_push($yellowCards, 2); }
                                if ($noOfAdd3Cards >= $i) { array_push($yellowCards, 3); }
                                if ($noOfMinus1Cards >= $i) { array_push($yellowCards, 4); }
                                if ($noOfMinus2Cards >= $i) { array_push($yellowCards, 5); }
                            }
                        }
                        $noOfAdd1Cards = 0;
                        $noOfAdd2Cards = 0;
                        $noOfAdd3Cards = 0;
                        $noOfMinus1Cards = 0;
                        $noOfMinus2Cards = 0;
                        $noOfYellows = $yellowCardsModifiedBy;
                        if ($noOfYellows < 0) {
                            for ($i = 1; $i <= abs($noOfYellows); $i++) {
                                shuffle($yellowCards);
                                $randomYellow = array_pop($yellowCards);
                                if ($randomYellow == 1) { $noOfAdd1Cards--; }
                                if ($randomYellow == 2) { $noOfAdd2Cards--; }
                    			if ($randomYellow == 3) { $noOfAdd3Cards--; }
                			    if ($randomYellow == 4) { $noOfMinus1Cards--; }
                			    if ($randomYellow == 5) { $noOfMinus2Cards--; }
                            }
                        }
                        if ($noOfYellows > 0) {
                            for ($i = 1; $i <= $noOfYellows; $i++) {
                                $randomYellow = rand(1, 5);
                                if ($randomYellow == 1) { $noOfAdd1Cards++; }
                        	    if ($randomYellow == 2) { $noOfAdd2Cards++; }
                    			if ($randomYellow == 3) { $noOfAdd3Cards++; }
                			    if ($randomYellow == 4) { $noOfMinus1Cards++; }
                			    if ($randomYellow == 5) { $noOfMinus2Cards++; }
                            }
                        }
                        $query2 = $pdo->prepare("insert into ModifiedLocks_V2 (id, user_id, shared_id, lock_id, card_info_hidden_modified_by, red_cards_modified_by, yellow_cards_modified_by, no_of_add_1_cards, no_of_add_2_cards, no_of_add_3_cards, no_of_minus_1_cards, no_of_minus_2_cards, timer_hidden_modified_by, timestamp_modified, unlocked) values ('', :lockedUserID, :sharedID, :lockID, :cardInfoHiddenModifiedBy, :redCardsModifiedBy, :yellowCardsModifiedBy, ".$noOfAdd1Cards.", ".$noOfAdd2Cards.", ".$noOfAdd3Cards.", ".$noOfMinus1Cards.", ".$noOfMinus2Cards.", ".$timerHiddenModifiedBy.", :timestampModified, :unlocked)");
                        $query2->execute(array('lockedUserID' => $lockedUserID, 'sharedID' => $sharedID, 'lockID' => $lockID, 'cardInfoHiddenModifiedBy' => $cardInfoHiddenModifiedBy, 'redCardsModifiedBy' => $redCardsModifiedBy, 'yellowCardsModifiedBy' => $yellowCardsModifiedBy, 'timestampModified' => time(), 'unlocked' => $unlocked));
                        if ($timerHiddenModifiedBy == -1) { $lockedTimerHidden = 0; }
                        if ($timerHiddenModifiedBy == 1) { $lockedTimerHidden = 1; }
                        if ($newKeyholderEmoji > 0) { $keyholderEmoji = $newKeyholderEmoji; }
                        $query2 = $pdo->prepare("update Locks_V2 set card_info_hidden = card_info_hidden + :cardInfoHiddenModifiedBy, red_cards = red_cards + :redCardsModifiedBy, yellow_cards = yellow_cards + ".$noOfYellows.", no_of_add_1_cards = no_of_add_1_cards + ".$noOfAdd1Cards.", no_of_add_2_cards = no_of_add_2_cards + ".$noOfAdd2Cards.", no_of_add_3_cards = no_of_add_3_cards + ".$noOfAdd3Cards.", no_of_minus_1_cards = no_of_minus_1_cards + ".$noOfMinus1Cards.", no_of_minus_2_cards = no_of_minus_2_cards + ".$noOfMinus2Cards.", timer_hidden = ".$lockedTimerHidden.", unlocked = :unlocked, timestamp_unlocked = :timestampUnlocked, date_unlocked = :dateUnlocked, keyholder_emoji = :keyholderEmoji where user_id = :lockedUserID and shared_id = :sharedID and id = :lockID");
                        $query2->execute(array('cardInfoHiddenModifiedBy' => $cardInfoHiddenModifiedBy, 'redCardsModifiedBy' => $redCardsModifiedBy, 'unlocked' => $unlocked, 'timestampUnlocked' => $timestampUnlocked, 'dateUnlocked' => $dateUnlocked, 'keyholderEmoji' => $keyholderEmoji, 'lockedUserID' => $lockedUserID, 'sharedID' => $sharedID, 'lockID' => $lockID));
                        if ($botChosen == 1) { $botName = "Hailey"; $botUserID = "BOT01"; }
                        if ($botChosen == 2) { $botName = "Blaine"; $botUserID = "BOT02"; }
                        if ($botChosen == 3) { $botName = "Zoe"; $botUserID = "BOT03"; }
                        if ($botChosen == 4) { $botName = "Chase"; $botUserID = "BOT04"; }
                        $query2 = $pdo->prepare("update UserIDs_V2 set timestamp_last_active = :timestampLastActive where user_id = :botUserID");
                        $query2->execute(array('timestampLastActive' => time(), 'botUserID' => $botUserID));
                        // SEND PUSH NOTIFICATION TO LOCKEE
                        if ($lockedUserPushNotificationsDisabled != 1 && $lockedUserToken != "" && $lockedUserStatus != 3) {
                            if ($lockedUserPlatform == "android") {
                                if ($lockedUserBuildNumberInstalled < 115) {
                                    SendPushNotificationAndroid($lockedUserToken, $botName." has just updated your lock.", "ChastiKey");
                                } else {
                                    SendPushNotificationAndroidFCM($lockedUserToken, $botName." has just updated your lock.");
                                }
                            }
                            if ($lockedUserPlatform == "ios") {
                                SendPushNotificationiOS($lockedUserToken, $botName." has just updated your lock.");
                            }
                        }
                    }
                }
            }
    
        }
    }
    $query = null;
    $query1 = null;
    $query2 = null;
    $query3 = null;
    $pdo = null;
    mysqli_close($mysqli);
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}
?>