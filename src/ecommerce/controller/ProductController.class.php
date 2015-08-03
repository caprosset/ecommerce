<?php

    namespace ecommerce\Controller;

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

    class ProductController
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
            }else {
                // $this->addToCart();

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
			
            $oProduct = ProductManager::get($iId);

            // product not found => redirect home
            if (null === $oProduct) {
                $this->homeAction();
                return;
            } else {
                $aCategories = CategoryManager::getFromProductId($iId);
				$aComments = CommentManager::getAllFromProduct($oProduct);
				$aSimilarProducts = ProductManager::getRandom(4);
                require ROOT . 'src/ecommerce/view/product/show.php';
            }
        }

        private function listAction()
        {
            
            $oProduct = new Product();

            // product not found => redirect home
            if (null === $oProduct) {
                $this->homeAction();
                return;
            } else {
                $aProducts = ProductManager::getAll();
                require ROOT . 'src/ecommerce/view/product/list.php';
            }
        }
		

		private function editAction()
        {
            // no id => redirect home
            if (!array_key_exists('id', $_GET)) {
                $oProduct = new Product();
            } else {
                $iId = intval($_GET['id']);
                $oProduct = ProductManager::get($iId);
            }

          //  if (array_key_exists('addProduct', $_POST)) {
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $oProduct = new Product();
                $oProduct->setName($_POST['name']);
                $oProduct->setPrice($_POST['price']);
                $oProduct->setDescription($_POST['description']);
				
			//	$_POST['image']
                if (array_key_exists('image', $_POST)) {
				    $oProduct->setImage($_POST['image']);
                }
                
                if (array_key_exists('categories', $_POST)) {
                    foreach ($_POST['categories'] as $iCategoryId) {
                        $oProduct->addCategory(CategoryManager::get($iCategoryId));
                    }
                }
                if (array_key_exists('product-id', $_POST)) {
                    // retourne Id du nouveau produit. Sinon null
                    $iProductId = $_POST['product-id'];
                    $oProduct->setId($iProductId );
                    ProductManager::update($oProduct);
                }else{
                    // retourne Id du nouveau produit créé. Sinon null
                    $iProductId = ProductManager::create($oProduct);
                    // Compléter l'objet par l'id du produit créé
                    $oProduct->setId($iProductId);
                }

                //pour ajouter des images
                $temp = explode(".", $_FILES["image"]["name"]);
                $ext = $temp[count($temp) - 1];
                $newfilename = "images/product/" . $iProductId . '.' . $ext  ;
                $uploadfile =  ROOT .$newfilename;
                move_uploaded_file($_FILES['image']['tmp_name'], $uploadfile);

                $oProduct->setImage($newfilename);
                ProductManager::update($oProduct);
                //fin
        

                $aComments = CommentManager::getAllFromProduct($oProduct);
                $aSimilarProducts = ProductManager::getRandom(5);
                $aCategories = CategoryManager::getAll();
                require ROOT . 'src/ecommerce/view/product/show.php';

            }else{
                // $aComments = CommentManager::getAllFromProduct($oProduct);
                $aSimilarProducts = ProductManager::getRandom(5);
                $aCategories = CategoryManager::getAll();

            require ROOT . 'src/ecommerce/view/product/edit.php';
            }
        }

        //action permettant de supprimer un produit de la liste des produits
        private function removeAction()
        {
            
            if (array_key_exists('id', $_GET)) {
                $iId = $_GET['id'];

                if (null === $iId) {
                    $this->homeAction();
                    return;
                } else {
                    $oProduct = ProductManager::get($iId);
                    try{
                        $result = ProductManager::remove($iId);
                        $aProducts = ProductManager::getAll();
                        require ROOT . 'src/ecommerce/view/product/list.php';
                    }catch (\Exception $e){
                        $result = $e->getMessage();
                        echo "Le produit ne peux pas être supprimé car il appartient à une catégorie";
                    }
                }
            }

        }


        private function archiveAction()
        {
            {
                $iId = intval($_GET['id']);
                $oProduct = ProductManager::get($iId);

                if($oProduct->getActive() == 1) 
                {
                    $result = ProductManager::setOutOfStock($iId);
                } 

                if($oProduct->getActive() == 0) 
                {
                    $result = ProductManager::setInStock($iId);
                }   

                $aProducts = ProductManager::getAll();
                require ROOT . 'src/ecommerce/view/product/list.php';
            }    
        }


        private function cartAction()
        {
            if (array_key_exists('remove', $_POST)) {
                $oCartProduct = new CartProduct();
                $oCartProduct->setId(intval($_POST['product']));
                CartManager::remove($oCartProduct);
            } elseif (array_key_exists('edit', $_POST)) {
                $oCartProduct = new CartProduct();
                $oCartProduct->setId(intval($_POST['product']));
                $oCartProduct->setQuantity(intval($_POST['quantity']));
                CartManager::update($oCartProduct);
            }

            $aCart = CartManager::getAll();
            $fTotal = number_format(CartManager::getTotal(), 2);
            $fTotalTTC = number_format((CartManager::getTotal()*1.20), 2);
            require ROOT . 'src/ecommerce/view/cart/cart.php';

        }


        private function confirmAction()
        {
            if (array_key_exists('remove', $_POST)) {
                $oCartProduct = new CartProduct();
                $oCartProduct->setId(intval($_POST['product']));
                CartManager::remove($oCartProduct);
            } elseif (array_key_exists('edit', $_POST)) {
                $oCartProduct = new CartProduct();
                $oCartProduct->setId(intval($_POST['product']));
                $oCartProduct->setQuantity(intval($_POST['quantity']));
                CartManager::update($oCartProduct);
            }

            $oUser = UserManager::getCurrent();
            $aCart = CartManager::getAll();
            //$aOrders = CartManager::getAll();
            $fTotal = number_format(CartManager::getTotal(), 2);
            $fTotalTTC = number_format((CartManager::getTotal()*1.20), 2);
            require ROOT . 'src/ecommerce/view/cart/confirm.php';
            
        }


        private function handleAccount()
        {
            $oCurrentOrder = OrderManager::getCurrent(UserManager::getCurrent());
            $aOldOrders = OrderManager::getAll(UserManager::getCurrent());
            require ROOT . 'src/ecommerce/view/account.php';
        }


        private function handlePopulate()
        {
            if (array_key_exists('addProduct', $_POST)) {
                $oProduct = new Product();
                $oProduct->setName($_POST['name']);
                $oProduct->setPrice($_POST['price']);
                $oProduct->setDescription($_POST['description']);
                foreach ($_POST['categories'] as $iCategoryId) {
                    $oProduct->addCategory(CategoryManager::get($iCategoryId));
                }
                $bCreateSuccess = ProductManager::create($oProduct);
            }
            if (array_key_exists('addComments', $_POST)) {
                $oProduct = ProductManager::get($_POST['product']);
                foreach ($_POST['users'] as $oUserEmail) {
                    $oUser = new User();
                    $oUser->setEmail($oUserEmail);
                    $oUser = UserManager::get($oUser);
                    $oComment = new Comment();
                    $oComment->setDate(date('Y-m-d H:i:s'));
                    $oComment->setMark(rand(0, 5));
                    $oComment->setComment(
                        'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer suscipit justo massa, sit amet suscipit felis pharetra vel. Duis non tristique velit, quis sodales mauris. Mauris auctor rutrum elit, ac rutrum elit consequat consequat. Aenean laoreet id odio ut imperdiet. Sed interdum purus non velit rutrum venenatis. Etiam congue adipiscing magna sed posuere. Suspendisse cursus massa eget eros mollis, nec posuere nisi tincidunt. Maecenas porttitor enim sed massa feugiat suscipit. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Ut quis dui dolor.'
                    );
                    $oComment->setProduct($oProduct);
                    $oComment->setUser($oUser);

                    CommentManager::create($oComment);
                }
            }
            require ROOT . 'src/ecommerce/view/populate.php';
        }


        //action qui contrôle la page de validation de paiement
        private function acceptAction()
        {
            $bSuccess = CartManager::save(CartManager::getAll(), UserManager::getCurrent());

            if ($bSuccess) {
                CartManager::clean();
            }
            require ROOT . 'src/ecommerce/view/cart/accepted.php';
        }


        //action qui contrôle la page de refus de paiement
         private function refuseAction()
        {
            require ROOT . 'src/ecommerce/view/cart/refused.php';
        }


        //permet de lancer le reglement de la commande, et redirige (aleatoirement pour cet exercice) vers confirm ou refuseAction
        public function submitorderAction()
        {
            $result = rand(0,1);
            if($result == 0){
                $this->refuseAction();
            }elseif($result == 1){
                $this->acceptAction();
            }
        }


        private function addtocartAction()
        {
                  
            $oCartProduct = new CartProduct();
            $oCartProduct->setId(intval($_POST['product']));
            $oCartProduct->setQuantity(intval($_POST['quantity']));

            CartManager::add($oCartProduct);
                
        }


        private function addcommentAction()
        {
                $comment = $_POST['comment'];
                $iMark = $_POST['rate'];
                $sName = $_POST['name'];

                $productId = $_POST['product-id'];
                $oProduct =  ProductManager::get($productId);
                $oUser = UserManager::getCurrent();
                $oComment = new Comment();
                $oComment->setDate(date('Y-m-d H:i:s'));
                $oComment->setComment($comment);
                $oComment->setProduct($oProduct);
                $oComment->setUser($oUser);
                $oComment->setMark($iMark);
                $oComment->setName($sName);

                try{
                    $result = CommentManager::create($oComment);
                }catch (\Exception $e){
                    $result = $e->getMessage();
                }

                echo $result;
        }
    }
