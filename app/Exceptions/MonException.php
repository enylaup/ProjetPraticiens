<?php

namespace App\Exceptions;
use Exception;

class MonException extends Exception
{
    protected $message = 'Unknow exception';
    private $string;
    protected $code = 0;

    private $trade;

    public function __construct($message, $code =0, Exception $previous = null)
    {
        if(!$message){
            throw new $this('Unknow'. get_class($this));

        }
        parent::__construct($message,$code);

    }

    public function __toString()
    {
        return get_class($this) . "'{$this->message}' in {$this->file}({$this->line})\n"
                                . "{$this->getTraceAsString()}";
    }

}
