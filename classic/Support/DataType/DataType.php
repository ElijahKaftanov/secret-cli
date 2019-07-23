<?php declare(strict_types=1);

namespace Classic\Package\Support\DataType;

use Classic\Package\Support\DataType\Enum\AbstractTraceEnum;

class DataType extends AbstractTraceEnum
{
    const ARRAY = 'array';
    const INT = 'int';
    const FLOAT = 'float';
    const STRING = 'string';
    const BOOL = 'bool';
    const RESOURCE = 'resource';
    const OBJECT = 'object';
    const NULL = 'null';

    const INTEGER = self::INT;
    const BOOLEAN = self::BOOL;
}
