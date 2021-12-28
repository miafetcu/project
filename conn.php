<?php
function OpenCon()
{
   $hostname="localhost";
   $username="root";
   $password="root";
   $databasename="Harry_Potter";
   $port=8889;
   $conn=mysqli_connect($hostname,$username,$password,$databasename,$port) or die("Connect failed: %s\n". $conn -> error);
   
   return $conn;
}

function CloseCon($conn)
{
   $conn -> close();
}
?>