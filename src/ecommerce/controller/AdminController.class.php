<?php

    namespace ecommerce\controller;


    use ecommerce\model\CartProduct;
    use ecommerce\model\Comment;
    use ecommerce\model\dao\CartManager;
    use ecommerce\model\dao\CategoryManager;
    use ecommerce\model\dao\CommentManager;
    use ecommerce\model\dao\OrderManager;
    use ecommerce\model\dao\ProductManager;
    use ecommerce\model\dao\UserManager;
    use ecommerce\model\Product;
    use ecommerce\model\User;

    class AdminController
    {

        public function __construct()
        {
			$sAction = 'home';
            if (array_key_exists('action', $_GET)) {
                $sAction = $_GET['action'];
            }

            $sFunction = lcfirst($sAction) . 'Action';

			require ROOT . 'inc/site.header.inc.php';

			// check if function exists in the current class :
			if (method_exists($this, $sFunction)) {
				// call the function
				$this->$sFunction();
			} else {
				$this->homeAction();
			}
			require ROOT . 'inc/site.footer.inc.php';
     
        }
		
		private function homeAction()
        {
            $aCategories = CategoryManager::getAll();
            $aProducts = ProductManager::getRandom(4);
            require ROOT . 'src/ecommerce/view/home.php';		
        }
		
       
        private function statsAction()
        {
            $aCategories = CategoryManager::getProductsCount();
            //var_dump($aCategories);
            require ROOT . 'src/ecommerce/view/admin/listcategories.php';
        }


    }
