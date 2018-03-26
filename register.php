 <?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
require("connectionDB.php");
$encoding = pg_client_encoding($dbconn);
echo "Client encoding is: ", $encoding. "</br>";
pg_set_client_encoding($dbconn, "UTF8");
echo "Client encoding is: ", $encoding. "</br>";
if ($_POST) {
    // check action
	$action = $_POST['action'];
	if(strcmp($action, 'register') == 0){
		echo "action = ", $_POST['action']. "</br>";

		// get post body content
		//$content = file_get_contents('php://input');
		
		// parse JSON
		//$users = json_decode($content, true);

		$username = $_POST['email'];
		$name = $_POST['name'];
		$password = $_POST['password'];
		$email    = $_POST['email'];
		
		//check duplicate $email
		$sql_search     = "SELECT email FROM users WHERE email = '$email';";
		$rearch_result  = pg_query($dbconn, $sql_search);
		$rowcount = pg_num_rows($rearch_result);
		if ($rowcount == 1) {
		echo json_encode(['status' => 'error','message' => 'Duplicate email! $email']);
		exit;
		}
		
		//insert data
		$sql    = "INSERT INTO USERS (USERNAME,NAME,PASSWORD,EMAIL) VALUES ('$username','$name','$password','$email');";
		$result = pg_query($dbconn, $sql);
		
		if ($result) {
		echo json_encode(['status' => 'ok','message' => $sql]);
		} else {
		echo json_encode(['status' => 'error','message' => "Exception! '$rowcount' '$email'"]);
		}
	}
	echo "</br>200";
}
pg_close($dbconn);
?>
