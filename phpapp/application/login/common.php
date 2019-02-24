<?php
    function passWordMd5($data)
    {
        $salt = '3.141592654';
        $data['password'] = md5($data['password'].$salt);
        return $data;
    }
    
    function isEmail($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }