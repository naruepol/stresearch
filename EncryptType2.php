<?php

class EncryptType2 implements EncryptAlgorithm
{
    public function encrypt($pwd)
    {
        $pwd_encypt = md5($pwd);
        return $pwd_encypt;
    }
    public function verify($pwd, $epwd)
    {
        if (md5($pwd) == $epwd){
            return true;
         } else {
            return false;
         }
    }
}

?>