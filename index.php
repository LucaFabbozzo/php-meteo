<?php
		$cacheFile = 'cache.json';
		if(!is_file($cacheFile)) {
			file_put_contents($cacheFile, '[]');
		}
		if(isset($_GET['city'])) {
			$city = $_GET['city'];
			$strCache = file_get_contents($cacheFile);
			$jsonCache = json_decode($strCache, true);
			// qui controlliamo se la citta che abbiamo richiesto e gia presente nel file di cache
			if(isset($jsonCache[$city])) {
					// se è presente utilizziamo il dato dal file della cache 
					$meteoCity = $jsonCache[$city];
			} else {
		// altrimenti lo richiedi all'api e lo scrivi all'interno del file cache
				$baseUrl = "http://offline.altervista.org/weather/api.php";
				$str = file_get_contents($baseUrl . '?city=' . $city);
				$meteoCity = json_decode($str, true);
				$jsonCache[$city] = $meteoCity;
				file_put_contents($cacheFile, json_encode($jsonCache, JSON_PRETTY_PRINT));
			}
	 }
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Meteo</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <main class="container">
					<form method="GET">
						<input name="city" type="text" placeholder="Inserisci una città..." autocomplete="off">
					</form>
					<div class="card">
						<div class="temperature">
							<span><?php echo $meteoCity['temperature'] ?></span>
							<div class="region"><?php echo $meteoCity['wind'] ?>km/h</div>
						</div>
						<div class="city">
							<div><?php echo $meteoCity['city'] ?></div>
							<div class="region"><?php echo $meteoCity['description']?></div>
						</div>
					</div>
        </main>
    </body>
</html>
