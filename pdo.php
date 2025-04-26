<?php 
try{
 $bdd = new PDO("mysql:host=localhost;dbname=users","root","");
}
catch(Exception $e){
 die( "ERROR : ".$e->getMessage());
}
?>