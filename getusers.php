<?php
// Connecting, selecting database
 $dbconn = pg_connect("host=ec2-54-243-130-33.compute-1.amazonaws.com dbname=d55plguu27h70h user=tdybpzwmmffehg password=52eaa707ede4a48a7a1dfe5d9d160fc07e7a3fe2a84597f0c53fdef040bb7d85")
    or die('Could not connect: ' . pg_last_error());

// Performing SQL query
$query = 'SELECT * FROM users';
$result = pg_query($query) or die('Query failed: ' . pg_last_error());

// Printing results in HTML=
echo "<table>\n";
while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) {
    echo "\t\t<tr>\n";
    $i = 0;
    foreach ($line as $col_value) {
        echo "\t\t\t\t<td>$i . $col_value</td>\n";
        $i++;
    }
    echo "\t\t</tr>\n";
}
echo "</table>\n";

// Free resultset
pg_free_result($result);

// Closing connection
pg_close($dbconn); 

?>
