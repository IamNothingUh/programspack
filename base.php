<?php
// Configura o banco de dados (Cria se não existir)
$db = new PDO('sqlite:database.db');
$db->exec("CREATE TABLE IF NOT EXISTS messages (id INTEGER PRIMARY KEY, name TEXT, msg TEXT, date TEXT)");

// Se receber um POST (nova mensagem)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $msg = htmlspecialchars($_POST['msg']);
    $date = date('d/m/Y H:i');
    
    $stmt = $db->prepare("INSERT INTO messages (name, msg, date) VALUES (?, ?, ?)");
    $stmt->execute([$name, $msg, $date]);
    echo json_encode(['status' => 'success']);
    exit;
}

// Se receber um GET (carregar mensagens)
$messages = $db->query("SELECT * FROM messages ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($messages);
?>