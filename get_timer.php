<?php
require "db.php";

$result = $conn->query("SELECT end_time FROM election_timer ORDER BY id DESC LIMIT 1");
if ($row = $result->fetch_assoc()) {
    echo json_encode(["end_time" => $row['end_time']]);
} else {
    echo json_encode(["end_time" => null]);
}
?>
