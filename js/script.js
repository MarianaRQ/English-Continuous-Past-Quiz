document.addEventListener("DOMContentLoaded", () => {
    // ---- Temporizador ----
    let timeLeft = 15;
    const timerElement = document.getElementById("timer");
    const form = document.getElementById("formPregunta");

    const countdown = setInterval(() => {
        timeLeft--;
        timerElement.textContent = timeLeft;

        if (timeLeft <= 0) {
            clearInterval(countdown);
            alert("¡Se acabó el tiempo!");

            if (!form.querySelector('input[name="respuesta"]:checked')) {
                const hiddenInput = document.createElement("input");
                hiddenInput.type = "hidden";
                hiddenInput.name = "respuesta";
                hiddenInput.value = "0";
                form.appendChild(hiddenInput);
            }

            form.submit();
        }
    }, 1000);

    form.addEventListener("submit", () => clearInterval(countdown));

    // ---- Música de fondo ----
    const bgMusic = document.getElementById("bgMusic");
    bgMusic.volume = 0.3;

    // Arranca silenciado
    bgMusic.play().catch(err => {
        console.log("El navegador bloqueó el autoplay:", err);
    });

    // En el primer clic quitamos el mute
    document.body.addEventListener("click", () => {
        if (bgMusic.muted) {
            bgMusic.muted = false;
            bgMusic.play();
        }
    }, { once: true });
});
