<?php

// Database connection
require __DIR__ . '/database.php';
$db = DB();

$stmt = $db->prepare("SELECT * FROM dbo.SY_0600");
$stmt->execute();
$query = $stmt->fetch(PDO::FETCH_ASSOC);

echo $query['Service']; 
// echo $query['attributename']; 
// note - use while on $query to display multiple rows

?>