<?php
namespace generator;

class Property extends Generator
{
    const PRIVILEGE_PUBLIC    = 1;
    const PRIVILEGE_PRIVATE   = 2;
    const PRIVILEGE_PROTECTED = 3; 

    private $privileges = array(
        self::PRIVILEGE_PUBLIC    => 'public',
        self::PRIVILEGE_PRIVATE   => 'private',
        self::PRIVILEGE_PROTECTED => 'protected'
    );

    protected $name    = '';
    private $value     = '';
    private $is_static = false;
    private $privilege = '';

    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }

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
    
    public function generate()
    {
        $this->code = $this->comment.'/'.PHP_EOL
                .($this->privilege ? $this->privilege : 'public').' '
                .($this->is_static ? 'static ' : '')
                .'$'.$this->name
                .' = '.($this->value ? $this->value : '\'\';')
                .PHP_EOL;

        return parent::generate();
    }
}