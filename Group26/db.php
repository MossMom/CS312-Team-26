<!-- db.php holds your database connection. Every page that reads from or writes to the database should include this file at the top using require. -->
 <?php
/*
 * Fill in your credentials below
 * -------------------------------------------------------
 * Replace YOUR_NETID with your CS username.
 * Replace YOUR_PASSWORD with your CS Linux password.

 * NOTE: DB_USER and DB_NAME are always the same value — your NetID.
 */

define('DB_HOST', 'helmi.cs.colostate.edu');
define('DB_USER', 'username');
define('DB_PASS', 'password');
define('DB_NAME', 'username');

define('SSL_CERT', '/usr/local/ssl/server-cert.pem');
define('SSL_CA',   '/usr/local/ssl/ca-cert.pem');

$conn = mysqli_init();
if (!$conn) {
    die('mysqli_init failed.');
}
$conn->ssl_set(SSL_CERT, NULL, SSL_CA, NULL, NULL);
mysqli_options($conn, MYSQLI_OPT_SSL_VERIFY_SERVER_CERT, true);
if (!mysqli_real_connect($conn, DB_HOST, DB_USER, DB_PASS, DB_NAME)) {
    die('Connection failed: ' . mysqli_connect_error());
}
?>