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

    // Сначала проверяем, существует ли поле trophies
    try {
        $checkFieldQuery = "SHOW COLUMNS FROM teams LIKE 'trophies'";
        $fieldCheck = $pdo->query($checkFieldQuery);
        $hasTrophiesField = $fieldCheck && $fieldCheck->rowCount() > 0;
    } catch (PDOException $e) {
        logError("Ошибка проверки поля trophies: " . $e->getMessage());
        $hasTrophiesField = false;
    }

    // Формируем запрос в зависимости от наличия поля
    if ($hasTrophiesField) {
        $query = "SELECT id, name, tournament_count, points, wins, draws, losses, goals_scored, goals_conceded, trophies 
                  FROM teams 
                  ORDER BY points DESC, wins DESC, goals_scored DESC";
    } else {
        $query = "SELECT id, name, tournament_count, points, wins, draws, losses, goals_scored, goals_conceded 
                  FROM teams 
                  ORDER BY points DESC, wins DESC, goals_scored DESC";
    }
    
    logError("Выполняем запрос: " . $query);
    $stmt = $pdo->query($query);
    $rows = $stmt->fetchAll();

    $teams = [];
    foreach ($rows as $row) {
        // Cast values to appropriate types
        $row['id'] = (int)$row['id'];
        $row['tournament_count'] = (int)$row['tournament_count'];
        $row['points'] = (int)$row['points'];
        $row['wins'] = (int)$row['wins'];
        $row['draws'] = (int)$row['draws'];
        $row['losses'] = (int)$row['losses'];
        $row['goals_scored'] = (int)$row['goals_scored'];
        $row['goals_conceded'] = (int)$row['goals_conceded'];
        // Если поле trophies отсутствует, устанавливаем 0
        $row['trophies'] = isset($row['trophies']) ? (int)$row['trophies'] : 0;
        
        $teams[] = $row;
    }

    logError("Успешно получено команд: " . count($teams));
    sendJsonResponse($teams, 200);
    
} catch (PDOException $e) {
    $errorMsg = "Ошибка PDO: " . $e->getMessage();
    logError($errorMsg);
    sendJsonResponse(["error" => "Ошибка базы данных: " . $e->getMessage()], 500);
} catch (Exception $e) {
    $errorMsg = "Исключение: " . $e->getMessage() . " | Trace: " . $e->getTraceAsString();
    logError($errorMsg);
    sendJsonResponse(["error" => "Внутренняя ошибка сервера: " . $e->getMessage()], 500);
} catch (Error $e) {
    $errorMsg = "Фатальная ошибка: " . $e->getMessage() . " | Trace: " . $e->getTraceAsString();
    logError($errorMsg);
    sendJsonResponse(["error" => "Фатальная ошибка: " . $e->getMessage()], 500);
}
?>

