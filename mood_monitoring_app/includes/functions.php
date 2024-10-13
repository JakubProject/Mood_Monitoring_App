<?php
function add_mood($user_id, $data) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO moods (
        user_id, 
        mood_level, 
        energy_level, 
        stress_level, 
        sleep_quality, 
        motivation_level, 
        anxiety_level, 
        physical_activity, 
        concentration_level, 
        physical_symptoms, 
        happiness_level, 
        day_satisfaction, 
        mood_text
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    // Powiązanie wartości z danymi przesłanymi przez formularz
    $stmt->bind_param("iiiiiiiiissss", 
        $user_id, 
        $data['mood_level'], 
        $data['energy_level'], 
        $data['stress_level'], 
        $data['sleep_quality'], 
        $data['motivation_level'], 
        $data['anxiety_level'], 
        $data['physical_activity'], 
        $data['concentration_level'], 
        $data['physical_symptoms'], 
        $data['happiness_level'], 
        $data['day_satisfaction'], 
        $data['mood_text']
    );
    
    $stmt->execute();
}

function get_moods($user_id) {
    global $conn;
    return $conn->query("SELECT * FROM moods WHERE user_id='$user_id' ORDER BY created_at DESC");
}

function get_last_mood($user_id) {
    global $conn;
    // Zapytanie pobierające ostatni wpis nastroju użytkownika
    $stmt = $conn->prepare("SELECT * FROM moods WHERE user_id = ? ORDER BY created_at DESC LIMIT 1");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc(); // Zwraca dane ostatniego wpisu
}

?>