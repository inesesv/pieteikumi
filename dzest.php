<?php
$file = 'pieteikums.txt';
if (file_put_contents($file, json_encode([]))) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false]);
}
?>
