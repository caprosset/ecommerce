<?php

    namespace ecommerce\model\dao;

    use ecommerce\model\Category;
    use ecommerce\model\Product;

    /**
     * Class ProductManager.
     * Manage all product operations.
     *
     * @package ecommerce\model\dao
     */
    class ProductManager
    {
        /**
         * Convert a product array into a product object.
         *
         * @param array $aProduct product.
         *
         * @return Product converted product.
         */
        private static function convertToObject($aProduct)
        {
            $oProduct = new Product();
            $oProduct->setId(intval($aProduct['id']));
            $oProduct->setName($aProduct['name']);
            $oProduct->setDescription($aProduct['description']);
            $oProduct->setImage($aProduct['image']);
            $oProduct->setPrice(floatval($aProduct['price']));
            $oProduct->setRating(intval($aProduct['rating']));
            $oProduct->setActive(intval($aProduct['active']));
            return $oProduct;
        }

        /**
         * Get a product from its id.
         *
         * @param int $iId product id.
         *
         * @return Product matched product, null if not found
         */
        public static function get($iId)
        {
            $sQuery = 'select * from product where id = ' . $iId . ' limit 1';
            $aProductRow = DBOperation::getOne($sQuery);
            $oProduct = null;
            if (false !== $aProductRow) {
                $oProduct = self::convertToObject($aProductRow);
            }
            return $oProduct;
        }

        /**
         * Get $iLimit random products.
         *
         * @param int $iLimit limit to get
         *
         * @return array(Product) random products.
         */
        public static function getRandom($iLimit)
        {
            $sQuery = 'select * from product order by rand() limit ' . $iLimit;
            $aProducts = array();
            foreach (DBOperation::getAll($sQuery) as $aProduct) {
                $aProducts[] = self::convertToObject($aProduct);
            }

            // TODO remove
            if (count($aProducts) < $iLimit) {
                $iMaxSteps = $iLimit - count($aProducts);
                for ($iStep = 1; $iStep <= $iMaxSteps; $iStep++) {
                    $aProducts[] = $aProducts[0];
                }
            }
            return $aProducts;
        }

        /**
         * Get $iLimit products from the category.
         *
         * @param Category $oCategory category.
         * @param int      $iLimit    limit to get
         *
         * @return array(Product) products from categories.
         */
        public static function getAllFromCategory(Category $oCategory, $iLimit=false)
        {
            $sQuery = 'select * from product p, product_category pc ';
            $sQuery .= ' where pc.product_id = p.id';
            $sQuery .= ' and pc.category_id = ' . $oCategory->getId();

            if( $iLimit!=false){
              $sQuery .= ' limit ' . $iLimit;  
            }
                
            $aProducts = array();
            foreach (DBOperation::getAll($sQuery) as $aProduct) {
                $aProducts[] = self::convertToObject($aProduct);
            }

            if( $iLimit==false){
                // TODO remove
                if (count($aProducts) < $iLimit) {
                    $iMaxSteps = $iLimit - count($aProducts);
                    for ($iStep = 1; $iStep <= $iMaxSteps; $iStep++) {
                        $aProducts[] = $aProducts[0];
                    }
                }
            }
            return $aProducts;
        }

        /**
         * Get products from the order.
         *
         * @param Order $oOrder order.
         *
         * @return array(Product) products from order id.
         */
        public static function getAllfromOrder($id){
          $sQuery = " select * from product LEFT JOIN order_product ON product.id = order_product.product_id";
          $sQuery .= " WHERE order_id = ". $id;

          $aAllOrders = [];
          foreach (DBOperation::getAll($sQuery) as $aOrder) {
              $aAllOrders[] = self::convertToObject($aOrder);
          }
          return $aAllOrders;
        }


        /**
         * Get all products.
         *
         * @return array(Product) all products.
         */
        public static function getAll($active = false)
        {
            $sQuery = 'select * from product ';

            if($active !== false){
              $sQuery .= 'where active = ' . $active;
            }

            $aProducts = array();
            foreach (DBOperation::getAll($sQuery) as $aProduct) {
                $aProducts[] = self::convertToObject($aProduct);
            }
            return $aProducts;
        }

        public static function create(Product $oProduct)
        {
            $sName = addslashes($oProduct->getName());
            $sDescription = addslashes($oProduct->getDescription());
            $sImage = addslashes($oProduct->getImage());
            $fPrice = floatval($oProduct->getPrice());

            $sQuery = 'insert into product(name,description,image,price) values(';
            $sQuery .= "'$sName','$sDescription','$sImage','$fPrice'";
            $sQuery .= ')';
            $bSuccess = DBOperation::exec($sQuery);
            if (!$bSuccess) {
                return null;
            }

            //  get last id
            $iProductId = DBOperation::getLastId();

            // insert categories
            $aCategories = $oProduct->getCategories();
            if (count($aCategories) > 0) {
                foreach ($aCategories as $oCategory) {
                    $sQuery = 'insert into product_category(product_id,category_id) values(';
                    $sQuery .= "'$iProductId','{$oCategory->getId()}'";
                    $sQuery .= ')';
                    DBOperation::exec($sQuery);
                }
            }

            return $iProductId;
        }

        public static function update(Product $oProduct)
        {
            $sName = addslashes($oProduct->getName());
            $sDescription = addslashes($oProduct->getDescription());
            $sImage = addslashes($oProduct->getImage());
            $fPrice = floatval($oProduct->getPrice());

            //  get product id
            $iProductId = $oProduct->getId();

            $sQuery = "update product ";
            $sQuery .= "set name='$sName',description='$sDescription',image='$sImage',price=$fPrice";
            $sQuery .= " where id = $iProductId";
            $bSuccess = DBOperation::exec($sQuery);
            if (!$bSuccess) {
                return false;
            }

            $sQuery = "delete from product_category where product_id = $iProductId";
            $bSuccess = DBOperation::exec($sQuery);

            // insert categories
            $aCategories = $oProduct->getCategories();
            if (count($aCategories) > 0) {
                foreach ($aCategories as $oCategory) {
                    $sQuery = 'insert into product_category(product_id,category_id) values(';
                    $sQuery .= "'$iProductId','{$oCategory->getId()}'";
                    $sQuery .= ')';
                    DBOperation::exec($sQuery);
                }
            }

            return true;
        }


        //supprimer un produit précis
        public static function remove($iId)
        {
            $sQuery = "delete from comment ";
            $sQuery .= " where product_id = " . $iId;
            $iRetExec = DBOperation::exec($sQuery);

            $sQuery = "delete from product_category ";
            $sQuery .= "where product_id = " . $iId;
            $iRetExec = DBOperation::exec($sQuery);

            $sQuery = "delete from product ";
            $sQuery .= "where id = " . $iId;
            $iRetExec = DBOperation::exec($sQuery);

            if(null !== $sLastSqlError = DBOperation::getLastSqlError()){
                throw new \Exception($sLastSqlError);
            }

        }


        //change the status of an "out of stock" product to unpublished
        public static function setOutOfStock($iId)
        {
            $sQuery = " update product ";
            $sQuery .= "set active = 0"; 
            $sQuery .= " WHERE id = " . $iId;

            $iRetExec = DBOperation::exec($sQuery);
            if(null !== $sLastSqlError = DBOperation::getLastSqlError()){
                throw new \Exception($sLastSqlError);
            }
        }

        public static function setInStock($iId)
        {
            $sQuery = " update product ";
            $sQuery .= "set active = 1"; 
            $sQuery .= " WHERE id = " . $iId;
            
            $iRetExec = DBOperation::exec($sQuery);
            if(null !== $sLastSqlError = DBOperation::getLastSqlError()){
                throw new \Exception($sLastSqlError);
            }
        }


        // //recuperer tous les produits activés (en stock)
        // public static function = getActiveProduct(Product $oProduct, $iLimit = 10)
        // {
        //     $sQuery = 'select * from comment ';
        //     $sQuery .= ' where product_id = ' . $oProduct->getId();
        //     $sQuery .= ' AND validation = 1';
        //     $sQuery .= ' limit ' . $iLimit;
        //     $aComments = array();
        //     foreach (DBOperation::getAll($sQuery) as $aComment) {
        //         $aComments[] = self::convertToObject($aComment);
        //     }
        //     return $aComments;
        // }

    }