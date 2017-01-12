<?php

namespace JhonatanCF5;

/**
 * Autenthication class
 */
class Authentication extends ModelPlaceToPay
{
    protected $login;
    protected $tranKey;
    protected $seed;
    protected $additional;

    public function __construct($login, $tranKey, $additional = null)
    {
        $this->login = $login;
        $this->seed = date('c');
        $this->tranKey = sha1($this->seed . $tranKey, false);
        $this->additional = ($additional) ? $additional : null;
    }
}

?>