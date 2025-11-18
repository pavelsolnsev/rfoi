<?php
/**
 * Утилита для получения данных с API и сохранения их статически
 * Запустите этот файл один раз, чтобы получить текущие данные
 * и встроить их в block.php
 */

$url = 'https://football.pavelsolntsev.ru/api/players.php?t=' . time();
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($httpCode === 200 && $response) {
    $data = json_decode($response, true);
    if (json_last_error() === JSON_ERROR_NONE && is_array($data)) {
        // Сортируем по рейтингу (убывание)
        usort($data, function($a, $b) {
            return ($b['rating'] ?? 0) - ($a['rating'] ?? 0);
        });
        
        echo "// Данные получены с API\n";
        echo "// Скопируйте массив ниже и замените функцию getSeason2025Data() на статический массив\n\n";
        echo "\$players = " . var_export($data, true) . ";\n";
    } else {
        echo "Ошибка декодирования JSON: " . json_last_error_msg() . "\n";
    }
} else {
    echo "Ошибка получения данных. HTTP код: $httpCode\n";
    echo "Ответ: " . substr($response, 0, 500) . "\n";
}

