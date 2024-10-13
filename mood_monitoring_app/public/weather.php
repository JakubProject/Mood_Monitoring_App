<?php
$apiKey = '04d0f27c1f332f635d8e4b85df1792f0'; // Twój klucz API OpenWeatherMap
$city = isset($_GET['city']) ? $_GET['city'] : 'Warsaw'; // Użycie miasta przesłanego przez URL lub domyślnie Warszawa
$apiUrl = "http://api.openweathermap.org/data/2.5/weather?q=$city&appid=$apiKey&units=metric";

// Pobieranie danych z API
$response = file_get_contents($apiUrl);
$weatherData = json_decode($response, true);

// Ustawienia domyślne, jeśli nie uda się pobrać danych
$humidity = 'Brak danych';
$pressure = 'Brak danych';
$description = 'Brak danych';

// Sprawdzamy, czy dane zostały pobrane poprawnie
if ($weatherData && $weatherData['cod'] == 200) {
    if (isset($weatherData['main']['humidity'])) {
        $humidity = $weatherData['main']['humidity'];
    }

    if (isset($weatherData['main']['pressure'])) {
        $pressure = $weatherData['main']['pressure'];
    }

    if (isset($weatherData['weather'][0]['description'])) {
        $description = $weatherData['weather'][0]['description'];
    }
}

// Wyświetlanie wyników
echo "<div class='weather-container'>";
echo "<p>Miasto: $city</p>";
echo "<p>Wilgotność: $humidity%</p>";
echo "<p>Ciśnienie atmosferyczne: $pressure hPa</p>";
echo "<p>Opis pogody: $description</p>";
echo "</div>";
?>
