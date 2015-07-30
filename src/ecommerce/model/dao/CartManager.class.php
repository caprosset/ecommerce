<?php

    namespace ecommerce\model\dao;

    use ecommerce\model\CartProduct;
    use ecommerce\model\User;


    class CartManager
    {

        public static function add(CartProduct $oCartProduct)
        {
            if (!array_key_exists('cart', $_SESSION)) {
                $_SESSION['cart'] = array();
            }
            // already in cart, then add the wanted quantity
            if (array_key_exists($oCartProduct->getId(), $_SESSION['cart'])) {
                $_SESSION['cart'][$oCartProduct->getId()] += $oCartProduct->getQuantity();
            } else {
                $_SESSION['cart'][$oCartProduct->getId()] = $oCartProduct->getQuantity();
            }
        }
        

        public static function remove(CartProduct $oCartProduct)
        {
            if (!array_key_exists('cart', $_SESSION)) {
                return;
            }
            if (array_key_exists($oCartProduct->getId(), $_SESSION['cart'])) {
                unset($_SESSION['cart'][$oCartProduct->getId()]);
            }
        }


        public static function clean()
        {
            unset($_SESSION['cart']);
        }


        public static function update(CartProduct $oCartProduct)
        {
            if (!array_key_exists('cart', $_SESSION)) {
                $_SESSION['cart'] = array();
            }
            $_SESSION['cart'][$oCartProduct->getId()] = $oCartProduct->getQuantity();
        }


        public static function getAll()
        {
            $aAll = array();
            if (array_key_exists('cart', $_SESSION)) {
                foreach ($_SESSION['cart'] as $iProductId => $iQuantity) {
                    $oProduct = ProductManager::get($iProductId);
                    
                    if ($oProduct){
                        // product should exists !
                        if (false === $oProduct) {
                            continue;
                        }
                        // convert to CartProduct
                        $oProduct = CartProduct::create($oProduct);
                        $oProduct->setQuantity($iQuantity);
                        $aAll[] = $oProduct;
                    }
                }
            }
            return $aAll;
        }


        public static function getTotal()
        {
            $fTotal = 0;
            foreach (self::getAll() as $oCartProduct) {
                $fTotal += $oCartProduct->getPrice() * $oCartProduct->getQuantity();
            }
            return $fTotal;
        }


        public static function save($aProducts, User $oUser)
        {
            if (count($aProducts) === 0) {
                return false;
            }
            $dDate = date('Y-m-d H:i:s');
            $fTotal = self::getTotal();
            // create order
            $sQuery = "insert into orders(user_email,date,total) values('{$oUser->getEmail()}','$dDate',$fTotal)";
            if (!DBOperation::exec($sQuery)) {
                return false;
                }

            $iOrderId = DBOperation::getLastId();

            foreach ($aProducts as $oCartProduct) {
                $sQuery = "insert into order_product(order_id,product_id,quantity) values($iOrderId,
                {$oCartProduct->getId()},{$oCartProduct->getQuantity()})";
                if (!DBOperation::exec($sQuery)) {
                    return false;
                }
            }

            return true;
        }
    }