<?php

class EncryptType1 implements EncryptAlgorithm
{
    public function encrypt($pwd)
    {
        $pwd_encypt = password_hash($pwd, PASSWORD_DEFAULT);
        return $pwd_encypt;
    }
    public function verify($pwd, $epwd)
    {
        if (password_verify($pwd, $epwd)){
            return true;
         } else {
            return false;
         }
    }
}

?>