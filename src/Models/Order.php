<?php
/**
 * Created by PhpStorm.
 * User: nts
 * Date: 19.4.18.
 * Time: 01.30
 */

namespace Rackbeat\Models;


use Rackbeat\Utils\Model;

class Order extends Model
{
    protected $entity     = 'orders';
    protected $primaryKey = 'number';

    public function getPDF()
    {
        return $this->request->handleWithExceptions( function () {
            return $this->request->client->get( "{$this->entity}/{$this->{$this->primaryKey}}.pdf" )->getBody()
                                         ->getContents();
        } );
    }

    public function reopen()
    {

        return $this->request->handleWithExceptions( function () {

            return $this->request->client->post( "{$this->entity}/{$this->{$this->primaryKey}}/reopen" )
                                         ->getBody()
                                         ->getContents();
        } );
    }
}
