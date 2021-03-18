<?php declare(strict_types=1);

namespace App\Rpc\Service;

use App\Rpc\Lib\GoodsInterface;
use Exception;
use RuntimeException;
use Swoft\Co;
use Swoft\Rpc\Server\Annotation\Mapping\Service;

/**
 * Class GoodsService
 *
 * @since 2.0
 *
 * @Service()
 */
class GoodsService implements GoodsInterface
{
    /**
     * @param int   $id
     *
     * @return array
     */
    public function getList(int $id): array
    {
        return ['name' => ['list']];
    }

}
