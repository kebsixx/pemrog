<?php
include 'connection.php';

$sql = "SELECT * FROM users";
$result = $db_conn->query($sql);

while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    echo "ID: " . $row['id'] . " - Username: " . $row['username'] . "<br>";
}
