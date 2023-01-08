<?php 
require_once(__DIR__ . '/../../vendor/autoload.php');
require_once __DIR__ . '/MiddlewareController.php';

$redis = new Predis\Client();
$cachedEntry = $redis->get('email');

$t0 = 0;
$t1 = 0;
if($cachedEntry) {
	echo "From Redis Cache \n";
	$t0 = microtime(true) * 1000;
	echo $cachedEntry;
	$t1 = microtime(true) * 1000;
	echo 'Time Taken: '. round(($t1-$t0), 4) . ' ms';
	exit();
}
else {
	$dbhost = $_ENV['DB_HOST'];
	$dbname = $_ENV['DB_DATABASE'];
	$dbuser = $_ENV['DB_USERNAME'];
	$dbpass = $_ENV['DB_PASSWORD'];
	
	$t0 = microtime(true) * 1000;

	$db = new PDO("pgsql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
	$sql = "SELECT * FROM email_logger";
	$data = '';
	foreach ($db->query($sql) as $row) {
		$data .= $row['email_logger_id'] . " | " . $row['email_logger_mail_to'] . " | " . $row['email_logger_mail_subject'] . " | " . $row['email_logger_mail_body'] . " | " . $row['email_logger_created_at'] . " | " . $row['email_logger_sent_at']. "\n";
	}
	$redis->set('email', $data);
	$redis->expire('email', 10);
	echo "From Database \n";
	echo $data;
	$t1 = microtime(true) * 1000;
	echo 'Time Taken: '. round(($t1-$t0), 4) . ' ms';
	exit();
}
?>