<?php

namespace JhonatanCF5;

use JhonatanCF5\Helpers\Str;

/**
 * Autenthication class
 */
class Authentication
{
    protected $login;
    protected $tranKey;
    protected $seed;
    protected $additional;
    protected $servicio;
    private static $fileName = "./config_ws.json";
    private static $instance;

    private function __construct($data)
    {
        if(is_array($data)) {
            $this->login = $data['login'];
            $this->seed = date('c');
            $this->tranKey = sha1($this->seed . $data['transactionalKey'], false);
            $this->servicio = $data['WSDL'];
            $this->additional = null;
        }
    }

    public static function getInstance($name=null)
    {
        if( static::$instance == null) {
            static::$instance = new Authentication(static::loadFile($name));
        }

        return static::$instance;
    }

    /**
     * Load file with config web service
     * @param  string $name file name
     */
    private static function loadFile($name=null)
    {
        if($name != null) {
            static::$fileName = $name;
        }

        if(file_exists(static::$fileName)) {
            $str_data = file_get_contents(static::$fileName);
            $data = json_decode($str_data,true);

            return $data;
        }
    }

    public function getServicio()
    {
        return $this->servicio;
    }
}

?>