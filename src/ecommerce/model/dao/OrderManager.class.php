<?php

    namespace ecommerce\model\dao;

    use ecommerce\model\Product;
    use ecommerce\model\User;
    use ecommerce\model\Order;

    /**
     * Class UserManager.
     * Manage all User operations.
     *
     * @package ecommerce\model\dao
     */
    class OrderManager
    {
        /**
         * Convert an Order array into an Order object.
         *
         * @param array $aOrder Order.
         *
         * @return Order converted object.
         */
        private static function convertToObject($aOrder)
        {
            $oOrder = new Order();
            $oOrder->setId($aOrder['id']);
            $oOrder->setDate($aOrder['date']);
            $oOrder->setTotal($aOrder['total']);
            $oOrder->setUserMail($aOrder['user_email']);

            // $aProducts = ProductManager::getAllfromOrder($oOrder->getId());
            // foreach ($aProducts as $oProduct) {
            //     $oOrder->addProduct($oProduct);
            // }
            return $oOrder;
        }

        /**
         * @param $oUser User
         * @return array
         */
        //get all orders from one user (list of orders to be displayed in user account)
        public static function getAllOrders($oUser=null)
        {
            $sQuery = "SELECT * FROM orders";
            if($oUser !== null){
                $sQuery .= " WHERE user_email = '" . $oUser->getEmail() . "'";
            }
            $sQuery .= " ORDER BY date DESC";
            
            $aAllOrders = [];

            foreach (DBOperation::getAll($sQuery) as $aOrder) {
                $aAllOrders[] = self::convertToObject($aOrder); 
            }

            return $aAllOrders;
        }


        // /**
        //  * @param $oUser User
        //  * @return array
        //  */
        // //get all orders from all users (list of orders to be displayed in admin account)
        // public static function getTotalOrders()
        // {
        //     $sQuery = "SELECT * FROM orders";
        //     //$sQuery .= " WHERE user_email = '" . $oUser->getEmail() . "'";
        //     $sQuery .= " ORDER BY date DESC";
            
        //     $aTotalOrders = [];

        //     foreach (DBOperation::getAll($sQuery) as $aOrder) {
        //         $aTotalOrders[] = self::convertToObject($aOrder); 
        //     }

        //     return $aTotalOrders;
        // }

}