<?php

namespace Devpro\Common\Exception;

/**
 * Bundle general exception.
 * 
 * @author Bertrand THOMAS <bertrand@devpro.fr>
 */
class DevproUtilitiesBundleException extends \Exception
{
  public function __construct ($message = null, $args = null, $_ = null)
  {
    return parent::__construct(sprintf($message, $args, $_));
  }
}
