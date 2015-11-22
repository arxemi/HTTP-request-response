<!DOCTYPE html>
<html>
<head>
	<title>HTTP request</title>
</head>
<body>
<h3>PHP page that try to connect with a web page and allows you to enter the method of HTTP request</h3>
<form action="" method="GET">
	Put in the website URL<input type="text" name="addr"><br>
	Put in the request method<input type="text" name="mth"><br>
	<input type="submit" value="Try to connect"><br>
</form>

<?php
	if(isset($_GET['addr'])){
		error_reporting(E_ALL);

		echo "<h2>TCP/IP Connection</h2>\n";

		$service_port = getservbyname('www', 'tcp');

		/* Get the IP address for the target host. */
		$address = gethostbyname($_GET['addr']);

		/* Create a TCP/IP socket. */
		$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
		if ($socket === false) {
		    echo "socket_create() failed: reason: " . socket_strerror(socket_last_error()) . "\n<br>";
		} else {
		    echo "OK.\n<br>";
		}

		echo "Attempting to connect to '$address' on port '$service_port'...<br>";
		$result = socket_connect($socket, $address, $service_port);
		if ($result === false) {
		    echo "socket_connect() failed.\nReason: ($result) " . socket_strerror(socket_last_error($socket)) . "\n<br>";
		} else {
		    echo "OK.\n<br>";
		}

		$in = $_GET['mth']." / HTTP/1.1\r\n";
		$in .= "User-ugent: Prova 1.0\r\n";
		$in .= "Host: $address\r\n";
		$in .= "Connection: Close\r\n\r\n";
		$out = '';

		echo "Sending HTTP ".$_GET['mth']." request...<br>";
		socket_write($socket, $in, strlen($in));
		echo "OK.\n<br>";

		echo "Reading response:\n\n<br>";
		while ($out = socket_read($socket, 2048, PHP_NORMAL_READ)) {
		    echo "$out<br>";
		}

		echo "Closing socket...<br>";
		socket_close($socket);
		echo "OK.\n\n<br>";
	}
?>

</body>
</html>
