<?php
// Отключаем вывод ошибок на экран
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);

// Очищаем буфер вывода
ob_start();

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type');
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Pragma: no-cache');
header('Expires: Thu, 01 Jan 1970 00:00:00 GMT');

function logError($message) {
    $logFile = __DIR__ . '/error.log';
    error_log(date('[Y-m-d H:i:s] ') . $message . PHP_EOL, 3, $logFile);
}

function sendJsonResponse($data, $statusCode = 200) {
    ob_clean();
    http_response_code($statusCode);
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit;
}

function getDbConnection() {
    $host = 'pavels3f.beget.tech';
    $user = 'pavels3f_fball';
    $password = 'Spas3082330275!';
    $database = 'pavels3f_fball';

    $maxRetries = 3;
    $retryDelay = 1;
    $attempt = 0;
    $pdo = null;

    $startTime = microtime(true);
    
    // Проверяем доступность PDO
    if (!extension_loaded('pdo') || !extension_loaded('pdo_mysql')) {
        throw new Exception("Расширение PDO MySQL не установлено");
    }
    
    $dsn = "mysql:host=$host;dbname=$database;charset=utf8mb4";
    
    while ($attempt < $maxRetries) {
        try {
            $pdo = new PDO($dsn, $user, $password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false
            ]);
            break;
        } catch (PDOException $e) {
            $attempt++;
            logError("Попытка $attempt: Ошибка соединения с базой данных: " . $e->getMessage());
            if ($attempt < $maxRetries) {
                sleep($retryDelay);
            }
        }
    }

    if (!$pdo) {
        logError("Не удалось подключиться к базе данных после $maxRetries попыток");
        throw new Exception("Ошибка подключения к базе данных");
    }

    $connectTime = microtime(true) - $startTime;
    logError("Время подключения к базе данных: $connectTime секунд");

    return $pdo;
}

try {
    $pdo = getDbConnection();

    // Получаем параметр team_id из запроса (опционально)
    $teamId = isset($_GET['team_id']) ? (int)$_GET['team_id'] : null;

    if ($teamId) {
        // Получаем состав конкретной команды
        $query = "SELECT tp.team_id, tp.player_id, tp.team_name, tp.name, tp.username, tp.is_captain,
                         p.photo, p.rating, p.goals, p.assists, p.saves, p.mvp
                  FROM team_players tp
                  LEFT JOIN players p ON tp.player_id = p.id
                  WHERE tp.team_id = ?
                  ORDER BY tp.name";
        
        $stmt = $pdo->prepare($query);
        $stmt->execute([$teamId]);
        $rows = $stmt->fetchAll();
    } else {
        // Получаем весь состав всех команд
        // Включаем is_main_player для определения текущей команды игрока
        $query = "SELECT tp.team_id, tp.player_id, tp.team_name, tp.name, tp.username, tp.tournament_count, tp.is_captain, tp.is_main_player,
                         p.photo, p.rating, p.goals, p.assists, p.saves, p.mvp
                  FROM team_players tp
                  LEFT JOIN players p ON tp.player_id = p.id
                  ORDER BY tp.team_id, tp.name";
        $stmt = $pdo->query($query);
        $rows = $stmt->fetchAll();
    }

    $teamPlayers = [];
    foreach ($rows as $row) {
        // Cast values to appropriate types
        $row['team_id'] = (int)$row['team_id'];
        $row['player_id'] = (int)$row['player_id'];
        $row['tournament_count'] = (int)($row['tournament_count'] ?? 0);
        $row['is_captain'] = (bool)($row['is_captain'] ?? false);
        // Правильное приведение is_main_player: проверяем на 1, '1', true
        // Сохраняем исходное значение для отладки
        $row['is_main_player_raw'] = $row['is_main_player'] ?? null;
        $row['is_main_player'] = isset($row['is_main_player']) && ($row['is_main_player'] == 1 || $row['is_main_player'] === '1' || $row['is_main_player'] === true);
        $row['rating'] = $row['rating'] !== null ? (float)$row['rating'] : 0.0;
        $row['goals'] = (int)($row['goals'] ?? 0);
        $row['assists'] = (int)($row['assists'] ?? 0);
        $row['saves'] = (int)($row['saves'] ?? 0);
        $row['mvp'] = (int)($row['mvp'] ?? 0);
        $row['photo'] = $row['photo'] ?: 'default.png';
        
        // Логируем все записи Павла Солнцева
        if ($row['player_id'] == 312571900) {
            logError("DEBUG: Запись Павла Солнцева из БД - team_id: {$row['team_id']}, team_name: {$row['team_name']}, is_main_player_raw: " . var_export($row['is_main_player_raw'], true) . ", is_main_player: " . var_export($row['is_main_player'], true));
        }
        
        $teamPlayers[] = $row;
    }
    
    logError("DEBUG: Всего записей из БД: " . count($teamPlayers));

    // Если запрашивалась конкретная команда, группируем по командам
    if ($teamId) {
        $response = [
            'team_id' => $teamId,
            'team_name' => !empty($teamPlayers) ? $teamPlayers[0]['team_name'] : '',
            'players' => $teamPlayers
        ];
        sendJsonResponse($response, 200);
    } else {
        // Определяем, какие записи показывать для каждого игрока
        // Если is_main_player = 1, показываем только эту запись
        // Если is_main_player = 0, показываем все записи для этого игрока
        $playersToShow = [];
        $playersWithMainTeam = []; // Игроки, у которых есть is_main_player = 1
        $playersMainTeamData = []; // Данные игроков с is_main_player = 1
        
        // Сначала собираем всех игроков с is_main_player = 1
        foreach ($teamPlayers as $player) {
            if ($player['is_main_player']) {
                $playerId = $player['player_id'];
                $playersWithMainTeam[$playerId] = true;
                // Сохраняем данные игрока с is_main_player = 1
                $playersMainTeamData[$playerId] = $player;
                logError("DEBUG: Найден игрок с is_main_player=1: ID {$playerId} ({$player['name']}) в команде {$player['team_id']} ({$player['team_name']})");
            }
        }
        
        logError("DEBUG: Всего игроков с is_main_player = 1: " . count($playersWithMainTeam));
        
        // Теперь формируем список игроков для отображения
        foreach ($teamPlayers as $player) {
            $playerId = $player['player_id'];
            
            // Если у игрока есть is_main_player = 1, пропускаем все его записи
            // (мы добавим только запись с is_main_player = 1 в конце)
            if (isset($playersWithMainTeam[$playerId])) {
                logError("DEBUG: Пропущена запись игрока ID {$playerId} ({$player['name']}) в команде {$player['team_id']} ({$player['team_name']}) - есть is_main_player=1, текущее значение is_main_player: " . var_export($player['is_main_player'], true));
                continue;
            } else {
                // Если у игрока нет is_main_player = 1, показываем все его записи
                $playersToShow[] = $player;
                // Логируем для отладки конкретного игрока
                if ($playerId == 312571900) {
                    logError("DEBUG: Добавлена запись Павла Солнцева ID {$playerId} в команде {$player['team_id']} ({$player['team_name']}) - нет is_main_player=1, значение: " . var_export($player['is_main_player'], true));
                }
            }
        }
        
        // Добавляем всех игроков с is_main_player = 1
        foreach ($playersMainTeamData as $player) {
            $playersToShow[] = $player;
            logError("DEBUG: Добавлен игрок с is_main_player=1: ID {$player['player_id']} ({$player['name']}) в команду {$player['team_id']} ({$player['team_name']})");
        }
        
        logError("DEBUG: Всего игроков для отображения: " . count($playersToShow));
        
        // Группируем игроков по командам
        // Используем team_name для группировки, чтобы игроки попадали в правильную команду
        // даже если team_id не совпадает с team_name
        $grouped = [];
        foreach ($playersToShow as $player) {
            $teamName = $player['team_name'];
            // Используем team_name как ключ для группировки
            if (!isset($grouped[$teamName])) {
                $grouped[$teamName] = [
                    'team_id' => $player['team_id'],
                    'team_name' => $teamName,
                    'players' => []
                ];
            }
            $grouped[$teamName]['players'][] = $player;
        }
        sendJsonResponse(array_values($grouped), 200);
    }
    
} catch (PDOException $e) {
    $errorMsg = "Ошибка PDO: " . $e->getMessage();
    logError($errorMsg);
    sendJsonResponse(["error" => "Ошибка базы данных: " . $e->getMessage()], 500);
} catch (Exception $e) {
    $errorMsg = "Исключение: " . $e->getMessage();
    logError($errorMsg);
    sendJsonResponse(["error" => "Внутренняя ошибка сервера: " . $e->getMessage()], 500);
} catch (Error $e) {
    $errorMsg = "Фатальная ошибка: " . $e->getMessage();
    logError($errorMsg);
    sendJsonResponse(["error" => "Фатальная ошибка: " . $e->getMessage()], 500);
}
?>

