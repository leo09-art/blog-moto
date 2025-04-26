
<?php 
include 'pdo.php';
if(isset($_GET['email']))
    $email = $_GET['email'];
$req = $bdd->prepare('SELECT password from user where email=?');
$req->execute(array($email)) ;
$user = $req->fetch();
if($user)
$password = $user['password'];
else
$password=null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>reveler password</title>
</head>
<body>
    <script>
        console.log(<?php echo json_encode($_GET['email']); ?>);
        console.log(<?php echo json_encode($password);?>);
    </script>
    <p>code en log</p>
</body>
</html>