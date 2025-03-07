/*
 * @author Fabiano Vaglio 
 */

function mostraAvvisoInizio() {
    // La funzione alert mostra la finestra di avviso con il messaggio "Sei sicuro?"
    alert('Il quiz sta per iniziare');
}
function playSound() {
    var audio = new Audio('http://127.0.0.1/AIAProject/immagini/timer.mp4');  // Sostituisci 'path/to/your/sound.mp3' con il percorso del tuo file audio
    audio.play();
}

function Timer() {
    var countdown = 30;  // Inizializza il conteggio alla durata del timeout in secondi
    var countdownElement = document.getElementById('countdown');  // Riferimento all'elemento HTML per visualizzare il conteggio

    // Funzione che verrà eseguita ad ogni intervallo di 1 secondo
    function updateCountdown() {
        countdownElement.textContent = Math.max(countdown, 0);  // Aggiorna il testo dell'elemento con il valore del countdown
        countdown--;

        if (countdown === 1) {
            playSound();  // Chiamata alla funzione che riproduce il suono quando il countdown è a 2 secondi
        }

        if (countdown < (-2)) {
            document.getElementById('quiz').submit();  // Invia il form quando il countdown raggiunge 0
        } else {
            setTimeout(updateCountdown, 1000);  // Richiama la funzione di aggiornamento ogni secondo
        }
    }

    // Inizia il countdown
    updateCountdown();
}


// Chiamato quando l'ultima domanda è visualizzata
function TimerUltimaDomanda() {
    var countdown = 30;
    var countdownElement = document.getElementById('countdown2');

    function updateCountdown() {
        countdownElement.textContent = Math.max(countdown, 0);
        countdown--;

        if (countdown === 1) {
            playSound(); 
        }

        if (countdown < (-2)) {
            document.getElementById('quiz2').submit();
        } else {
            setTimeout(updateCountdown, 1000);
        }
    }

    updateCountdown();
}




