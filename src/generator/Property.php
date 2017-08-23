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
    
    public function parseValue()
    {
        if ($this->value) {
            $type =  gettype($this->value);
            switch($type) {
                case 'array':
                    $value = 'array(';
                    // 判断是索引数组还是关联数组
                    if (array_keys($this->value) !== range(0, count($this->value) - 1)) {
                        foreach ($this->value as $key => $val) {
                            $value .= "'".$key."' => '".$val."', ";
                        }
                        $value = rtrim($value, ', ').')';
                    } else {
                        $value .= "'".join("', '", $this->value)."')";
                    }
                    break;
                case 'string':
                    $value = "'".$this->value."'";
                    break;
                case 'boolean':
                case 'integer':
                case 'double':
                case 'NULL':
                    $value = $this->value;
                    break;
                default:
                    $value = "'".$this->value."'";
                    break;
            }
        } else {
            $value = "''";
        }
        return $value;
    }

    public function generate()
    {
        $this->code = $this->comment.'/'.PHP_EOL
                .($this->privilege ? $this->privilege : 'public').' '
                .($this->is_static ? 'static ' : '')
                .'$'.$this->name
                .' = '.$this->parseValue().';'
                .PHP_EOL;

        return parent::generate();
    }
}