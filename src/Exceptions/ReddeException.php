<?php
namespace Redde\Exceptions;

use Exception;

/**
 * Generic API exception
 */
class ReddeException extends Exception
{
    /**
     * Last response from API that triggered this exception
     *
     * @var string
     */
    public $rawResponse;
}