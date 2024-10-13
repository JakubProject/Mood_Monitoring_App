<?php
include('../includes/db.php');
include('../includes/auth.php');
include('../includes/functions.php');

if (!is_logged_in()) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Walidacja po stronie serwera
    $errors = [];

    if ($_POST['mood_level'] < 1 || $_POST['mood_level'] > 10) {
        $errors[] = "Poziom nastroju musi być wartością między 1 a 10.";
    }
    if ($_POST['energy_level'] < 1 || $_POST['energy_level'] > 10) {
        $errors[] = "Poziom energii musi być wartością między 1 a 10.";
    }
    if ($_POST['stress_level'] < 1 || $_POST['stress_level'] > 10) {
        $errors[] = "Poziom stresu musi być wartością między 1 a 10.";
    }
    if ($_POST['sleep_quality'] < 1 || $_POST['sleep_quality'] > 10) {
        $errors[] = "Jakość snu musi być wartością między 1 a 10.";
    }
    if ($_POST['motivation_level'] < 1 || $_POST['motivation_level'] > 10) {
        $errors[] = "Poziom motywacji musi być wartością między 1 a 10.";
    }
    if ($_POST['anxiety_level'] < 1 || $_POST['anxiety_level'] > 10) {
        $errors[] = "Poziom lęku musi być wartością między 1 a 10.";
    }
    if ($_POST['physical_activity'] < 0) {
        $errors[] = "Ilość aktywności fizycznej nie może być wartością ujemną.";
    }
    if ($_POST['concentration_level'] < 1 || $_POST['concentration_level'] > 10) {
        $errors[] = "Poziom koncentracji musi być wartością między 1 a 10.";
    }
    if ($_POST['happiness_level'] < 1 || $_POST['happiness_level'] > 10) {
        $errors[] = "Poziom radości musi być wartością między 1 a 10.";
    }
    if ($_POST['day_satisfaction'] < 1 || $_POST['day_satisfaction'] > 10) {
        $errors[] = "Zadowolenie z dnia musi być wartością między 1 a 10.";
    }

    // Sprawdzenie, czy są jakieś błędy
    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo "<p style='color:red;'>$error</p>";
        }
    } else {
        // Dodanie nastroju do bazy danych, jeśli nie ma błędów
        add_mood($_SESSION['user_id'], $_POST);
        header('Location: dashboard.php'); // Odświeżenie strony po zapisaniu nastroju
        exit();
    }
}

$moods = get_moods($_SESSION['user_id']);
$moodData = [];
$energyData = [];
$stressData = [];
$sleepData = [];
$motivationData = [];
$anxietyData = [];
$activityData = [];
$concentrationData = [];
$happinessData = [];
$satisfactionData = [];
$moodDates = [];

while ($mood = $moods->fetch_assoc()) {
    $moodData[] = $mood['mood_level'];
    $energyData[] = $mood['energy_level'];
    $stressData[] = $mood['stress_level'];
    $sleepData[] = $mood['sleep_quality'];
    $motivationData[] = $mood['motivation_level'];
    $anxietyData[] = $mood['anxiety_level'];
    $activityData[] = $mood['physical_activity'];
    $concentrationData[] = $mood['concentration_level'];
    $happinessData[] = $mood['happiness_level'];
    $satisfactionData[] = $mood['day_satisfaction'];
    $moodDates[] = $mood['created_at'];
}

// Obliczenie średniego poziomu nastroju
$averageMood = !empty($moodData) ? array_sum($moodData) / count($moodData) : 0;
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-zoom@1.0.0-beta.7/dist/chartjs-plugin-zoom.min.js"></script>
</head>
<body>
<!-- Górne menu nawigacyjne -->
<nav class="top-menu">
    <ul>
        <li><a href="dashboard.php">Dashboard</a></li> 
        <li><a href="suggestions.php" target="_blank">Analiza i sugestie</a></li> <!-- Otwiera stronę w nowej karcie -->
        <li><a href="logout.php">Wyloguj się</a></li> <!-- Wyloguj się -->
    </ul>
</nav>

<div class="dashboard-container">
    <!-- Kolumna po lewej z formularzem -->
    <div class="form-container">
        <h2>Dodaj swój nastrój</h2>
        <form name="moodForm" method="POST" onsubmit="return validateForm()">
            <div class="form-row">
                <div>
                    <label for="mood_level">Poziom nastroju (1-10):</label>
                    <input type="number" name="mood_level" min="1" max="10" required>
                </div>
                <div>
                    <label for="energy_level">Poziom energii (1-10):</label>
                    <input type="number" name="energy_level" min="1" max="10" required>
                </div>
            </div>

            <div class="form-row">
                <div>
                    <label for="stress_level">Poziom stresu (1-10):</label>
                    <input type="number" name="stress_level" min="1" max="10" required>
                </div>
                <div>
                    <label for="sleep_quality">Jakość snu (1-10):</label>
                    <input type="number" name="sleep_quality" min="1" max="10" required>
                </div>
            </div>

            <div class="form-row">
                <div>
                    <label for="motivation_level">Poziom motywacji (1-10):</label>
                    <input type="number" name="motivation_level" min="1" max="10" required>
                </div>
                <div>
                    <label for="anxiety_level">Poziom lęku (1-10):</label>
                    <input type="number" name="anxiety_level" min="1" max="10" required>
                </div>
            </div>

            <div class="form-row">
                <div>
                    <label for="physical_activity">Ilość aktywności fizycznej (w minutach):</label>
                    <input type="number" name="physical_activity" min="0" required>
                </div>
                <div>
                    <label for="concentration_level">Poziom koncentracji (1-10):</label>
                    <input type="number" name="concentration_level" min="1" max="10" required>
                </div>
            </div>

            <div>
                <label for="physical_symptoms">Objawy fizyczne (krótki opis):</label>
                <textarea name="physical_symptoms" placeholder="Np. ból głowy, zmęczenie" required></textarea>
            </div>

            <div class="form-row">
                <div>
                    <label for="happiness_level">Poziom radości (1-10):</label>
                    <input type="number" name="happiness_level" min="1" max="10" required>
                </div>
                <div>
                    <label for="day_satisfaction">Zadowolenie z dnia (1-10):</label>
                    <input type="number" name="day_satisfaction" min="1" max="10" required>
                </div>
            </div>

            <div>
                <label for="mood_text">Dodaj notatkę (opcjonalne):</label>
                <textarea name="mood_text" placeholder="Dodaj notatkę (opcjonalne)"></textarea>
            </div>

            <button type="submit">Zapisz nastrój</button>
        </form>
    </div>

    <!-- Kolumna po prawej z wykresem i pogodą -->
    <div class="chart-container">
        <h3>Analiza trendów nastroju:</h3>
        <canvas id="moodChart" width="400" height="200"></canvas>

        <!-- Historia nastroju -->
        <h3>Historia nastroju:</h3>
        <?php if (!empty($moodData)): ?>
            <ul>
                <?php foreach ($moodData as $key => $value): ?>
                    <li>
                        <strong><?php echo $moodDates[$key]; ?></strong> - Poziom nastroju: <?php echo $value; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>Brak zapisanych nastrojów.</p>
        <?php endif; ?>

        <!-- Dane pogodowe z weather.php -->
        <h3>Aktualna pogoda:</h3>
        <div class="weather-container">
            <?php include('weather.php'); ?>
        </div>
    </div>
</div>

<script>
    
// Walidacja po stronie klienta
function validateForm() {
    var isValid = true;
    var errorMessage = "";

    var moodLevel = document.forms["moodForm"]["mood_level"].value;
    var energyLevel = document.forms["moodForm"]["energy_level"].value;
    var stressLevel = document.forms["moodForm"]["stress_level"].value;
    var sleepQuality = document.forms["moodForm"]["sleep_quality"].value;
    var motivationLevel = document.forms["moodForm"]["motivation_level"].value;
    var anxietyLevel = document.forms["moodForm"]["anxiety_level"].value;
    var physicalActivity = document.forms["moodForm"]["physical_activity"].value;
    var concentrationLevel = document.forms["moodForm"]["concentration_level"].value;
    var happinessLevel = document.forms["moodForm"]["happiness_level"].value;
    var daySatisfaction = document.forms["moodForm"]["day_satisfaction"].value;

    if (moodLevel < 1 || moodLevel > 10) {
        errorMessage += "Poziom nastroju musi być wartością między 1 a 10.\n";
        isValid = false;
    }
    if (energyLevel < 1 || energyLevel > 10) {
        errorMessage += "Poziom energii musi być wartością między 1 a 10.\n";
        isValid = false;
    }
    if (stressLevel < 1 || stressLevel > 10) {
        errorMessage += "Poziom stresu musi być wartością między 1 a 10.\n";
        isValid = false;
    }
    if (sleepQuality < 1 || sleepQuality > 10) {
        errorMessage += "Jakość snu musi być wartością między 1 a 10.\n";
        isValid = false;
    }
    if (motivationLevel < 1 || motivationLevel > 10) {
        errorMessage += "Poziom motywacji musi być wartością między 1 a 10.\n";
        isValid = false;
    }
    if (anxietyLevel < 1 || anxietyLevel > 10) {
        errorMessage += "Poziom lęku musi być wartością między 1 a 10.\n";
        isValid = false;
    }
    if (physicalActivity < 0) {
        errorMessage += "Ilość aktywności fizycznej nie może być wartością ujemną.\n";
        isValid = false;
    }
    if (concentrationLevel < 1 || concentrationLevel > 10) {
        errorMessage += "Poziom koncentracji musi być wartością między 1 a 10.\n";
        isValid = false;
    }
    if (happinessLevel < 1 || happinessLevel > 10) {
        errorMessage += "Poziom radości musi być wartością między 1 a 10.\n";
        isValid = false;
    }
    if (daySatisfaction < 1 || daySatisfaction > 10) {
        errorMessage += "Zadowolenie z dnia musi być wartością między 1 a 10.\n";
        isValid = false;
    }

    if (!isValid) {
        alert(errorMessage);
    }

    return isValid;
}

// Pobieranie danych z PHP
var moodLevels = <?php echo json_encode($moodData); ?>;
var energyLevels = <?php echo json_encode($energyData); ?>;
var stressLevels = <?php echo json_encode($stressData); ?>;
var sleepLevels = <?php echo json_encode($sleepData); ?>;
var motivationLevels = <?php echo json_encode($motivationData); ?>;
var anxietyLevels = <?php echo json_encode($anxietyData); ?>;
var activityLevels = <?php echo json_encode($activityData); ?>;
var concentrationLevels = <?php echo json_encode($concentrationData); ?>;
var happinessLevels = <?php echo json_encode($happinessData); ?>;
var satisfactionLevels = <?php echo json_encode($satisfactionData); ?>;
var moodDates = <?php echo json_encode($moodDates); ?>;
var averageMood = <?php echo $averageMood; ?>;

// Konfiguracja wykresu
var ctx = document.getElementById('moodChart').getContext('2d');
var moodChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: moodDates, // Daty na osi X
        datasets: [{
            label: 'Poziom nastroju',
            data: moodLevels,
            backgroundColor: 'rgba(99, 132, 255, 0.2)',
            borderColor: 'rgba(99, 132, 255, 1)',
            borderWidth: 2,
            fill: false,
        }, {
            label: 'Poziom energii',
            data: energyLevels,
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 2,
            fill: false,
        }, {
            label: 'Poziom stresu',
            data: stressLevels,
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            borderColor: 'rgba(255, 99, 132, 1)',
            borderWidth: 2,
            fill: false,
        }, {
            label: 'Jakość snu',
            data: sleepLevels,
            backgroundColor: 'rgba(153, 102, 255, 0.2)',
            borderColor: 'rgba(153, 102, 255, 1)',
            borderWidth: 2,
            fill: false,
        }, {
            label: 'Poziom motywacji',
            data: motivationLevels,
            backgroundColor: 'rgba(255, 159, 64, 0.2)',
            borderColor: 'rgba(255, 159, 64, 1)',
            borderWidth: 2,
            fill: false,
        }, {
            label: 'Poziom lęku',
            data: anxietyLevels,
            backgroundColor: 'rgba(54, 162, 235, 0.2)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 2,
            fill: false,
        }, {
            label: 'Ilość aktywności fizycznej',
            data: activityLevels,
            backgroundColor: 'rgba(255, 206, 86, 0.2)',
            borderColor: 'rgba(255, 206, 86, 1)',
            borderWidth: 2,
            fill: false,
        }, {
            label: 'Poziom koncentracji',
            data: concentrationLevels,
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 2,
            fill: false,
        }, {
            label: 'Poziom radości',
            data: happinessLevels,
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            borderColor: 'rgba(255, 99, 132, 1)',
            borderWidth: 2,
            fill: false,
        }, {
            label: 'Zadowolenie z dnia',
            data: satisfactionLevels,
            backgroundColor: 'rgba(153, 102, 255, 0.2)',
            borderColor: 'rgba(153, 102, 255, 1)',
            borderWidth: 2,
            fill: false,
        }, {
            label: 'Średni poziom nastroju',
            data: Array(moodLevels.length).fill(averageMood), // Linia średniego poziomu nastroju
            borderColor: 'rgba(255, 206, 86, 1)',
            borderWidth: 2,
            borderDash: [5, 5], // Linia przerywana
            fill: false,
        }]
    },
    options: {
        scales: {
            x: {
                title: {
                    display: true,
                    text: 'Data'
                }
            },
            y: {
                beginAtZero: true,
                title: {
                    display: true,
                    text: 'Poziom (1-10)'
                }
            }
        },
        responsive: true,
        plugins: {
            zoom: {
                pan: {
                    enabled: true,
                    mode: 'x',
                },
                zoom: {
                    enabled: true,
                    mode: 'x',
                }
            }
        }
    }
});
</script>
</body>
</html>
