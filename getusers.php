<?php
// Connecting, selecting database
 $dbconn = pg_connect("host=ec2-54-243-130-33.compute-1.amazonaws.com dbname=d55plguu27h70h user=tdybpzwmmffehg password=52eaa707ede4a48a7a1dfe5d9d160fc07e7a3fe2a84597f0c53fdef040bb7d85")
    or die('Could not connect: ' . pg_last_error());

// Performing SQL query
$query = 'SELECT * FROM users';
$result = pg_query($query) or die('Query failed: ' . pg_last_error());

// Printing results in HTML
$data = array();
while ($row = pg_fetch_assoc($result)) {
                 array_push($data, array('id' => $row['id']));
                 array_push($data, array('username' => $row['username']));
                 array_push($data, array('name' => $row['name']));
                 array_push($data, array('password' => $row['password']));
                 array_push($data, array('email' => $row['email']));
}
    $json = json_encode($data);
    echo $json;
// Free resultset
pg_free_result($result);

// Closing connection
pg_close($dbconn); 

?>
