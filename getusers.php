<?php
// Connecting, selecting database
require("connectionDB.php");

// Performing SQL query
$query = 'SELECT * FROM users';
$result = pg_query($query) or die('Query failed: ' . pg_last_error());
// Printing results in HTML
$data = array();
while ($row = pg_fetch_assoc($result)) {
    array_push($data, array(
        'id' => $row['id'],
        'username' => $row['username'],
        'name' => $row['name'],
        'password' => $row['password'],
        'email' => $row['email']
    ));
}
$json = json_encode($data);
echo $json;
// Free resultset
pg_free_result($result);
// Closing connection
pg_close($dbconn);
?>
