 <?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
header('Content-Type: application/json');
require("connectionDB.php");
pg_set_client_encoding($dbconn, "UTF8");

//if ($_POST) {

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // check action
	//$action = $_POST['action'];
	//if(strcmp($action, 'register') == 0){
		// get post body content
		$content = file_get_contents('php://input');
		
		// parse JSON
		$users = json_decode($content, true);
		echo json_encode($users, JSON_FORCE_OBJECT);
		$action = $users['action'];
		$username = $users['$username'];
		$name = $users['name'];
		$password = $users['password'];
		$email    = $users['email'];
		
		// check action
		if(strcmp($action, 'register') == 0){
			//check duplicate $email
			$sql_search     = "SELECT email FROM users WHERE email = '$email';";
			$rearch_result  = pg_query($dbconn, $sql_search);
			$rowcount = pg_num_rows($rearch_result);
			if ($rowcount == 1) {
				echo json_encode(['status' => 'error','message' => "ไม่สามารถลงทะเบียนได้ อีเมลนี้มีผู้ใช้แล้ว"], JSON_FORCE_OBJECT);
			exit;
			}

			//insert data
			$sql    = "INSERT INTO USERS (USERNAME,NAME,PASSWORD,EMAIL) VALUES ('$username','$name','$password','$email');";
			$result = pg_query($dbconn, $sql);

			if ($result) {
				echo json_encode(['status' => 'ok','message' => "บันทึกข้อมูลเรียบร้อย"], JSON_FORCE_OBJECT);
			} else {
				echo json_encode(['status' => 'error','message' => "เกิดข้อผิดพลาดในการบันทึกข้อมูล"], JSON_FORCE_OBJECT);
			}
		}
}
pg_close($dbconn);
?>
