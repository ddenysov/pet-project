<?php

namespace Common\Domain\ValueObject;

use Common\Domain\ValueObject\Exception\String\InvalidStringLengthException;

class TextValue extends StringValue implements Port\StringValue
{

}