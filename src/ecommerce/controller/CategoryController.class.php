<?php

    namespace ecommerce\Controller;

    use ecommerce\model\Category;
    use ecommerce\model\Comment;
    use ecommerce\model\dao\CartManager;
    use ecommerce\model\dao\CategoryManager;
    use ecommerce\model\dao\CommentManager;
    use ecommerce\model\dao\DBOperation;
    use ecommerce\model\dao\ProductManager;
    use ecommerce\model\dao\UserManager;
    use ecommerce\model\Product;
    use ecommerce\model\User;

    class CategoryController
    {

        public function __construct()
        {
			$sAction = 'home';
            if (array_key_exists('action', $_GET)) {
                $sAction = $_GET['action'];
            }

            $sFunction = lcfirst($sAction) . 'Action';


            if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                // Traitement pour une requête AJAX
                $this->$sFunction();
            }
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


        private function showAction()
        {
            // no id => redirect home
            if (!array_key_exists('id', $_GET)) {
                $this->homeAction();
                return;
            }
            $iId = intval($_GET['id']);
			
            $oCategory = CategoryManager::get($iId);

            // category not found => redirect home
            if (null === $oCategory) {
                $this->homeAction();
                return;
            } else {
                $aProducts = ProductManager::getAllFromCategory($oCategory);
                require ROOT . 'src/ecommerce/view/category/show.php';
            }

             $oProduct = ProductManager::get($iId);
        }
		

        private function listAction()
        {
            
            $oCategory = new Category();

            // category not found => redirect home
            if (null === $oCategory) {
                $this->homeAction();
                return;
            } else {
                $aCategories = CategoryManager::getAll();
                require ROOT . 'src/ecommerce/view/category/list.php';
            }
        }


		private function editAction()
        {
            // no id => redirect home
            if (!array_key_exists('id', $_GET)) {
                $oCategory = new Category();
            } else {
                $iId = intval($_GET['id']);
                $oCategory = CategoryManager::get($iId);
            }

            // category not found => redirect home
            if (null === $oCategory) {
                $this->homeAction();
                return;

            } else {

                //  if (array_key_exists('addProduct', $_POST)) {
                if($_SERVER['REQUEST_METHOD'] == 'POST'){
                    $oCategory = new Category();
                    $oCategory->setName($_POST['name']);
                    $oCategory->setDescription($_POST['description']);
                    
                    if (array_key_exists('categories', $_POST)) {
                        foreach ($_POST['categories'] as $iCategoryId) {
                            $oCategory->addCategory(CategoryManager::get($iCategoryId));
                        }
                    }
                    if (array_key_exists('category-id', $_POST)) {
                        // retourne Id de la nouvelle categorie. Sinon null
                        $iCategoryId = $_POST['category-id'];
                        $oCategory->setId($iCategoryId );
                        CategoryManager::update($oCategory);
                    }else{
                        // retourne Id du nouveau produit créé. Sinon null
                        $iCategoryId = CategoryManager::create($oCategory);
                        // Compléter l'objet par l'id du produit créé
                        $oCategory->setId($iCategoryId);
                    }

                    //pour ajouter des images
                    $temp = explode(".", $_FILES["image"]["name"]);
                    $ext = $temp[count($temp) - 1];
                    $newfilename = "images/category/" . $iCategoryId . '.' . $ext  ;
                    $uploadfile =  ROOT .$newfilename;
                    move_uploaded_file($_FILES['image']['tmp_name'], $uploadfile);

                    $oCategory->setImage($newfilename);
                    CategoryManager::update($oCategory);
                    //fin
                    
                    // $aCategories = CategoryManager::getAll();
                    require ROOT . 'src/ecommerce/view/category/show.php';

                }else{
                    // $aCategories = CategoryManager::getAll();

                require ROOT . 'src/ecommerce/view/category/edit.php';
                }
            }        

        }            

            private function removeAction()
            {
                
                if (array_key_exists('id', $_GET)) {
                    $iId = $_GET['id'];

                    if (null === $iId) {
                        $this->homeAction();
                        return;
                    } else {
                        $oCategory = CategoryManager::get($iId);
                        try{
                            $result = CategoryManager::remove($iId);
                            $aCategories = CategoryManager::getAll();
                            require ROOT . 'src/ecommerce/view/category/list.php';
                        }catch (\Exception $e){
                            $result = $e->getMessage();
                            echo "La catégorie ne peux pas être supprimée car elle contient des produits";
                        }
                    }
                }

            }

        // private function handleCart()
        // {
        //     if (array_key_exists('remove', $_POST)) {
        //         $oCartProduct = new CartProduct();
        //         $oCartProduct->setId(intval($_POST['product']));
        //         CartManager::remove($oCartProduct);
        //     } elseif (array_key_exists('edit', $_POST)) {
        //         $oCartProduct = new CartProduct();
        //         $oCartProduct->setId(intval($_POST['product']));
        //         $oCartProduct->setQuantity(intval($_POST['quantity']));
        //         CartManager::update($oCartProduct);
        //     }

        //     $aCart = CartManager::getAll();
        //     $fTotal = number_format(CartManager::getTotal(), 2);
        //     require ROOT . 'src/ecommerce/view/cart.php';
        // }

        // private function handleAccount()
        // {
        //     $oCurrentOrder = OrderManager::getCurrent(UserManager::getCurrent());
        //     $aOldOrders = OrderManager::getAll(UserManager::getCurrent());
        //     require ROOT . 'src/ecommerce/view/account.php';
        // }

        // private function handlePopulate()
        // {
        //     if (array_key_exists('addCategory', $_POST)) {
        //         $Category = new Category();
        //         $Category->setName($_POST['name']);
        //         $Category->setDescription($_POST['description']);
        //         foreach ($_POST['categories'] as $iCategoryId) {
        //             $oProduct->addCategory(CategoryManager::get($iCategoryId));
        //         }
        //         $bCreateSuccess = CategoryManager::create($Category);
        //     }

        //     require ROOT . 'src/ecommerce/view/populate.php';
        // }


}
