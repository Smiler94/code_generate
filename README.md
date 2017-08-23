## codeGenerate

a simple demo to generate php code

### usage

#### install

clone the resposity

`$ git clone https://github.com/Smiler94/code_generate.git`

install the dependencies

`$ composer install`

#### use

``` php
require_once __DIR__.'/vendor/autoload.php';

use generator\Property;
use generator\Method;
use generator\Classes;
$property = (new Property('test'))
        ->addComment('a test property')
        ->setStatic(true)
        ->indent(0)
        ->setPrivilege(Property::PRIVILEGE_PROTECTED)
        ->setValue('dddd');
        // ->generate();

echo $property;
// 
// 
$method = (new Method('test'))
        ->addComment('a test method')
        ->addComment(' ')
        ->addComment('@author linzhen 2017-07-03 16:17:02')
        ->setStatic(true)
        ->indent(1)
        ->addBody('return true');

echo $method;


$class = (new Classes('Test'))
        ->addComment('a test class')
        ->setNameSpace('generate')
        ->addTrait('\generate\Method')
        ->addExtend('extend')
        ->addImplement('implement')
        ->addImplement('implement2');

$prop = $class->addProperty('prop1', '')
        ->addComment('prop1')
        ->setPrivilege('private');

$method = $class->addMethod('method1')
        ->addComment('a test method')
        ->addComment(' ')
        ->addComment('@author linzhen 2017-07-04 09:55:57')
        ->setPrivilege('public')
        ->addParam('arg1')
        ->addBody('return true');

$method2 = $class->addMethod('method2')
        ->addComment('a test method2')
        ->addComment(' ')
        ->addComment('@author linzhen 2017-07-04 09:55:57')
        ->setPrivilege('private')
        ->addParam('arg1')
        ->addBody('');
echo $class;

```