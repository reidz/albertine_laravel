<?php

namespace App;


class Cart
{
    public $productStocks = null;
    public $grandTotalQty = 0;
    public $grandTotalPrice = 0;
    public $shippingFee = 0;
    public $promo = 0;
    public $grandTotal = 0; // grandTotalPrice + shippingFee - promo
    public $currency = null;
    

    public function __construct($oldCart)
    {
        if($oldCart){
            $this->productStocks = $oldCart->productStocks;
            $this->grandTotalQty = $oldCart->grandTotalQty;
            $this->grandTotalPrice = $oldCart->grandTotalPrice;
            $this->shippingFee = $oldCart->shippingFee;
            $this->grandTotal = $oldCart->grandTotal;
            $this->currency = $oldCart->currency;
            $this->promo = $oldCart->promo;
        }
    }

    public function add($productStock, $qty){
        // handle hold booking
        // insert $qty to product->hold
        // don't allow 1 user to hold too many item for 1 product and for all item

        $storedProductStock = ['qty'=>0, 'subTotal' => 0, 'productStock' => $productStock];

        if($this->productStocks){
            if(array_key_exists($productStock->id, $this->productStocks)){

                // if($product->price != $this->productStocks[$productStock]->product->price){
                //     throw new Exception('Price change for '.$product->display_name);
                // }
                $this->grandTotalQty -= $qty;
                $storedProductStock = $this->productStocks[$productStock->id];
            }
        }

        $storedProductStock['qty'] += $qty;
        $storedProductStock['subTotal'] = $storedProductStock['qty'] * $productStock->product->price;
        $this->productStocks[$productStock->id] = $storedProductStock;
        
        // recalculate grandTotalQty, grandTotalPrice, shippingFee, grandTotal
        $this->grandTotalQty += $storedProductStock['qty'];
        $this->grandTotalPrice = $this->grandTotalPrice + ($qty * $productStock->product->price);
        $this->grandTotal = $this->grandTotalPrice + $this->shippingFee;
        $this->currency = $productStock->product->currency;
    }

    public function remove($id)
    {
        $storedProductStock = $this->productStocks[$id];
        $this->grandTotalQty -= $storedProductStock['qty'];
        $this->grandTotalPrice -= $storedProductStock['subTotal'];
        $this->grandTotal -= $storedProductStock['subTotal'];
        unset($this->productStocks[$id]);
    }

    public function setshippingFee($shippingFee)
    {
        $this->grandTotal -= $this->shippingFee;
        $this->shippingFee = $shippingFee;
        $this->grandTotal += $this->shippingFee;
    }
}