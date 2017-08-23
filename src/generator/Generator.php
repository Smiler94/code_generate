<?php
namespace generator;

abstract class Generator 
{
    const INDENT = '    ';

    protected $name = '';
    protected $comment = '';
    protected $indent  = 0;
    protected $code = '';

    public function __construct($name)
    {
        $this->name = $name;
        $this->comment = '/**' . PHP_EOL .' *';
    }

    public function addComment($comment)
    {
        $this->comment .= ' '.trim($comment).PHP_EOL.' *';
        return $this;
    }

    public function indent($level)
    {
        $this->indent = $level;
        return $this;
    }

    public function generate()
    {
        if ($this->indent > 0) {
            return preg_replace('/(?:^|[\r\n]+)(?=[^\r\n])/', 
                    '$0' . str_repeat(self::INDENT, $this->indent), 
                    $this->code, -1);
        }
        return $this->code;
    }

    public function __toString()
    {
        return $this->generate();
    }
}