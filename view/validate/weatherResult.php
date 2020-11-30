<?php
    $count = 0;
    echo "<script>lat = '" . $data["lat"]  . "'</script>";
    echo "<script>lon = '" . $data["lon"]  . "'</script>";
?>
<script src="https://api.mapbox.com/mapbox-gl-js/v1.12.0/mapbox-gl.js"></script>
<link href="https://api.mapbox.com/mapbox-gl-js/v1.12.0/mapbox-gl.css" rel="stylesheet" />

<style>
#map {
    width: 50%; height: 400px;
}

.mapContainer {
    display: flex; justify-content: space-between;
}
</style>

<article class="article">
    <h1 class="heading">Resultat</h1>
    <?php if ($data["forecast"] == "error" || $data["historical"] == "error") : ?>
        <p>Vi kunde inte hitta en plats som matchade din ip-adress. Försök igen.</p>
    <?php else : ?>
        <p>Du befinner dig i: <?= $data["city"] . "," . $data["region"] ?>. Dina kordinater är följande: <?= $data["loc"] ?>.</p>
        <div class="mapContainer">
            <table>
                <tr>
                    <th>Datum</th>
                    <th>Väder</th>
                </tr>
                <?php foreach ($data["historical"] as $day) : ?>
                    <tr>
                        <td><?= strval(gmdate("Y-m-d", $day->current->dt)) ?></td>
                        <td><?= strval($day->current->weather[0]->description) ?></td>
                        <?php $count += 1; ?>
                    </tr>
                <?php endforeach; ?>
                <?php foreach ($data["forecast"] as $day) : ?>
                    <tr>
                        <td><?= strval(gmdate("Y-m-d", $day->dt)) ?></td>
                        <td><?= strval($day->weather[0]->description) ?></td>
                        <?php $count += 1; ?>
                    </tr>
                <?php endforeach; ?>
            </table><br>
            <div id="map"></div>
        </div>
    <?php endif; ?>
    <script>
        var lat;
        var lon;

        mapboxgl.accessToken = 'pk.eyJ1IjoibWF0aGlsZGExNyIsImEiOiJja2hwMmFvZHQwYzFzMnltamc0NXlwcDF4In0._gVZNXuw_NLTmIgRlILzXA';
        var map = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/mapbox/streets-v11',
        center: [lon, lat],
        zoom: 13
        });
    </script>
</article>