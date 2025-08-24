<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204); // No Content
    exit();
}

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

$rawData = file_get_contents("php://input");
$data = json_decode($rawData, true);
if(!isset($data['summary']) || !isset($data['detail'])){
  http_response_code(400);
  die('invalid param');
}

$summary = $data['summary'];
$detail = $data['detail'];

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

$stmt = $conn->prepare("UPDATE plan_memo SET summary = ?, detail =? WHERE id = ? LIMIT 1");
if (!$stmt) {
  http_response_code(400);
  echo "Prepare failed: " . htmlspecialchars($conn->error);
  exit;
}

$stmt->bind_param("ssi", $summary, $detail, $id);
if ($stmt->execute()) {
  echo json_encode([
    'success' => true,
  ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
} else {
  http_response_code(400);
  echo "Error: " . htmlspecialchars($stmt->error);
}
// 接続終了
$conn->close();
?>
