<?php
// Funzione per leggere i ristoranti dal file
function leggiRistoranti() {
    $ristoranti = [];
    if (file_exists('ristoranti.txt')) {
        $file = fopen('ristoranti.txt', 'r');
        while (($line = fgets($file)) !== false) {
            $ristoranti[] = json_decode($line, true);
        }
        fclose($file);
    }
    return $ristoranti;
}

// Funzione per aggiungere un ristorante al file
function aggiungiRistorante($nome, $localita, $note, $valutazione) {
    $ristorante = [
        'nome' => $nome,
        'localita' => $localita,
        'note' => $note,
        'valutazione' => $valutazione
    ];
    $file = fopen('ristoranti.txt', 'a');
    fwrite($file, json_encode($ristorante) . PHP_EOL);
    fclose($file);
}

// Gestione del modulo di invio
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $localita = $_POST['localita'];
    $note = $_POST['note'];
    $valutazione = $_POST['valutazione'];
    
    aggiungiRistorante($nome, $localita, $note, $valutazione);
}

// Lettura dei ristoranti
$ristoranti = leggiRistoranti();
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Condividi Ristoranti</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Condividi Ristoranti</h1>
        
        <form method="POST" class="mb-4">
            <div class="form-group">
                <label for="nome">Nome Ristorante:</label>
                <input type="text" class="form-control" id="nome" name="nome" required>
            </div>
            <div class="form-group">
                <label for="localita">Località:</label>
                <input type="text" class="form-control" id="localita" name="localita" required>
            </div>
            <div class="form-group">
                <label for="note">Note:</label>
                <textarea class="form-control" id="note" name="note" required></textarea>
            </div>
            <div class="form-group">
                <label for="valutazione">Valutazione (1-5):</label>
                <input type="number" class="form-control" id="valutazione" name="valutazione" min="1" max="5" required>
            </div>
            <button type="submit" class="btn btn-primary">Aggiungi Ristorante</button>
        </form>

        <h2>Ristoranti Condivisi</h2>
        <ul class="list-group">
            <?php foreach ($ristoranti as $ristorante): ?>
                <li class="list-group-item">
                    <h5><?php echo htmlspecialchars($ristorante['nome']); ?></h5>
                    <p><strong>Località:</strong> <?php echo htmlspecialchars($ristorante['localita']); ?></p>
                    <p><strong>Note:</strong> <?php echo htmlspecialchars($ristorante['note']); ?></p>
                    <p><strong>Valutazione:</strong> <?php echo str_repeat('⭐', $ristorante['valutazione']); ?></p>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>