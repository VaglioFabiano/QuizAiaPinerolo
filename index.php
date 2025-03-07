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
error_reporting(E_ALL);
ini_set('display_errors', 1);

$nome_file_csv = 'quiz2324.csv';

//decodifica caratteri
function formatText($text) {
    // Rimuovi caratteri di newline e gestisci la codifica dei caratteri
    $text = preg_replace("/[\r\n]+/", " ", $text);
    
    // Rimuovi le citazioni doppie duplicate
    $text = str_replace('""', '"', $text);

    return nl2br(htmlspecialchars($text, ENT_QUOTES, 'UTF-8'));
}


// Apre il file in modalità lettura
$file = fopen($nome_file_csv, 'r');
//LEGGO I DATI DA FILE
    if ($file) {
        if (($handle = fopen($nome_file_csv, 'r')) !== FALSE) {
        
            // Legge ogni riga del file CSV
            while (($line = fgets($handle)) !== FALSE) {
                
                // Rimuove eventuali spazi bianchi extra e divide la riga utilizzando il delimitatore ";"
                $data = explode(';', trim($line));
            
            $data = array_map(function($element) {
                return iconv("ISO-8859-1", "UTF-8", $element);
            }, $data);
        

            if (count($data) > 0) {
                
                // Aggiunge la riga corrente all'array delle domande
                $question = [
                    'numero' => isset($data[0]) ? $data[0] : '',
                    'domanda' => isset($data[1]) ? formatText($data[1]) : '',
                    'risposta_a' => isset($data[2]) ? formatText($data[2]) : '',
                    'risposta_b' => isset($data[3]) ? formatText($data[3]) : '',
                    'risposta_c' => isset($data[4]) ? formatText($data[4]) : '',
                    'soluzione' => isset($data[5]) ? formatText($data[5]) : '',
                ];
                
             
                
                $questions[] = $question;
            }
        }
        }
        // Chiude il file
        fclose($file);
    } else {
        // Gestione dell'errore se il file non può essere aperto
        echo 'Impossibile aprire il file CSV.';
    }

//SCELGO UNA DOMANDA CASUALE

   $matriceControllo = array();
   
   
   $numeriDomandeUscite = array();
   $domande = array();
   
   for ($i = 0; $i < 20; $i++) {
    // Inizializza $domandaCasuale in caso $matriceControllo sia vuoto
    $domandaCasuale = array();

    $domandaGiaUscita = false;
    $flag = false;

    if (!empty($matriceControllo)) {
        // Cicla finché non viene trovata una domanda non ancora uscita

        do {
            // Scegli una domanda casuale
            $numeroRandom = mt_rand(0, count($questions) - 1);
            $domandaCasuale = $questions[$numeroRandom];

            // Imposta $domandaGiaUscita su false di default
            $domandaGiaUscita = false;

            foreach ($matriceControllo as $rigaPoggio) {
                if (is_array($rigaPoggio) && array_key_exists('numero', $rigaPoggio)) {
                    // Confronta $numeroRandom con il valore di 'numero' in $rigaPoggio
                    if (intval($numeroRandom) === intval($rigaPoggio['numero'])) {
                        // Se $numeroRandom è uguale a uno dei numeri nella matrice, imposta $domandaGiaUscita su true
                        $domandaGiaUscita = true;
                        break;
                    }
                }
            }

            if (!$domandaGiaUscita) {
                // Se $domandaGiaUscita è ancora false, la domanda non è ancora uscita
                $domande[] = [
                    'numero' => $domandaCasuale['numero'],
                    'domanda' => $domandaCasuale['domanda'],
                    'risposta_a' => $domandaCasuale['risposta_a'],
                    'risposta_b' => $domandaCasuale['risposta_b'],
                    'risposta_c' => $domandaCasuale['risposta_c'],
                    'soluzione' => $domandaCasuale['soluzione'],
                ];
                $matriceControllo[] = [
                    'numero' => $domandaCasuale['numero'],
                    'soluzione' => $domandaCasuale['soluzione'],
                ];
            }

        } while ($domandaGiaUscita);
    } else {
        // Gestisci il caso in cui $matriceControllo è vuoto
        $numeroRandom = mt_rand(0, count($questions) - 1);
        $domandaCasuale = $questions[$numeroRandom];
        $domande[] = [
            'numero' => $domandaCasuale['numero'],
            'domanda' => $domandaCasuale['domanda'],
            'risposta_a' => $domandaCasuale['risposta_a'],
            'risposta_b' => $domandaCasuale['risposta_b'],
            'risposta_c' => $domandaCasuale['risposta_c'],
            'soluzione' => $domandaCasuale['soluzione'],
        ];
        $matriceControllo[] = [
            'numero' => $domandaCasuale['numero'],
            'soluzione' => $domandaCasuale['soluzione'],
        ];
    }
}

   /*
    echo "Matrice Contenente numero e risultato <br>";
    foreach($matriceControllo as $poggio){
        echo "Numero: " . $poggio['numero'] . " Soluzione: " . $poggio['soluzione'] . "<br>";
    }
    echo "<br>"."<br>"."<br>";
   
   
    
    echo "Numero: " . $domandaCasuale['numero'] . "<br>";
    echo "Domanda: " . $domandaCasuale['domanda'] . "<br>";
    echo "Risposta A: " . $domandaCasuale['risposta_a'] . "<br>";
    echo "Risposta B: " . $domandaCasuale['risposta_b'] . "<br>";
    echo "Risposta C: " . $domandaCasuale['risposta_c'] . "<br>";
    echo "Soluzione: " . $domandaCasuale['soluzione'] . "<br>";
    
    
    
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

    
?>
<div class ="box">
<h1 class="titolo1">Esercitazione Quiz Corso Arbitri</h1>
<p class = "scritte">
Premi sul pulsante qui sotto per dare inizio al test di 20 domande.

Per ogni domanda avrai a disposizione 30 secondi totali dopodiché passerai immediatamente alla successiva.
Una volta conclusa anche l'ultima domanda sarà immediatamente visibile il risultato.
Per considerare superata con successo la prova potrai commettere massimo<b> 4 errori</b>.
I quiz fanno riferimento all'elenco dei quiz autovalutativi con risposte.

</p>
</div>

<div class="form">
    <form action="paginaQuiz.php" method="post">
        <!-- Altri campi del form -->
        <input type="hidden" name="matriceControllo" value="<?php echo htmlspecialchars(json_encode($matriceControllo), ENT_QUOTES, 'UTF-8'); ?>">
        <input type="hidden" name="domande" value="<?php echo htmlspecialchars(json_encode($domande), ENT_QUOTES, 'UTF-8'); ?>">
        <input type="submit" value="Inizia il quiz adesso" name= "invia" onclick="mostraAvvisoInizio()">
    </form>
</div>
</body>
</html>