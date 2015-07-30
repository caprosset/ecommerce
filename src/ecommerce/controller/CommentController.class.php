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
    // use ecommerce\model\Comment;
    use ecommerce\model\User;

    class CommentController
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
                $this->actionHome();
            }
            require ROOT . 'inc/site.footer.inc.php';
     
        }


        private function validationAction()
        {
            // no id => redirect home
            if (array_key_exists('id', $_GET)) {
                 $iId = intval($_GET['id']);
            
                $oProduct = ProductManager::get($iId);

                // product not found => redirect home
                if (null === $oProduct) {
                    $this->homeAction();
                    return;
                } else {
                    $aQueuedComments = CommentManager::getQueuedComments($oProduct);
                    require ROOT . 'src/ecommerce/view/comment/validation.php';
                }

            }else{
                $aQueuedComments = CommentManager::getQueuedComments();
                require ROOT . 'src/ecommerce/view/comment/validation.php';
            }
           
        }


        //methode avec les 2 clés primaires id_product et user_email
        private function showAction()
        {
            if(!array_key_exists('productid', $_GET)){
                $this->validationAction();
                return;
            }
            $iId = intval($_GET['productid']);
        
            if(!array_key_exists('email', $_GET)){
                $this->validationAction();
                return;
            }
            $sEmail = $_GET['email'];


            $oProduct = ProductManager::get($iId);

            //obligé de créer un objet pour que la fonction get($oUser) nous renvoie un objet... bof bof
            $oUser = new User();
            $oUser->setEmail($sEmail);

            $oUser = UserManager::get($oUser);


            // product_i and/or user_email not found => redirect on all comments list
            if (null !== $oProduct && null !== $oUser) {
                $oComment = CommentManager::get($oProduct,$oUser);
                require ROOT . 'src/ecommerce/view/comment/show.php';
                
            } else {
                $this->validationAction();
                return;
            }
        }


        private function removeAction()
        {
            $iId = intval($_GET['productid']);
            $sEmail = $_GET['email'];
            
            $oProduct = ProductManager::get($iId);

            //obligé de créer un objet pour que la fonction get($oUser) nous renvoie un objet... bof bof
            $oUser = new User();
            $oUser->setEmail($sEmail);

            $oUser = UserManager::get($oUser);

            $oComment = CommentManager::get($oProduct, $oUser);

            // product_i and/or user_email not found => redirect on all comments list
            if (null !== $oProduct && null !== $oUser) {
                $oComment = CommentManager::remove($oProduct, $oUser);
            
            } else {
                $this->validationAction();
                return;
            }
        }


        private function approveAction()
        {
            $iId = intval($_GET['productid']);
            $sEmail = $_GET['email'];
            
            $oProduct = ProductManager::get($iId);

            //obligé de créer un objet pour que la fonction get($oUser) nous renvoie un objet... bof bof
            $oUser = new User();
            $oUser->setEmail($sEmail);

            $oUser = UserManager::get($oUser);

            $oComment = CommentManager::get($oProduct, $oUser);

            // product_i and/or user_email not found => redirect on all comments list
            if (null !== $oProduct && null !== $oUser) {
                $oComment = CommentManager::approve($oProduct, $oUser);
            
            } else {
                $this->validationAction();
                return;
            }
        }


        // const ACCETED = 1;
        // const REFUSED = 2;
        // const WAITING = 0;
    
        // private function listAction()
        // {
        //     $aComments = CommentManager::getAll(0);
            
        //     require ROOT . 'src/ecommerce/view/comment/list.php';
        // }

        // private function validateAction()
        // {
    
        //     // no id => redirect home
        //     if (!array_key_exists('productid', $_POST)) {
        //        $this->listAction();
        //         return;
        //     }
        //     $iProductId = intval($_POST['productid']);
            
        //     if (!array_key_exists('useremail', $_POST)) {
        //         $this->listAction();
        //         return;
        //     }
        //     $sUserEmail = $_POST['useremail'];
        
        //     $validate = self::WAITING;
        //     if (array_key_exists('refuse', $_POST)) {
        //         $validate = self::REFUSED;
        //     } elseif (array_key_exists('accept', $_POST)) {
        //         $validate = self::ACCETED;
        //     }
            
        //     $oComment = CommentManager::get($iProductId,$sUserEmail);
                    
        //     try {
        //         CommentManager::validate($oComment, $validate);
        //     } catch (\Exception $e) {
        //         $error = $e->getMessage();
        //     }
            
        //     $this->listAction();

        // }
    }