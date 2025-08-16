<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Allow-Headers: Content-Type");

require_once __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;

// .envの読み込み
$dotenv = Dotenv::createImmutable(__DIR__ . '/../env/');
$dotenv->load();

if (!isset($_SERVER['PATH_INFO'])) {
  http_response_code(400);
  die('missing id');
}

$path = $_SERVER['PATH_INFO'];
$id = (int)trim($path, '/');

if ($id === null) {
    http_response_code(400);
    echo "Invalid ID";
    exit;
}


// 環境変数を取得
$host = $_ENV['DB_HOST'];
$dbname = $_ENV['DB_DB'];
$user = $_ENV['DB_USER'];
$pass = $_ENV['DB_PASS'];

// DB接続
$conn = new mysqli($host, $user, $pass, $dbname);

// 接続チェック
if ($conn->connect_error) {
  die('接続失敗: ' . $conn->connect_error);
}

$stmt = $conn->prepare("UPDATE plan_memo SET is_delete = 1 WHERE id = ? LIMIT 1");
if (!$stmt) {
  http_response_code(400);
  echo "Prepare failed: " . htmlspecialchars($conn->error);
  exit;
}

$stmt->bind_param("i", $id);
if ($stmt->execute()) {
  http_response_code(400);
  echo "Record with ID {$id} updated successfully.";
} else {
  echo "Error: " . htmlspecialchars($stmt->error);
}

// 接続終了
$conn->close();
?>
