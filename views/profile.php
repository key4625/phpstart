<?php 

include($_SERVER['DOCUMENT_ROOT'].'/includes/header-script.php');
if (!isset($_SESSION['loggedin'])) {
	header('Location: login');
	exit;
} else {
    $session_user = htmlspecialchars($_SESSION['name'] ?? '', ENT_QUOTES, 'UTF-8');
    $session_id = htmlspecialchars($_SESSION['id'] ?? '');
}

$result = getProfileInfo($con);
$title = "Profilo ".$_SESSION['name'];
include($_SERVER['DOCUMENT_ROOT'].'/includes/header.php');
include($_SERVER['DOCUMENT_ROOT'].'/includes/menu.php'); 
?>
<div class="container">
    <h2>Profile Page</h2>
    <div>
        <p>Your account details are below:</p>
        <table>
            <tr>
                <td>Username:</td>
                <td><?=$_SESSION['name']?></td>
            </tr>
            <tr>
                <td>Password:</td>
                <td><?=$result[0]?></td>
            </tr>
            <tr>
                <td>Email:</td>
                <td><?=$result[1]?></td>
            </tr>
        </table>
    </div>
</div>
<?php include($_SERVER['DOCUMENT_ROOT'].'/includes/footer.php'); ?>