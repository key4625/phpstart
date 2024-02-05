<?php 
$title = "Profilo";
include($_SERVER['DOCUMENT_ROOT'].'/includes/header.php'); 
if (!isset($_SESSION['loggedin'])) {
	header('Location: home');
	exit;
}

$result = getProfileInfo($con);
include($_SERVER['DOCUMENT_ROOT'].'/includes/menu.php'); 
?>
<div class="content">
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