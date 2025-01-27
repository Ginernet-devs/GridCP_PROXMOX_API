<?php

declare(strict_types=1);

namespace Ginernet\Proxmox\VM\App\Service;


use Ginernet\Proxmox\Commons\Domain\Entities\Connection;
use Ginernet\Proxmox\Commons\Domain\Entities\CookiesPVE;
use Ginernet\Proxmox\Commons\infrastructure\GClientBase;



class SetAgentExecVMinNode extends GClientBase
{

    public function __construct(Connection $connection, CookiesPVE $cookiesPVE)
    {
        parent::__construct($connection, $cookiesPVE);
    }

    public function __invoke(string $node, int $vmid, array $commands)
    {
        
        try{
          $result =  $this->Post("nodes/".$node."/qemu/".$vmid."/agent/exec", $commands);
          $responseBody = $result->getBody()->getContents();
          $responseArray = json_decode($responseBody, true);

          return $responseBody;

        }catch(\Exception $ex){

        }

        return null;

    }

}