<?php
/**
 * Created by PhpStorm.
 * User: nts
 * Date: 19.4.18.
 * Time: 01.32
 */

namespace Rackbeat\Builders;


use Rackbeat\Models\InventoryMovement;

class InventoryMovementBuilder extends Builder
{
    protected $entity = 'inventory-movements';
    protected $model  = InventoryMovement::class;
}