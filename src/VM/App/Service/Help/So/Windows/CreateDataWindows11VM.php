<?php

declare(strict_types=1);

namespace Ginernet\Proxmox\VM\App\Service\Help\So\Windows;


use Ginernet\Proxmox\Commons\Application\Helpers\GFunctions;

use Ginernet\Proxmox\Commons\Domain\Models\DiskTypePVE;
use Ginernet\Proxmox\VM\Domain\IService\IBuildVMData;
use Ginernet\Proxmox\VM\Domain\Model\CpuModel;
use Ginernet\Proxmox\VM\Domain\Model\EfidisckModel;
use Ginernet\Proxmox\VM\Domain\Model\EfiModel;

use Ginernet\Proxmox\VM\Domain\Model\Storage\IdeModel;

use Ginernet\Proxmox\VM\Domain\Model\IpModel;
use Ginernet\Proxmox\VM\Domain\Model\MachineModel;
use Ginernet\Proxmox\VM\Domain\Model\NetModel;

use Ginernet\Proxmox\VM\Domain\Model\Storage\SataModel;

use Ginernet\Proxmox\VM\Domain\Model\Storage\ScsiModel;

use Ginernet\Proxmox\VM\Domain\Model\Storage\VirtioModel;
use Ginernet\Proxmox\VM\Domain\Model\TpmstateModel;
use Ginernet\Proxmox\VM\Domain\Model\UserModel;



final class CreateDataWindows11VM implements IBuildVMData

{

    use GFunctions;

    private string $nodeName;
    private int $vmId;
    private ?int $vmCpuCores;
    private ?string $vmName;
    private ?int $vmNetId;
    private ?string $vmNetModel;
    private ?string $vmNetBridge;
    private ?int $vmNetFirewall;
    private ?bool $vmOnBoot;
    private ?string $vmScsiHw;
    private ?string $vmDiskType;
    private ?int    $vmDiskId;
    private ?string $vmDiskStorage;
    private ?string $vmDiskDiscard;
    private ?string $vmDiskCache;
    private ?string $vmDiskImportFrom;
    private ?string $vmTags;
    private ?int    $vmCloudInitIdeId;
    private ?string $vmCloudInitStorage;
    private ?string $vmBootOrder;
    private ?int $vmAgent;
    private ?int    $vmNetNetId;
    private ?string $vmNetIp;
    private ?string $vmNetGw;
    private ?string $vmOsUserName;
    private ?string $vmOsPassword;
    private ?string $vmCpuType;
    private ?int $vmMemory = null;
    private ?int $vmMemoryBallon = null;
    private ?string $vmOsType = null;
    private ?string $vmBios = null;
    private ?string $vmMachinePc = null;
    private ?string $vmEfiStorage = null;
    private ?int $vmEfiKey = null;
    private ?string $efidisckNvme = null;
    private ?string $efidisckEnrroled = null;
    private ?string $tpmstateNvme = null;
    private ?string $tpmstateVersion = null;



    public function __construct(
                                    string  $nodeName, int $vmId, ?int $vmCpuCores, ?string $vmName, ?int $vmNetId,
                                    ?string $vmNetModel, ?string $vmNetBridge, ?int $vmNetFirewall, ?bool $vmOnBoot,
                                    ?string $vmScsiHw, ?string $vmDiskType, ?int    $vmDiskId, ?string $vmDiskStorage,
                                    ?string $vmDiskDiscard, ?string $vmDiskCache, ?string $vmDiskImportFrom, ?string $vmTags,
                                    ?int    $vmCloudInitIdeId, ?string $vmCloudInitStorage, ?string $vmBootOrder, ?int $vmAgent,
                                    ?int    $vmNetNetId, ?string $vmNetIp, ?string $vmNetGw, ?string $vmOsUserName,
                                    ?string $vmOsPassword, ?string $vmCpuType, ?int $vmMemory = null, ?int $vmMemoryBallon = null,
                                    ?string $vmOsType = null,?string $vmBios = null,?string $vmMachinePc = null,
                                    ?string $vmEfiStorage = null, ?int $vmEfiKey = null,
                                    ?string $efidisckNvme = null, ?string $efidisckEnrroled = null,
                                    ?string $tpmstateNvme = null, ?string $tpmstateVersion = null
                                )

    {
        $this->nodeName = $nodeName;
        $this->vmId = $vmId;
        $this->vmCpuCores = $vmCpuCores;
        $this->vmName = $vmName;
        $this->vmNetId = $vmNetId;
        $this->vmNetModel = $vmNetModel;
        $this->vmNetBridge = $vmNetBridge;
        $this->vmNetFirewall = $vmNetFirewall;
        $this->vmOnBoot = $vmOnBoot;
        $this->vmScsiHw = $vmScsiHw;
        $this->vmDiskType = $vmDiskType;
        $this->vmDiskId = $vmDiskId;
        $this->vmDiskStorage = $vmDiskStorage;
        $this->vmDiskDiscard = $vmDiskDiscard;
        $this->vmDiskCache = $vmDiskCache;
        $this->vmDiskImportFrom = $vmDiskImportFrom;
        $this->vmTags = $vmTags;
        $this->vmCloudInitIdeId = $vmCloudInitIdeId;
        $this->vmCloudInitStorage = $vmCloudInitStorage;
        $this->vmBootOrder = $vmBootOrder;
        $this->vmAgent = $vmAgent;
        $this->vmNetNetId = $vmNetNetId;
        $this->vmNetIp = $vmNetIp;
        $this->vmNetGw = $vmNetGw;
        $this->vmOsUserName = $vmOsUserName;
        $this->vmOsPassword = $vmOsPassword;
        $this->vmCpuType = $vmCpuType;
        $this->vmMemory = $vmMemory;
        $this->vmMemoryBallon = $vmMemoryBallon;
        $this->vmOsType = $vmOsType;
        $this->vmBios = $vmBios;
        $this->vmMachinePc = $vmMachinePc;
        $this->vmEfiStorage = $vmEfiStorage;
        $this->vmEfiKey = $vmEfiKey;
        $this->efidisckNvme = $efidisckNvme;
        $this->efidisckEnrroled = $efidisckEnrroled;
        $this->tpmstateNvme = $tpmstateNvme;
        $this->tpmstateVersion = $tpmstateVersion;

        
        
    }
    
    public function buildData(): array
    {

        $net= new NetModel($this->vmNetId, $this->vmNetModel, $this->vmNetBridge, $this->vmNetFirewall);
            
        $scsi= null;
        if (strtolower($this->vmDiskType) == strtolower(DiskTypePVE::SCSI)) $scsi = new ScsiModel($this->vmDiskId, $this->vmDiskStorage, $this->vmDiskDiscard, $this->vmDiskCache, $this->vmDiskImportFrom );
        
        $ide= new IdeModel($this->vmDiskId, $this->vmDiskStorage, $this->vmDiskDiscard, $this->vmDiskCache, $this->vmDiskImportFrom );

        $sata=new SataModel($this->vmDiskId, $this->vmDiskStorage, $this->vmDiskDiscard, $this->vmDiskCache, $this->vmDiskImportFrom );

       $virtio= new VirtioModel($this->vmDiskId, $this->vmDiskStorage, $this->vmDiskDiscard, $this->vmDiskCache, $this->vmDiskImportFrom );


        

        $user= new UserModel($this->vmOsUserName, $this->vmOsPassword);

        $cpu = new CpuModel($this->vmCpuType, $this->vmCpuCores, $this->vmMemory, $this->vmMemoryBallon);

        $efi= !is_null($this->vmEfiKey)? new EfiModel($this->vmDiskStorage, $this->vmEfiKey) : null;

        $machinePc= new MachineModel($this->vmMachinePc, null);

        $tpmstate= new TpmstateModel(0, $this->vmDiskStorage, null, null, null, $this->tpmstateVersion);

        $efiDisck= new EfidisckModel(0, null, $this->vmDiskStorage, null, null, $this->efidisckEnrroled);


        $body = [

            'vmid' => $this->vmId,
            'cores' => $this->vmCpuCores,
            'name' => $this->vmName,
            'onboot'=> $this->vmOnBoot,
            'agent' => 'enabled='.$this->vmAgent,
            'scsihw'=>$this->vmScsiHw,
            'net'.$net->GetIndex() =>$net->toString(),
            'tags' => $this->vmTags,
            'boot'=>'order='.$this->vmBootOrder,
            'ciuser'=>$user->GetUserName(),
            'cipassword'=>$user->GetPassword(),
            'cpu' =>'cputype=' . $cpu->getCpuTypes(),
            'memory'=>$cpu->getMemory(),
            'balloon'=>$cpu->getBallon(),
            'ide2' => 'none,media=cdrom',

        ];

        
        (isset($scsi))?$body['scsi'.$scsi->GetIndex()]=$scsi->toString():null;
        (isset($this->vmOsType))?$body['ostype']=$this->vmOsType:null;
        (isset($this->vmBios))?$body['bios']=$this->vmBios:null;
        (isset($machinePc))?$body['machine']= $machinePc->toString() :null;
        (isset($efiDisck))?$body['efidisk'.$efiDisck->GetIndex()]= $efiDisck->toString() :null;
        (isset($tpmstate))?$body['tpmstate'.$tpmstate->GetIndex()]= $tpmstate->toString() :null;

        return $body;
    }

}