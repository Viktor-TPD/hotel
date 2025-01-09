<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Update room prices in database
    if (isset($_POST['room_prices']) && is_array($_POST['room_prices'])) {
        foreach ($_POST['room_prices'] as $roomId => $newPrice) {
            $query = $db->prepare("UPDATE rooms SET price = :price WHERE id = :id");
            $query->bindParam(':price', $newPrice, PDO::PARAM_INT);
            $query->bindParam(':id', $roomId, PDO::PARAM_INT);
            $query->execute();
        }
    }
}

header('Location: ' . BASE_URL . '/admin.php');
exit;
