<?php
$host = 'localhost';
$dbname = '0d.n0t3';
$user = 'udemy_course';
$password = '1234';

$dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
$pdo = new PDO($dsn, $user, $password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


//**************************************************************************
// $servername = "localhost";
// $user = "udemy_course";
// $pass = "1234";
// $dbname = "users";
//
// // Create connection
// $conn = mysqli_connect($servername, $user, $pass, $dbname);
// // Check connection
// if (!$conn) {
//  die("Connection failed: " . mysqli_connect_error());
// }
//***********************************************************************
// $sql = "INSERT INTO acounts (id, name , password)
// VALUES ('NULL', 'Doe', 'john@example.com')";
//
// if (mysqli_query($conn, $sql)) {
//  echo "New record created successfully";
// } else {
//  echo "Error: " . $sql . "<br>" . mysqli_error($conn);
// }
//
// mysqli_close($conn);
// // Database connection
// // mysqli_connect(); 4 prameters => host,user,pass, dbname -- 1 return=> connection staus
// //نبدأ نعرف الحاجات الي عاوزاها
// $host='localhost';
// $user_name='udemy_course';
// $password='1234';
// $DB_name='users';
// //عاوزه الوقتي الخرج قدامي حلين اعرف متغير او استخدم echo
// //احنا هنعمل متغير عشا الحل التاني بيعمل مشاكل هنا
// $connection=mysqli_connect($host,$user_name,$password,$DB_name);
// // if($connection) echo "connected";
// // else die("Database error  ".mysqli_connect_error()); //وقف الكود لو فيه مشكله هنا مع عرض الغلط
//  if(!$connection) die("Database error  ".mysqli_connect_error());
//  if($connection) die("<br>Database here");

?>
