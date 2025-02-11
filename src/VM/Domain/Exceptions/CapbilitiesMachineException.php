<?php

declare(strict_types=1);

namespace Ginernet\Proxmox\VM\Domain\Exceptions;



final class CapbilitiesMachineException extends \Exception

{

    public function __construct(string $message)

    {

        parent::__construct("Error get capabilities machine ->".$message, 400);

    }

}