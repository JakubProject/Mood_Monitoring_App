<?php
include('../includes/db.php');
include('../includes/auth.php');
include('../includes/functions.php');

if (!is_logged_in()) {
    header('Location: login.php');
    exit();
}

// Pobranie ostatniego nastroju użytkownika
$moodData = get_last_mood($_SESSION['user_id']);

// Szczegółowa analiza wyników
$suggestions = '';

if ($moodData['mood_level'] < 4) {
    $suggestions .= "
    <h3>Nastrój poniżej przeciętnego poziomu</h3>
    <p>Twój nastrój jest na niskim poziomie. Oto kilka kroków, które mogą pomóc:</p>
    <ul>
        <li><strong>Relaksacja i medytacja:</strong> Spróbuj medytacji, technik oddechowych lub jogi, aby złagodzić napięcie. Medytacja ma udowodnione korzyści dla zdrowia psychicznego.</li>
        <li><strong>Dieta:</strong> Zwiększ spożycie kwasów tłuszczowych omega-3 (ryby, orzechy), które poprawiają funkcje mózgu i nastrój. Unikaj jedzenia przetworzonego i cukru, które mogą pogarszać samopoczucie.</li>
        <li><strong>Aktywność fizyczna:</strong> Nawet 15 minut spaceru na świeżym powietrzu może pomóc poprawić Twój nastrój.</li>
        <li><strong>Konsultacja z lekarzem:</strong> Jeśli niskie samopoczucie utrzymuje się przez dłuższy czas, rozważ konsultację z psychologiem lub terapeutą.</li>
        <li><strong>Link do badań:</strong> <a href='https://www.ncbi.nlm.nih.gov/pmc/articles/PMC6142697/' target='_blank'>Wpływ medytacji na zdrowie psychiczne</a></li>
    </ul>
    ";
} elseif ($moodData['mood_level'] >= 4 && $moodData['mood_level'] < 7) {
    $suggestions .= "
    <h3>Nastrój umiarkowany</h3>
    <p>Twój nastrój jest na średnim poziomie. Oto kilka wskazówek, aby utrzymać lub poprawić samopoczucie:</p>
    <ul>
        <li><strong>Odpoczynek:</strong> Zadbaj o odpowiednią ilość snu – 7-8 godzin dziennie. Jakość snu ma ogromny wpływ na nastrój.</li>
        <li><strong>Dieta:</strong> Zwiększ spożycie owoców i warzyw, które dostarczają niezbędnych witamin i minerałów poprawiających samopoczucie. Rozważ suplementację witaminy D, szczególnie w okresie zimowym.</li>
        <li><strong>Kontakt społeczny:</strong> Spotkanie z przyjaciółmi lub rozmowa telefoniczna może poprawić Twój nastrój i dać wsparcie emocjonalne.</li>
        <li><strong>Link do badań:</strong> <a href='https://www.sciencedirect.com/science/article/pii/S0195666316304324' target='_blank'>Wpływ diety na nastrój i zdrowie psychiczne</a></li>
    </ul>
    ";
} else {
    $suggestions .= "
    <h3>Wysoki poziom nastroju</h3>
    <p>Świetna robota! Twój nastrój jest na wysokim poziomie. Oto kilka kroków, aby utrzymać ten stan:</p>
    <ul>
        <li><strong>Kontynuuj aktywność fizyczną:</strong> Regularne ćwiczenia wspomagają produkcję endorfin, które poprawiają nastrój. Rozważ dodanie nowych form aktywności, takich jak pływanie, bieganie lub jazda na rowerze.</li>
        <li><strong>Dieta:</strong> Zbilansowana dieta bogata w białko, zdrowe tłuszcze i błonnik pomoże utrzymać energię i nastrój na wysokim poziomie. Rozważ włączenie zdrowych przekąsek, takich jak orzechy czy nasiona.</li>
        <li><strong>Zdrowe relacje:</strong> Dobre relacje społeczne mają długotrwały wpływ na zdrowie psychiczne. Inwestuj w swoje relacje z bliskimi osobami.</li>
        <li><strong>Link do badań:</strong> <a href='https://www.apa.org/monitor/2019/05/celebrate-movement' target='_blank'>Korzyści zdrowotne z aktywności fizycznej</a></li>
    </ul>
    ";
}

// Analiza dodatkowych wskaźników
$energy_level = $moodData['energy_level'];
$stress_level = $moodData['stress_level'];
$sleep_quality = $moodData['sleep_quality'];

$suggestions .= "<h3>Analiza dodatkowych wskaźników:</h3>";

if ($energy_level < 5) {
    $suggestions .= "<p><strong>Poziom energii:</strong> Twój poziom energii jest niski. Zadbaj o odpowiednią ilość snu i rozważ dodanie do diety produktów bogatych w magnez i witaminę B12.</p>";
} else {
    $suggestions .= "<p><strong>Poziom energii:</strong> Twój poziom energii jest w dobrym stanie. Utrzymuj zdrowe nawyki i regularnie się ruszaj.</p>";
}

if ($stress_level > 7) {
    $suggestions .= "<p><strong>Poziom stresu:</strong> Wysoki poziom stresu może prowadzić do problemów zdrowotnych. Zadbaj o regularny odpoczynek, techniki relaksacyjne i równowagę między życiem zawodowym a prywatnym.</p>";
} else {
    $suggestions .= "<p><strong>Poziom stresu:</strong> Twój poziom stresu jest na akceptowalnym poziomie. Kontynuuj techniki zarządzania stresem, takie jak medytacja lub aktywność fizyczna.</p>";
}

if ($sleep_quality < 5) {
    $suggestions .= "<p><strong>Jakość snu:</strong> Twój sen nie jest wystarczająco regenerujący. Spróbuj wprowadzić stały harmonogram snu, unikać ekranów przed snem i wprowadzić rytuały relaksacyjne przed pójściem spać.</p>";
} else {
    $suggestions .= "<p><strong>Jakość snu:</strong> Twoja jakość snu jest dobra. Kontynuuj dobre nawyki i unikaj stresujących czynności przed snem.</p>";
}

?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Sugestie i personalizacja</title>
</head>
<body>
    <div class="suggestions-container">
        <h2>Sugestie poprawy nastroju</h2>
        <div><?php echo $suggestions; ?></div>
    </div>
</body>
</html>
