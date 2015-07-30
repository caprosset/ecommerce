<?php

    namespace ecommerce\model;


    class CartProduct extends Product
    {
        /**
         * @var int quantity.
         */
        private $iQuantity;

        /**
         * @param int $iQuantity
         */
        public function setQuantity($iQuantity)
        {
            $this->iQuantity = $iQuantity;
        }

        /**
         * @return int
         */
        public function getQuantity()
        {
            return $this->iQuantity;
        }

        public function getTotal()
        {
            return number_format($this->getPrice() * $this->getQuantity(), 2);
        }


        public static function create(Product $oProduct)
        {
            $oCartProduct = new CartProduct();
            $oCartProduct->setImage($oProduct->getImage());
            $oCartProduct->setId($oProduct->getId());
            $oCartProduct->setDescription($oProduct->getDescription());
            $oCartProduct->setName($oProduct->getName());
            $oCartProduct->setPrice($oProduct->getPrice());
            return $oCartProduct;
        }
    }