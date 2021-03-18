<?php declare(strict_types=1);
/**
 * This file is part of Swoft.
 *
 * @link     https://swoft.org
 * @document https://swoft.org/docs
 * @contact  group@swoft.org
 * @license  https://github.com/swoft-cloud/swoft/blob/master/LICENSE
 */

namespace App\Listener;

use Swoft\Bean\Annotation\Mapping\Inject;
use Swoft\Consul\Agent;
use Swoft\Event\Annotation\Mapping\Listener;
use Swoft\Event\EventHandlerInterface;
use Swoft\Event\EventInterface;
use Swoft\Http\Server\HttpServer;
use Swoft\Server\SwooleEvent;
use Swoft\Config\Annotation\Mapping\Config;

/**
 * Class RegisterServiceListener
 *
 * @since 2.0
 *
 * @Listener(event=SwooleEvent::START)
 */
class RegisterServiceListener implements EventHandlerInterface
{
    /**
     * @Inject()
     *
     * @var Agent
     */
    private $agent;

    /**
     * @Config("consul.consul_server_name")
     */
    private $serviceName;

    /**
     * @param EventInterface $event
     */
    public function handle(EventInterface $event): void
    {
        /** @var HttpServer $httpServer */
        $httpServer = $event->getTarget();

        $service = [
            'ID'                => getConsulServerId($this->serviceName),
            'Name'              => $this->serviceName,
            'Tags'              => [
                'http'
            ],
            'Address'           => env('HOST'),
            'Port'              => $httpServer->getPort(),
            'Meta'              => [
                'version' => '1.0'
            ],
            'EnableTagOverride' => false,
            'Weights'           => [
                'Passing' => 10,
                'Warning' => 1
            ],
            'Check' => [
                'name' => 'goods.server',
                env('CONSUL_CHECK_TYPE') => env('CONSUL_CHECK_IP').':'.env('CONSUL_CHECK_PORT'),
                'interval' => '5s',     //每隔几秒检测
                'timeout' => '2s'       //发送数据包，接收数据超时时间
            ]
        ];

        // Register
        $this->agent->registerService($service);
//                CLog::info('Swoft http register service success by consul!');
    }
}
