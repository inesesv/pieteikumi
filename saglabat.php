<?php
// Saņemam datus no HTML formas
$data = json_decode(file_get_contents('php://input'), true);

if (!$data) {
    echo json_encode(['success' => false, 'message' => 'Tukši dati!']);
    exit;
}

$file = 'pieteikums.txt';

// Nolasām esošos pieteikumus, lai pārbaudītu dublikātus
$existingData = [];
if (file_exists($file)) {
    $content = file_get_contents($file);
    if (!empty(trim($content))) {
        $existingData = json_decode($content, true) ?? [];
    }
}

// Pārbaudām, vai laiks pie konkrētā skolotāja jau nav aizņemts
foreach ($existingData as $booking) {
    if ($booking['teacher'] === $data['teacher'] && $booking['time'] === $data['time']) {
        echo json_encode(['success' => false, 'message' => 'Šis laiks pie izvēlētā skolotāja tikko tika aizņemts!']);
        exit;
    }
}

// Pievienojam jauno pieteikumu
$existingData[] = $data;

// Saglabājam atpakaļ pieteikums.txt failā
if (file_put_contents($file, json_encode($existingData, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT))) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Kļūda saglabājot failā!']);
}
?>
