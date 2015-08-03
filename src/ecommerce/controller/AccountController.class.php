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

    class AccountController
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


    private function addressAction()
    {

        $oUser = UserManager::getCurrent();

        //check if $oUser exists, if not redirect to landingpage
        if (!$oUser) {
            $this->homeAction();
        }

        //check if button submit is cliqued (POST method is called) and update the fields only if it is
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $messageError = array();

            //check if address key exists (field is completed)
            if (array_key_exists('address', $_POST)) {
                $oUser->setAddress( $_POST['address']);
            }else{
                $messageError[] = 'L\'adresse est obligatoire';
            }

            //check if cp key exists (field is completed)
            if (array_key_exists('cp', $_POST)) {
                $oUser->setCp ( $_POST['cp']);
            }else{
                $messageError[] = 'Le code postal est obligatoire';
            }
     
            //check if city key exists (field is completed)
            if (array_key_exists('city', $_POST)) {
                $oUser->setCity ( $_POST['city']);
            }else{
                $messageError[] = 'La ville est obligatoire';
            }

            //execute (in a variable) the function updateAddress()
            $result = UserManager::updateAddress($oUser);
            $message = "Les modifications ont été enregistrées";
            echo '<script type="text/javascript">window.alert("'.$message.'");</script>'; 

        }
            require ROOT . 'src/ecommerce/view/account/address.php';
            
        }


        private function passwordAction()
        {
            $oUser = UserManager::getCurrent();

            //check if $oUser exists, if not redirect to landingpage
            if (!$oUser) {
                $this->homeAction();
            }

            //check if button submit is cliqued (POST method is called) and update the fields only if it is
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                //$messageError = array();

                //check if email key exists (field is completed)
                // if (!array_key_exists('email', $_POST)) {
                //     $messageError[] = 'L\'adresse email est obligatoire';
                // }

                //check if password key exists (field is completed)
                if (array_key_exists('password', $_POST) and empty($_POST['password'] == false)) {
                    if(sha1($_POST['password']) == $oUser->getPassword()){
                        
                        //check if new password key exists (field is completed)
                        if (array_key_exists('newpassword', $_POST) and empty($_POST['newpassword'] == false)){

                            //if yes check if password confirmation key exists (field is completed)
                            if (array_key_exists('passwordconfirmation', $_POST) and empty($_POST['passwordconfirmation'] == false)){

                                //if yes check that it is identical to the new password previously entered
                                if($_POST['newpassword'] !== $_POST['passwordconfirmation']){
                                    $message = "Les 2 mots de passe ne correspondent pas";
                                    echo '<script type="text/javascript">window.alert("'.$message.'");</script>';
                                }else{
                                    //execute (in a variable) the function updatePassword()
                                    $oUser->setPassword($_POST['newpassword']);
                                    $result = UserManager::updatePassword($oUser);
                                    $message = "Les modifications ont été enregistrées";
                                    echo '<script type="text/javascript">window.alert("'.$message.'");</script>';        
                                }   

                            }
                            else
                            {
                                $message = 'Merci de bien vouloir confirmer votre mot de passe';
                                echo '<script type="text/javascript">window.alert("'.$message.'");</script>';
                            }

                        }
                        else
                        {
                            $message = 'Merci de bien vouloir saisir un nouveau mot de passe';
                            echo '<script type="text/javascript">window.alert("'.$message.'");</script>';
                        }


                    }else{
                        $message = 'Le mot de passe actuel ne correspond pas';
                        echo '<script type="text/javascript">window.alert("'.$message.'");</script>';
                    }
                    
                }else{
                    $message = 'Le mot de passe est obligatoire';
                    echo '<script type="text/javascript">window.alert("'.$message.'");</script>';
                }

                  
            }
            
            require ROOT . 'src/ecommerce/view/account/password.php';
        }


        private function ordersAction()
        {

            $oUser = UserManager::getCurrent();
            if(!$oUser){
                $this->homeAction();
            }

            //$aCart = CartManager::getAll();
            $iRole = $oUser->getRole();
            if($iRole != 2)
                $aAllOrders = OrderManager::getAllOrders($oUser);
            else
                $aAllOrders = OrderManager::getAllOrders();
            //$aTotalOrders = OrderManager::getTotalOrders();


            //$fTotal = number_format(CartManager::getTotal(), 2);
            //$fTotalTTC = number_format((CartManager::getTotal()*1.20), 2);
            require ROOT . 'src/ecommerce/view/orders/orders.php';

        }

        private function orderdetailAction()
        {
            $id = intval($_GET['id']);
            $oOrder = ProductManager::getAllFromOrder($id);
            require ROOT . 'src/ecommerce/view/orders/orderdetail.php';
        }
}