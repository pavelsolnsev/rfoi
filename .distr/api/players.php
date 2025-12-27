<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type');
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Pragma: no-cache');
header('Expires: Thu, 01 Jan 1970 00:00:00 GMT');

function logError($message) {
    error_log(date('[Y-m-d H:i:s] ') . $message . PHP_EOL, 3, 'error.log');
}

$host = 'pavels3f.beget.tech';
$user = 'pavels3f_fball';
$password = 'Spas3082330275!';
$database = 'pavels3f_fball';

$maxRetries = 3;
$retryDelay = 1;
$attempt = 0;
$mysqli = null;

$startTime = microtime(true);
while ($attempt < $maxRetries) {
    $mysqli = new mysqli($host, $user, $password, $database);
    if (!$mysqli->connect_error) {
        break;
    }
    $attempt++;
    logError("Попытка $attempt: Ошибка соединения с базой данных: " . $mysqli->connect_error);
    if ($attempt < $maxRetries) {
        sleep($retryDelay);
    }
}

if ($mysqli->connect_error) {
    http_response_code(503);
    logError("Не удалось подключиться к базе данных после $maxRetries попыток");
    echo json_encode(["error" => "Сервер временно недоступен, попробуйте снова"]);
    exit;
}

$connectTime = microtime(true) - $startTime;
logError("Время подключения к базе данных: $connectTime секунд");

$mysqli->set_charset("utf8mb4");

$query = "SELECT name, username, goals, gamesPlayed, wins, draws, losses, rating, photo FROM players";
$result = $mysqli->query($query);

if (!$result) {
    http_response_code(500);
    logError("Ошибка выполнения запроса: " . $mysqli->error);
    echo json_encode(["error" => "Ошибка выполнения запроса"]);
    $mysqli->close();
    exit;
}

$players = [];
while ($row = $result->fetch_assoc()) {
    // Cast values to appropriate types
    $row['goals'] = (int)$row['goals'];
    $row['gamesPlayed'] = (int)$row['gamesPlayed'];
    $row['wins'] = (int)$row['wins'];
    $row['draws'] = (int)$row['draws'];
    $row['losses'] = (int)$row['losses'];
    $row['rating'] = (float)$row['rating'];
    $row['photo'] = $row['photo'] ?: 'default.png';

    // Check if all stats are zero
    if (!($row['goals'] === 0 &&
          $row['gamesPlayed'] === 0 &&
          $row['wins'] === 0 &&
          $row['draws'] === 0 &&
          $row['losses'] === 0 &&
          $row['rating'] === 0.0)) {
        $players[] = $row;
    }
}

echo json_encode($players, JSON_UNESCAPED_UNICODE);
$mysqli->close();
?>