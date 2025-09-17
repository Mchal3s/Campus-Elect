<?php
require "db.php";

// Total votes
$totalVotes = $conn->query("SELECT COUNT(*) as total FROM votes")->fetch_assoc()['total'];

// Active elections (example: distinct elections with votes)
$activeElections = $conn->query("SELECT COUNT(DISTINCT election_id) as total FROM votes")->fetch_assoc()['total'];

// Unique voters
$uniqueVoters = $conn->query("SELECT COUNT(DISTINCT voter_id) as total FROM votes")->fetch_assoc()['total'];

// Votes per candidate
$candidates = [];
$result = $conn->query("SELECT candidate_id, COUNT(*) as votes FROM votes GROUP BY candidate_id");
while ($row = $result->fetch_assoc()) {
    $candidates[] = [
        "name" => "Candidate " . $row['candidate_id'], // Replace with JOIN to candidates table if exists
        "votes" => (int)$row['votes']
    ];
}

// Votes per position
$positions = [];
$result = $conn->query("SELECT position_id, COUNT(*) as votes FROM votes GROUP BY position_id");
while ($row = $result->fetch_assoc()) {
    $positions[] = [
        "name" => "Position " . $row['position_id'], // Replace with JOIN to positions table if exists
        "votes" => (int)$row['votes']
    ];
}

echo json_encode([
    "totalVotes" => $totalVotes,
    "activeElections" => $activeElections,
    "uniqueVoters" => $uniqueVoters,
    "candidates" => $candidates,
    "positions" => $positions
]);
