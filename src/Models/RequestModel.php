<?php

namespace StringPhp\Gpt\Models;

use StringPhp\Gpt\Http;
use StringPhp\Models\Model;
use StringPhp\Models\SnakeToCamelCaseModel;

abstract class RequestModel extends SnakeToCamelCaseModel
{
    abstract public function send(Http $http): Model;
}
