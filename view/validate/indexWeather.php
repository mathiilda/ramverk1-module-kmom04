<article class="article">
    <h1 class="heading"><?= $data["heading"] ?></h1>
    <p>Skriv in din ip-address för att se föregående/kommande väder nära dig.</p>
    <form method="POST" action=<?= $data["action"] ?>>
        <input name="ip" type="text" require>
        <input type="submit" value="Skicka">
    </form>
    <?php if ($data["type"] == "weatherRest") : ?>
        <br>
        <p> <strong>Hur man använder API:et:</strong> För att hämta svaret anropa routen <code>/apiWeather</code>. Ip adressen anger du med nyckeln "ip" (i till exempel Postman). Svaret returneras som JSON.</p><br>
        <form action="apiWeather" method="POST">
            <input name="ip" type="hidden" value="172.217.21.142">
            <input type="submit" value="Testroute 1">
        </form><br>
        <form action="apiWeather" method="POST">
            <input name="ip" type="hidden" value="140.82.121.4">
            <input type="submit" value="Testroute 2">
        </form><br>
        <form action="apiWeather" method="POST">
            <input name="ip" type="hidden" value="194.47.150.9">
            <input type="submit" value="Testroute 3">
        </form>
    <?php endif; ?>
</article>