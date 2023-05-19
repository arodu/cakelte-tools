<?php

declare(strict_types=1);

namespace CakeLteTools\Controller\Traits;

use Cake\Http\Exception\NotFoundException;

trait BulkActionsTrait
{
    protected function getIdList($list): array
    {
        return array_keys(array_filter($list));
    }

    public function bulkActions()
    {
        $data = $this->getRequest()->getData();

        $action = $data['action'];
        $items = [];
        if (!empty($data['item']) && is_array($data['item'])) {
            $items = array_keys($data['item']);
        }

        if (method_exists($this, $action)) {
            return $this->$action($items);
        }

        throw new NotFoundException(__('method {0} doesn\'t exists on class {1}', $action, $this::class));
    }
}
