<?php
$servername = "localhost";
$username = "root";
$password = "Ajinkya_123";
$db = "cadre";

	$uname		=$_POST['name'];	
	$contact	=$_POST['mobile'];
	$email		=$_POST['email'];	
	$password1	=$_POST['password'];
	
$conn = new mysqli($servername, $username, $password, $db);
if ($conn->connect_error) 
{
    die("Connection failed: " . $conn->connect_error);
}

$sql="INSERT INTO cadre (`Name`, `Mobile`, `Email`,`Password`) VALUES ('$uname', '$contact', '$email','$password1');";
if ($conn->query($sql) === TRUE) 
{
header("location:index.html");
   
} 
else 
{
	echo "Registration Unsuccessful <br> Please Register Again"; 
}

$conn->close();

?>
