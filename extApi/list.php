<?php
require_once __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;

// .envの読み込み
$dotenv = Dotenv::createImmutable(__DIR__ . '/../env/');
$dotenv->load();

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

$sql = "SELECT * FROM plan_memo";
$result = $conn->query($sql);
// 結果出力
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $data[] = $row;
  }
  echo json_encode([
    'success' => true,
    'data' => $data
  ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
} else {
  echo "データが見つかりません。";
}

// 接続終了
$conn->close();
?>
