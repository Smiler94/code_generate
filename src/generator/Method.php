<?php
namespace generator;

class Method extends Generator
{
    const PRIVILEGE_PUBLIC    = 1;
    const PRIVILEGE_PRIVATE   = 2;
    const PRIVILEGE_PROTECTED = 3; 

    private $privileges = array(
        self::PRIVILEGE_PUBLIC    => 'public',
        self::PRIVILEGE_PRIVATE   => 'private',
        self::PRIVILEGE_PROTECTED => 'protected'
    );

    private $privilege = '';
    private $param     = array();
    private $is_static = false;
    private $body      = '';

    public function setStatic($static = false)
    {
        $this->is_static = $static;
        return $this;
    }

    public function setPrivilege($privilege = self::PRIVILEGE_PUBLIC)
    {
        $this->privilege = in_array($privilege, $this->privileges) ? 
                            $privilege : $this->privileges[$privilege];
        return $this;
    }

    public function addBody($body)
    {
        $this->body .= preg_replace('/(?:^|[\r\n]+)(?=[^\r\n])/', 
                    '$0' . str_repeat(self::INDENT, $this->indent), 
                    $body, -1).PHP_EOL;
        return $this;
    }

    public function addParam($name, $value = null, $is_quote = false)
    {
        $key = $is_quote ? '&$'.$name : '$'.$name;
        $this->param[$key] = $value;
        return $this;
    }

    public function generate()
    {
        $this->code = $this->comment.'/'.PHP_EOL
                .($this->privilege ? $this->privilege : 'public').' '
                .($this->is_static ? 'static ' : '')
                .'function '.$this->name.'('.join(', ', array_keys($this->param)).')'.PHP_EOL
                .'{'.PHP_EOL
                .(rtrim($this->body) ? rtrim($this->body).';' : '').PHP_EOL
                .'}'.PHP_EOL;

        return parent::generate();
    }
}