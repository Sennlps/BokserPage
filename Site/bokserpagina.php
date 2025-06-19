<?php
require_once 'Bokser.php';

$bokser = new Bokser();
$boksers = $bokser->getAllBoksers();
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/bokserpagina.css">
    <title>Boks Legends</title>
    <link href="https://fonts.googleapis.com/css2?family=UnifrakturCook:wght@700&display=swap" rel="stylesheet">
</head>
<body>
    <h1>Boks Legends</h1>
    <button class="toggle-btn" onclick="toggleDarkMode()">Klein gifje :D</button>
    <button class="toggle-btn" onclick="window.location.href='AddBokser.php'">Bokser Toevoegen</button>
    <button class="toggle-btn" onclick="window.location.href='overmij.php'">Over Mij</button>
    <p>Mijn favoriete boxing legends:</p>

    <table>
        <thead>
            <tr>
                <th>Voornaam</th>
                <th>Achternaam</th>
                <th>Leeftijd</th>
                <th>Titel</th>
                <th>Beschrijving</th>
                <th>Foto</th>
                <th>Acties</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($boksers)): ?>
                <?php foreach ($boksers as $bokser): ?>
                    <tr>
                        <td><?= htmlspecialchars($bokser['voornaam']) ?></td>
                        <td><?= htmlspecialchars($bokser['achternaam']) ?></td>
                        <td><?= htmlspecialchars($bokser['leeftijd']) ?></td>
                        <td><?= htmlspecialchars($bokser['titel']) ?></td>
                        <td><?= nl2br(htmlspecialchars($bokser['beschrijving'])) ?></td>
                        <td>
                            <img src="../Plaatjes/<?= htmlspecialchars($bokser['foto']) ?>" alt="Bokser Foto">
                        </td>
                        <td>
                            <a href="editbokser.php?id=<?= htmlspecialchars($bokser['bokser_ID']) ?>" class="edit-btn">Bewerken</a> |
                            <a href="deletebokser.php?id=<?= htmlspecialchars($bokser['bokser_ID']) ?>" class="delete-btn" 
                               onclick="return confirm('Weet je zeker dat je deze bokser wilt verwijderen?')">Verwijderen</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" style="text-align: center;">Geen boksers gevonden.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <script>
        function toggleDarkMode() {
            document.body.classList.toggle("augustus-mode");
        }
    </script>

</body>
</html>
