 <?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
require("connectionDB.php");
$encoding = pg_client_encoding($dbconn);
echo "Client encoding is: ", $encoding, "\n";
pg_set_client_encoding($conn, "UTF8");
echo "Client encoding is: ", $encoding, "\n";
if ($_POST) {
    // check action
	$action = $_POST['action'];
	if(strcmp($action, 'register') == 0){
		echo "action = " .$_POST['action'];
		echo "\n\n";
		// get post body content
		$content = file_get_contents('php://input');
		
		// parse JSON
		$users = json_decode($content, true);
		echo $users ."\n";
		$username = $users['email'];
		$name = $users['name'];
		$password = $users['password'];
		$email    = $users['email'];
		
		//check duplicate $email
		$sql_search     = "SELECT email FROM users WHERE email = '$email' ";
		$rearch_result  = pg_query($dbconn, $sql_search);
		$rowcount = pg_num_rows($rearch_result);
		if ($rowcount == 1) {
		echo json_encode(['status' => 'error','message' => 'ไม่สามารถลงทะเบียนได้ อีเมลนี้มีผู้ใช้แล้ว']);
		exit;
		}
		
		//insert data
		$sql    = "INSERT INTO USERS (USERNAME,NAME,PASSWORD,EMAIL) VALUES ($username,$name,$password,$email);";
		$result = pg_query($dbconn, $sql);
		
		if ($result) {
		echo json_encode(['status' => 'ok','message' => 'บันทึกข้อมูล เรียบร้อย']);
		} else {
		echo json_encode(['status' => 'error','message' => 'เกิดข้อผิดพลาดในการบนัทกึข้อมลู ']);
		}
	}
	echo "\n200";
}
pg_close($dbconn);
?>
