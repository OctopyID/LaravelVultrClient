<?php

namespace Octopy\Vultr\Entity\Instance;

use Octopy\Vultr\Entity\AbstractEntity;

/**
 * @property string id
 * @property string os
 * @property int    ram
 * @property int    disk
 * @property string mainIp
 * @property int    vCpuCount
 * @property string region
 * @property string plan
 * @property string dateCreated
 * @property string status
 * @property int    allowedBandwidth
 * @property string netmaskV4
 * @property string gatewayV4
 * @property string powerStatus
 * @property string serverStatus
 * @property string v6Network
 * @property string v6MainIp
 * @property int    v6NetworkSize
 * @property string label
 * @property string internalIp
 * @property string kvm
 * @property string tag
 * @property int    osId
 * @property int    appId
 * @property string firewallGroupId
 * @property array  features
 */
class Instance extends AbstractEntity
{
	/**
	 * @var string
	 */
	protected string $name = 'instances';
}
