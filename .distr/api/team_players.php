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

function getDbConnection() {
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
    return $mysqli;
}

$mysqli = getDbConnection();

// Получаем параметр team_id из запроса (опционально)
$teamId = isset($_GET['team_id']) ? (int)$_GET['team_id'] : null;

if ($teamId) {
    // Получаем состав конкретной команды
    $query = "SELECT tp.team_id, tp.player_id, tp.team_name, tp.name, tp.username, 
                     p.photo, p.rating, p.goals, p.assists, p.saves, p.mvp
              FROM team_players tp
              LEFT JOIN players p ON tp.player_id = p.id
              WHERE tp.team_id = ?
              ORDER BY tp.name";
    
    $stmt = $mysqli->prepare($query);
    if (!$stmt) {
        http_response_code(500);
        logError("Ошибка подготовки запроса: " . $mysqli->error);
        echo json_encode(["error" => "Ошибка подготовки запроса"]);
        $mysqli->close();
        exit;
    }
    
    $stmt->bind_param("i", $teamId);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    // Получаем весь состав всех команд
    $query = "SELECT tp.team_id, tp.player_id, tp.team_name, tp.name, tp.username, 
                     p.photo, p.rating, p.goals, p.assists, p.saves, p.mvp
              FROM team_players tp
              LEFT JOIN players p ON tp.player_id = p.id
              ORDER BY tp.team_id, tp.name";
    $result = $mysqli->query($query);
}

if (!$result) {
    http_response_code(500);
    logError("Ошибка выполнения запроса: " . $mysqli->error);
    echo json_encode(["error" => "Ошибка выполнения запроса"]);
    if (isset($stmt)) {
        $stmt->close();
    }
    $mysqli->close();
    exit;
}

$teamPlayers = [];
while ($row = $result->fetch_assoc()) {
    // Cast values to appropriate types
    $row['team_id'] = (int)$row['team_id'];
    $row['player_id'] = (int)$row['player_id'];
    $row['rating'] = $row['rating'] !== null ? (float)$row['rating'] : 0.0;
    $row['goals'] = (int)($row['goals'] ?? 0);
    $row['assists'] = (int)($row['assists'] ?? 0);
    $row['saves'] = (int)($row['saves'] ?? 0);
    $row['mvp'] = (int)($row['mvp'] ?? 0);
    $row['photo'] = $row['photo'] ?: 'default.png';
    
    $teamPlayers[] = $row;
}

// Если запрашивалась конкретная команда, группируем по командам
if ($teamId) {
    $response = [
        'team_id' => $teamId,
        'team_name' => !empty($teamPlayers) ? $teamPlayers[0]['team_name'] : '',
        'players' => $teamPlayers
    ];
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
} else {
    // Группируем по командам
    $grouped = [];
    foreach ($teamPlayers as $player) {
        $teamId = $player['team_id'];
        if (!isset($grouped[$teamId])) {
            $grouped[$teamId] = [
                'team_id' => $teamId,
                'team_name' => $player['team_name'],
                'players' => []
            ];
        }
        $grouped[$teamId]['players'][] = $player;
    }
    echo json_encode(array_values($grouped), JSON_UNESCAPED_UNICODE);
}

if (isset($stmt)) {
    $stmt->close();
}
$mysqli->close();
?>

