<?php
/**
 * Created by PhpStorm.
 * User: nts
 * Date: 1.4.18.
 * Time: 00.01
 */

namespace Rackbeat\Builders;


use Rackbeat\Models\Lot;

class LotBuilder extends Builder
{

    protected $entity = 'lots';
    protected $model  = Lot::class;
}