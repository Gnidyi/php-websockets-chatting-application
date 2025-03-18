<?php
require 'ChatRooms.php';

$user_id = $_GET['user_id'];

$chat = new ChatRooms();
$query = "SELECT ban_until FROM user_bans WHERE user_id = :user_id";
$stmt = $chat->getConnection()->prepare($query);
$stmt->execute(['user_id' => $user_id]);
$banInfo = $stmt->fetch(PDO::FETCH_ASSOC);

$response = ['banned' => false];

if ($banInfo) {
    $banUntil = $banInfo['ban_until'];
    if ($banUntil && strtotime($banUntil) > time()) {
        $response['banned'] = true;
    }
}

echo json_encode($response);
?>
