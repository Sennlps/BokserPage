<?php
session_start();
require_once "../DB/Database.php";

try {
    $db = new DB();

    if (isset($_GET['id'])) {
        $edit_id = $_GET['id'];

        $sql = "SELECT * FROM bokser WHERE bokser_ID = :id";
        $stmt = $db->pdo->prepare($sql);
        $stmt->bindParam(':id', $edit_id, PDO::PARAM_INT);
        $stmt->execute();
        $bokser = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$bokser) {
            echo "Bokser niet gevonden!";
            exit();
        }
    } else {
        echo "Geen geldige ID opgegeven!";
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $voornaam = $_POST['voornaam'];
        $achternaam = $_POST['achternaam'];
        $leeftijd = $_POST['leeftijd'];
        $titel = $_POST['titel'];
        $beschrijving = $_POST['beschrijving'];
        $foto = $_POST['foto'];

        $update_sql = "UPDATE bokser SET 
                        voornaam = :voornaam, 
                        achternaam = :achternaam, 
                        leeftijd = :leeftijd, 
                        titel = :titel, 
                        beschrijving = :beschrijving, 
                        foto = :foto
                       WHERE bokser_ID = :id";
        $update_stmt = $db->pdo->prepare($update_sql);
        $update_stmt->bindParam(':voornaam', $voornaam);
        $update_stmt->bindParam(':achternaam', $achternaam);
        $update_stmt->bindParam(':leeftijd', $leeftijd, PDO::PARAM_INT);
        $update_stmt->bindParam(':titel', $titel);
        $update_stmt->bindParam(':beschrijving', $beschrijving);
        $update_stmt->bindParam(':foto', $foto);
        $update_stmt->bindParam(':id', $edit_id, PDO::PARAM_INT);

        if ($update_stmt->execute()) {
            header("Location: bokserpagina.php?success=1");
            exit();
        } else {
            echo "Fout bij het bijwerken van de bokser.";
        }
    }
} catch (PDOException $e) {
    echo "Fout bij het ophalen/bijwerken van de bokser: " . $e->getMessage();
    exit();
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bewerk Bokser</title>
</head>
<style>
        form {
            max-width: 400px;
            background: #f4f4f4;
            padding: 20px;
            border-radius: 10px;
        }
        label {
            font-weight: bold;
        }
        input, textarea {
            width: 100%;
            margin-bottom: 10px;
            padding: 8px;
        }
        button {
            background-color:rgb(226, 12, 12);
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
            width: 100%;
        }
        button:hover {
            background-color:rgb(132, 0, 0);
        }
    </style>
<body>
    <h1 style="text-align: center;">Bewerk Bokser</h1>
    <form method="POST">
        <label for="voornaam">Voornaam:</label>
        <input type="text" id="voornaam" name="voornaam" value="<?= htmlspecialchars($bokser['voornaam']) ?>" required>

        <label for="achternaam">Achternaam:</label>
        <input type="text" id="achternaam" name="achternaam" value="<?= htmlspecialchars($bokser['achternaam']) ?>" required>

        <label for="leeftijd">Leeftijd:</label>
        <input type="number" id="leeftijd" name="leeftijd" value="<?= htmlspecialchars($bokser['leeftijd']) ?>" required>

        <label for="titel">Titel:</label>
        <input type="text" id="titel" name="titel" value="<?= htmlspecialchars($bokser['titel']) ?>" required>

        <label for="beschrijving">Beschrijving:</label>
        <input type="text" id="beschrijving" name="beschrijving" value="<?= htmlspecialchars($bokser['beschrijving']) ?>" required>

        <label for="foto">Foto (URL):</label>
        <input type="text" id="foto" name="foto" value="<?= htmlspecialchars($bokser['foto']) ?>">

        <button type="submit">Bewerk</button>
    </form>
</body>
</html>
