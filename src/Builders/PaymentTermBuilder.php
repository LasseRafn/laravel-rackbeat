<?php
/**
 * Created by PhpStorm.
 * User: nts
 * Date: 1.4.18.
 * Time: 00.01
 */

namespace Rackbeat\Builders;


use Rackbeat\Models\PaymentTerm;

class PaymentTermBuilder extends Builder
{

    protected $entity = 'payment-terms';
    protected $model  = PaymentTerm::class;
}