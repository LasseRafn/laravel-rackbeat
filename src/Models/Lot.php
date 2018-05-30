<?php
/**
 * Created by PhpStorm.
 * User: nts
 * Date: 1.4.18.
 * Time: 00.02
 */

namespace Rackbeat\Models;


use Rackbeat\Utils\Model;

class Lot extends Model
{
    public    $number;
    protected $entity     = 'lots';
    protected $primaryKey = 'number';

    public function inventoryMatrix( $location_id = null )
    {
        return $this->request->handleWithExceptions( function () use ( $location_id ) {

            $filter = '';

            // We need to use location filter if user has provided any
            if ( !is_null( $location_id ) ) {

                $filter .= '?location_id=' . $location_id;
            }

            $response = $this->request->client->get( "{$this->entity}/{$this->{$this->primaryKey}}/variation-matrix" .
                                                     $filter );

            $html = $response->getBody()->getContents();

            return $html;
        } );

    }

    public function variations( $variation_id = 1001 )
    {
        return $this->request->handleWithExceptions( function () use ( $variation_id ) {

            $response = $this->request->client->get( "variations/{$this->{$this->primaryKey}}/variation-matrix" .
                                                     $filter );

            $html = $response->getBody()->getContents();

            return $html;
        } );
    }

    public function location()
    {
        return $this->request->handleWithExceptions( function () {

            $response = $this->request->client->get( "{$this->entity}/{$this->{$this->primaryKey}}/locations" );

            return collect( json_decode( $response->getBody()->getContents() )->product_locations );

        } );
    }

    /**
     * Show reporting ledger for desired product https://app.rackbeat.com/reporting/ledger/{product_number}
     * API docs: https://rackbeat.docs.apiary.io/#reference/inventory-reports/show
     */
    public function ledger()
    {
        return $this->request->handleWithExceptions( function () {

            $response =
                $this->request->client->get( "inventory-reports/inventory-ledger/{$this->{ $this->primaryKey } }" );

            return collect( json_decode( $response->getBody()->getContents() )->ledger_items );

        } );
    }
}