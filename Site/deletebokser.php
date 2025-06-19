<?php
require_once "../DB/Database.php";

$db = new DB();

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $bokserId = $_GET['id']; 
    $sql = "DELETE FROM bokser WHERE bokser_ID = :bokserId"; 
    $params = [':bokserId' => $bokserId];

    $result = $db->run($sql, $params);

    if ($result) {
        header("Location: bokserpagina.php?message=Product%20deleted%20successfully");
    } else {
        header("Location: bokserpagina.php?error=Failed%20to%20delete%20product");
    }
} else {
    header("Location: bokserpagina.php?error=Invalid%20product%20ID");
}
exit;
