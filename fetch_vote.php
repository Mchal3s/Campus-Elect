<?php
require "db.php";

// Query candidate names and vote counts
$query = "
  SELECT c.candidate_name, COUNT(v.vote_id) AS total_votes
  FROM candidates c
  LEFT JOIN votes v ON c.candidate_id = v.candidate_id
  GROUP BY c.candidate_id
  ORDER BY total_votes DESC
";

$result = $conn->query($query);

$candidates = [];
$votes = [];

while ($row = $result->fetch_assoc()) {
    $candidates[] = $row['candidate_name'];
    $votes[] = $row['total_votes'];
}

// Return JSON
echo json_encode([
    "candidates" => $candidates,
    "votes" => $votes
]);
?>
