<?php

namespace StringPhp\Gpt\Models;

use StringPhp\Gpt\Http;
use StringPhp\Models\JsonModel;
use StringPhp\Models\Model;

abstract class RequestModel extends JsonModel
{
    abstract public function send(Http $http): Model;
}
