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

<?php

//recupero le matrici dal post
    $domande = json_decode($_POST['domande'], true);
    $matriceControllo = json_decode($_POST['matriceControllo'], true);
    //passo la matrice risposte dell'utente

    $matriceUtente = json_decode($_POST['matriceUtente'], true);
    $numero = $_POST['numero'];
    $indiceDomandaCorrente = $_POST['indiceDomandaCorrente'];
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

//Confronto delle matrici di risposta e di soluzione

    $domandeSbagliate = array();
    $contatore = 0;

    foreach ($matriceUtente as $rispostaUtente) {
        foreach ($matriceControllo as $soluzione) {
            if ($rispostaUtente['numero'] == $soluzione['numero']) {
                $numeroDomanda = $rispostaUtente['numero'];
                $rispostaData = $rispostaUtente['valoreDato'];
                $soluzioneCorretta = $soluzione['soluzione'];

                if ($rispostaData !== $soluzioneCorretta) {
                    $domandeSbagliate[] = array(
                        'numero' => $numeroDomanda,
                        'valoreDato' => $rispostaData
                    );
                    $contatore++;
                }
            }
        }
    }
//Inizio STampa
if (count($domandeSbagliate) > 0) {
    echo "<div class ='box'><p class = 'scritte'>";
    echo "<br> Hai totalizzato un punteggio di: ".  (20 - $contatore). "/20. ";

    if($contatore > 4){ //metti a 4
        echo "<br> <p class = 'esameno'>Non hai passato il test!</p></p></div>";
    }else{
        echo "<br> <p class = 'esamesi'>Hai passato il test!</p></p></div>";
    }

    foreach ($domandeSbagliate as $domandaSbagliata) {
        foreach ($domande as $domanda) {
            if ($domandaSbagliata['numero'] == $domanda['numero']) {
                echo "<div class ='box'><p class = 'scritte'><h2>Domanda {$domanda['numero']}</h2></p>";
                echo "<p class = 'scritte'>{$domanda['domanda']}<br><br>";
                echo "Risposta A: {$domanda['risposta_a']}<br>";
                echo "Risposta B: {$domanda['risposta_b']}<br>";
                echo "Risposta C: {$domanda['risposta_c']}<br><br>";
                echo "Risposta data: {$domandaSbagliata['valoreDato']} <br> Risposta Corretta: {$domanda['soluzione']}</p></div>";
            
            }
        }
    }
} else {
    echo "<div class ='box'><p class = 'scritte'>Complimenti! Hai risposto correttamente a tutte le domande.</div></p>";
}


//stampa risposte utente
/*
    echo "<h3>Risposte dell'utente:</h3>";
    foreach ($matriceUtente as $risposta) {
        echo "Domanda {$risposta['numero']}: {$risposta['valoreDato']} <br>";
    }
    //stampa matrice soluzioni
    echo "<br> Matrice Contenente numero e risultato <br>";
        foreach($matriceControllo as $poggio) {
            echo "Numero: " . $poggio['numero'] . " Soluzione: " . $poggio['soluzione'] . "<br>";
        }
    //Prova di stampa tutte le domande
    foreach ($domande as $domanda) {
        echo  "<br>" . "Domanda: " . $domanda['domanda'] . "<br>";
        echo "Risposta A: " . $domanda['risposta_a'] . "<br>";
        echo "Risposta B: " . $domanda['risposta_b'] . "<br>";
        echo "Risposta C: " . $domanda['risposta_c'] . "<br>";
        echo "<hr>";
    }
*/
?>
<div class="form1">
    <form action="index.php" method="post">
        <input type="submit" value="Ritenta il quiz adesso">
        
    </form>
    <form action="https://www.aiapinerolo.it/" method="post">
        <input type="submit" value="Torna alla home page">
    </form>
</div>
