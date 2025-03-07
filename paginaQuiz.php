<!--
 * @author Fabiano Vaglio 
 -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   
    <title>Resoconto</title>
    <script src="script.js"></script>
    <link rel="stylesheet" href="stile.css">
    <link rel="icon" href="./immagini/LogoAIASez.svg" sizes="192x192" />
    
</head>

<body>
<ul>
  <li><img src="./immagini/LogoAIA-1024x1024.png" alt="Logo" class="logo1"></li>
  <li><img src="./immagini/LogoSenzaSfondo.png" alt="Logo" class="logo2"></li>
  <li><img src="./immagini/LogoSezioneNOScritta-1024x786.png" alt="Logo" class="logo3"></li>
</ul>

<div class ="box">
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Recupera i dati dal POST

$domande = json_decode($_POST['domande'], true);
$matriceControllo = json_decode($_POST['matriceControllo'], true);
//passo la matrice risposte dell'utente
if (isset($_POST['invia'])) {
    $matriceUtente = array();

}else{
    $matriceUtente = json_decode($_POST['matriceUtente'], true);
    $numero = $_POST['numero'];
}


// STAMPA
    /*
    echo "Matrice Contenente numero e risultato <br>";
    foreach($matriceControllo as $poggio) {
        echo "Numero: " . $poggio['numero'] . " Soluzione: " . $poggio['soluzione'] . "<br>";
    }
    echo "<br>"."<br>"."<br>";

    //Prova di stampa tutte le domande
    foreach ($domande as $domanda) {
        echo "Domanda: " . $domanda['domanda'] . "<br>";
        echo "Risposta A: " . $domanda['risposta_a'] . "<br>";
        echo "Risposta B: " . $domanda['risposta_b'] . "<br>";
        echo "Risposta C: " . $domanda['risposta_c'] . "<br>";
        echo "Soluzione: " . $domanda['soluzione'] . "<br>";
        echo "<hr>";
    }
    */

//PROVA QUIZ
// Inizializziamo $indiceDomandaCorrente
$indiceDomandaCorrente = isset($_POST['indiceDomandaCorrente']) ? $_POST['indiceDomandaCorrente'] : 0;
$invioTipo = isset($_POST['invioTipo']) ? $_POST['invioTipo'] : '';

if (!isset($_POST['invia'])) {
    // Se il form è stato inviato, registra la risposta dell'utente
    $rispostaUtente = isset($_POST['rispostaUtente']) ? $_POST['rispostaUtente'] : '';
    if($rispostaUtente == ''){
        $rispostaUtente = "Vuota";
    }
    $matriceUtente[$indiceDomandaCorrente] = array(
        'numero' => $numero,
        'valoreDato' => $rispostaUtente
    );
}


if ($indiceDomandaCorrente < (count($domande)-1)) { 
    $condizione = true;
    //Form per le tutte le domande meno l'ultima

    $domandaCorrente = $domande[$indiceDomandaCorrente];
    $numero=$domande[$indiceDomandaCorrente]['numero'];
    $indiceMostrato = $indiceDomandaCorrente+1;
    // Mostriamo la domanda corrente
    echo "<h2>".$indiceMostrato .".</h2>"."<h2> {$domandaCorrente['domanda']}</h2>";

    $indiceDomandaCorrente++;

    // Form per inviare la risposta
    echo "<form id='quiz' action='paginaQuiz.php' method='post'>";
    echo "<div class='scelte'><p class='scritte'> ";
    echo "<label for='risposta_a'><input type='radio' name='rispostaUtente' value='A' id='risposta_a'> A. {$domandaCorrente['risposta_a']}<br></label>";
    echo "<label for='risposta_b'><input type='radio' name='rispostaUtente' value='B' id='risposta_b'> B. {$domandaCorrente['risposta_b']}<br></label>";
    echo "<label for='risposta_c'><input type='radio' name='rispostaUtente' value='C' id='risposta_c'> C. {$domandaCorrente['risposta_c']}<br></p></label>";
    echo "</div>";
    echo "<input type='hidden' name='domande' value='" . htmlspecialchars(json_encode($domande), ENT_QUOTES, 'UTF-8') . "'>";
    echo "<input type='hidden' name='matriceControllo' value='" . htmlspecialchars(json_encode($matriceControllo), ENT_QUOTES, 'UTF-8') . "'>";
    echo "<input type='hidden' name='matriceUtente' value='" . htmlspecialchars(json_encode($matriceUtente), ENT_QUOTES, 'UTF-8') . "'>";
    echo "<input type='hidden' name='indiceDomandaCorrente' value='{$indiceDomandaCorrente}'>";
    echo "<input type='hidden' name='numero' value='{$numero}'>";
    echo "<input type='hidden' name='invioTipo' value='manuale'>"; // Imposta il valore a 'manuale'
    echo "<input id='inviaRisposta' type='submit' name='rispostaSubmit' value='Invia Risposta' class=form3>";
    echo "</form></div>";
    echo "<div id='countdown'></div>";
    $indiceMostrato=0;

} elseif ($indiceDomandaCorrente < (count($domande))){ 

    //Form per l'ultima domanda
    $condizione = false;

    $domandaCorrente = $domande[$indiceDomandaCorrente];
    $numero=$domande[$indiceDomandaCorrente]['numero'];
    $indiceMostrato = $indiceDomandaCorrente+1;
    // Mostriamo la domanda corrente
    echo "<h2>".$indiceMostrato .".</h2>"."<h2> {$domandaCorrente['domanda']}</h2>";

    $indiceDomandaCorrente++;

    // Form per inviare la risposta
    echo "<form id='quiz2' action='resoconto.php' method='post'>";
    echo "<div class='scelte'><p class='scritte'> ";
    echo "<label for='risposta_a'><input type='radio' name='rispostaUtente' value='A' id='risposta_a'> A. {$domandaCorrente['risposta_a']}<br></label>";
    echo "<label for='risposta_b'><input type='radio' name='rispostaUtente' value='B' id='risposta_b'> B. {$domandaCorrente['risposta_b']}<br></label>";
    echo "<label for='risposta_c'><input type='radio' name='rispostaUtente' value='C' id='risposta_c'> C. {$domandaCorrente['risposta_c']}<br></label>";
    echo "</div>";
    echo "<input type='hidden' name='domande' value='" . htmlspecialchars(json_encode($domande), ENT_QUOTES, 'UTF-8') . "'>";
    echo " <input type='hidden' name='matriceControllo' value='" . htmlspecialchars(json_encode($matriceControllo), ENT_QUOTES, 'UTF-8') . "'>";
    echo " <input type='hidden' name='matriceUtente' value='" . htmlspecialchars(json_encode($matriceUtente), ENT_QUOTES, 'UTF-8') . "'>";
    echo "<input type='hidden' name='indiceDomandaCorrente' value='{$indiceDomandaCorrente}'>";
    echo "<input type='hidden' name='numero' value='{$numero}'>";
    echo "<input type='hidden' name='invioTipo' value='manuale'>"; // Imposta il valore a 'manuale'
    echo "<input id='inviaRisposta' type='submit' name='rispostaSubmit' value='Invia Risposta' class=form3>";
    echo "</form></div>";
    echo "<div id='countdown2'></div>";
    $indiceMostrato=0;

}else {
    // Tutte le domande sono state mostrate
    echo "<h2>Errore d'inoltro domande</h2>"; 
}

?>

<!-- Avvio il timer che fa scadere la pagina -->
<script>
    var condizione = <?php echo json_encode($condizione); ?>;
        // Chiamare la funzione definita nel file script.js
        if (condizione) {
            Timer();
        }else {
            TimerUltimaDomanda();
        }

</script>

</body>
</html>
