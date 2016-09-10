<?php
require_once ('patterns/startsession.php');
require_once ('vars/connectvars.php');
require_once ('patterns/navmenu.php');

$dbc = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME)
    or die(mysqli_error($dbc));

$query = "SELECT id, name FROM users LIMIT 5";
$data = mysqli_query($dbc, $query);

echo '<table>';
while($row = mysqli_fetch_array($data)){
    if(isset($_SESSION['id'])){
        echo '<td><a href="viewprofile.php?id=' . $row['id'] . '">' . $row['name'] . '</a></td></tr>';
    }
    else{
        echo '<td>' . $row['name'] . '</td></tr>';
    }
}
echo '</table>';

mysqli_close($dbc);