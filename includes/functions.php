<!-- contains command function which may be used multiple time  -->

<?php
function redirect($url)
{
    header("Location: $url");
}

function isLoggedIn()
{
    return isset($_SESSION['user_id']);
}

function requireLogin()
{
    if (!isLoggedIn()) {
        redirect("/auth/login.php");
    }
}
?>