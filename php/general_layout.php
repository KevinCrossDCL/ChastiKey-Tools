<?php
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

// THIS IS AN EXAMPLE SCRIPT TO SHOW THE GENERAL LAYOUT OF MOST CHASTIKEY PHP SCRIPTS
// THIS LOOKS FOR NEWS ITEMS IN THE DATABASE TO POPULATE THE NEWS SCREEN IN THE APP
// THE NEWS SCREEN WILL MOST LIKELY BE DROPPED IN A FUTURE VERSION AS IT'S NOT BEING USED

try {
    include "chastikey.php"; // INCLUDE FILE THAT CONTAINS MYSQLI/PDO CONNECTION CODE
    
    // THIS IS THE CONNECTION CODE THAT SITS IN THE ABOVE INCLUDE FILE
    $SQLServer = "localhost";
    $DBName = "xxxxxxxxxx";
    $DBUser = "xxxxxxxxxx";
    $DBPass = "xxxxxxxxxx";
    $mysqli = new mysqli($SQLServer, $DBUser, $DBPass, $DBName);
    $pdo = new PDO("mysql:host=".$SQLServer.";dbname=".$DBName, $DBUser, $DBPass);
    
    $JSON = array();
    
    // QUERY DATABASE
    $query = $pdo->prepare("select
        body, 
        date, 
        deleted,
        id,
        timestamp, 
        title
    from News where deleted = 0 order by timestamp desc limit 10");
    $query->execute();
    // STORE DATABASE DATA IN A JSON ARRAY
    foreach ($query as $row) {
        array_push($JSON, array(
            'body$' => $row["body"],
            'date$' => $row["date"],
            'deleted' => $row["deleted"],
            'id' => $row["id"],
            'timestamp' => $row["timestamp"],
            'title$' => $row["title"]
        ));
    }
    // ECHO JSON DATA FOR THE CHASTIKEY APP TO READ
    echo json_encode($JSON);

    $query = null;
    $pdo = null;
    mysqli_close($mysqli);
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}
?>