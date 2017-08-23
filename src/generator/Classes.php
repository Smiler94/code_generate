<?php
namespace generator;

class Classes extends Generator
{
    private $namespace = ''; // 命名空间
    private $traits = array(); // 使用的类
    private $is_abstract = false; // 是否抽象类
    private $extends = ''; // 继承的类
    private $implements = array(); // 接口

    private $propertys = array(); // 属性
    private $methods = array(); // 方法
    
    /**
     * 设置命名空间
     *
     * @author 林祯 2017-08-17T17:01:45
     * @param  string $namespace 命名空间名称
     */
    public function setNameSpace($namespace)
    {
        $this->namespace = $namespace;
        return $this;
    }
    /**
     * 添加使用的类
     *
     * @author 林祯 2017-08-17T17:02:37
     * @param  string $trait 使用的类
     */
    public function addTrait($trait)
    {
        $this->traits[] = $trait;
        return $this;
    }
    /**
     * 设置是否为抽象类
     *
     * @author 林祯 2017-08-17T17:02:58
     * @param  boolean $abstract 
     */
    public function setAbstract($abstract = false)
    {
        $this->is_abstract = $abstract;
        return $this;
    }
    /**
     * 添加继承的类
     *
     * @author 林祯 2017-08-17T17:03:27
     * @param  string $extend 继承的类名
     */
    public function addExtend($extend)
    {
        $this->extends[] = $extend;
        return $this;
    }
    /**
     * 添加接口
     *
     * @author 林祯 2017-08-17T17:03:49
     * @param  string $implement 接口名
     */
    public function addImplement($implement)
    {
        $this->implements[] = $implement;
        return $this;
    }
    /**
     * 添加属性
     *
     * @author 林祯 2017-08-17T17:04:15
     * @param  string $name  属性名
     * @param  string $value 初始值
     */
    public function addProperty($name, $value)
    {
        return $this->propertys[] = (new Property($name))->setValue($value)->indent(1);
    }
    /**
     * 添加方法
     *
     * @author 林祯 2017-08-17T17:04:39
     * @param  string $name 方法名
     */
    public function addMethod($name)
    {
        return $this->methods[] = (new Method($name))->indent(1);
    }
    /**
     * 生成代码
     *
     * @author 林祯 2017-08-17T17:10:49
     * @return string 生成的代码
     */
    public function generate()
    {
        if ($this->propertys) {
            $propertys = '';
            foreach($this->propertys as $val) {
                $propertys .= $val->generate(); // 生成属性代码
            }
        }

        if ($this->methods) {
            $methods = '';
            foreach($this->methods as $val) {
                $methods .= $val->generate(); // 生成方法代码
            }
        }

        if ($this->traits) {
            $traits = '';
            foreach($this->traits as $val) {
                $traits .= 'use '.$val.PHP_EOL;
            }
        }

        if ($this->extends) {
            $extends = join(',', $this->extends);
        }
        if ($this->implements) {
            $implements = join(',', $this->implements);
        }
        $this->code = $this->comment.'/'.PHP_EOL
                    .($this->namespace ? 'namespace '.$this->namespace.PHP_EOL : '')
                    .($this->traits ? $traits : '')
                    .($this->is_abstract ? 'abstract ' : '').'class '.$this->name.' '
                    .($this->extends ? 'extends '.$extends.' ' : '')
                    .($this->implements ? 'implements '.$implements : '').PHP_EOL
                    .'{'.PHP_EOL
                    .($this->propertys ? $propertys : '')
                    .($this->methods ? $methods : '')
                    .'}';

        return parent::generate();
    }
}