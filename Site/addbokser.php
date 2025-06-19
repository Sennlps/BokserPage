<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $conn = new mysqli("localhost", "root", "", "jouw_database_naam");

    if ($conn->connect_error) {
        die("Verbinding mislukt: " . $conn->connect_error);
    }

    $voornaam = $_POST['voornaam'];
    $achternaam = $_POST['achternaam'];
    $leeftijd = $_POST['leeftijd'];
    $titel = $_POST['titel'];
    $beschrijving = $_POST['beschrijving'];


    $target_dir = "uploads/";
    $foto_naam = basename($_FILES["bokser_foto"]["name"]);
    $target_file = $target_dir . time() . "_" . $foto_naam;

    if (move_uploaded_file($_FILES["bokser_foto"]["tmp_name"], $target_file)) {
        $sql = "INSERT INTO boksers (voornaam, achternaam, leeftijd, titel, beschrijving, afbeelding)
                VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssisss", $voornaam, $achternaam, $leeftijd, $titel, $beschrijving, $target_file);

        if ($stmt->execute()) {
            echo "<p>Bokser succesvol toegevoegd!</p>";
        } else {
            echo "<p>Fout bij toevoegen: " . $stmt->error . "</p>";
        }

        $stmt->close();
    } else {
        echo "<p>Fout bij het uploaden van de afbeelding.</p>";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/addbokser.css">
    <title>Bokser toevoegen</title>
</head>
<body>
    <h1>Bokser Toevoegen</h1>
    <button class="toggle-btn" onclick="window.location.href='bokserpagina.php'">Terug naar Boksers</button>
    <form action="" method="post" enctype="multipart/form-data">
        <label for="voornaam">Voornaam:</label>
        <input type="text" id="voornaam" name="voornaam" required>

        <label for="achternaam">Achternaam:</label>
        <input type="text" id="achternaam" name="achternaam" required>

        <label for="leeftijd">Leeftijd:</label>
        <input type="number" id="leeftijd" name="leeftijd" required>

        <label for="titel">Titel:</label>
        <input type="text" id="titel" name="titel" required>

        <label for="beschrijving">Beschrijving:</label>
        <textarea id="beschrijving" name="beschrijving" rows="5" required></textarea>

        <label for="bokser_foto">Kies een afbeelding:</label>
        <input type="file" name="bokser_foto" id="bokser_foto" required>

        <button type="submit" class="toggle-btn">Uploaden</button>
    </form>
</body>
</html>