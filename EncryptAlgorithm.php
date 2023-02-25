<?php
interface EncryptAlgorithm
{
    public function encrypt($pwd);
    public function verify($pwd, $epwd);
}

?>