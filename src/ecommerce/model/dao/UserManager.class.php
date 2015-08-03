<?php

    namespace ecommerce\model\dao;

    use ecommerce\model\Comment;
    use ecommerce\model\Product;
    use ecommerce\model\User;


    /**
     * Class UserManager.
     * Manage all User operations.
     *
     * @package ecommerce\model\dao
     */
    class UserManager
    {
        /**
         * Convert a User array into a User object.
         *
         * @param array $aUser User.
         *
         * @return User converted object.
         */
        private static function convertToObject($aUser)
        {
            $oUser = new User();
            $oUser->setEmail($aUser['email']);
            $oUser->setPassword($aUser['password']);
            $oUser->setAddress($aUser['address']);
            $oUser->setName($aUser['name']);
            $oUser->setFirstName($aUser['firstname']);
            $oUser->setCp($aUser['cp']);
            $oUser->setCity($aUser['city']);
            $oUser->setRole($aUser['role']);
            return $oUser;
        }

        /**
         * Get all users.
         *
         * @return array(User) all users.
         */
        public static function getAll()
        {
            $sQuery = 'select * from user';
            $aUsers = array();
            foreach (DBOperation::getAll($sQuery) as $aProduct) {
                $aUsers[] = self::convertToObject($aProduct);
            }
            return $aUsers;
        }

        public static function subscribe(User $oUser)
        {
            $sQuery = "insert into user(email, password,address,name,firstname,cp,city) ";
            $sQuery .= "values('{$oUser->getEmail()}','{$oUser->getCryptedPassword()}','{$oUser->getAddress(
            )}','{$oUser->getName()}','{$oUser->getFirstName()}','{$oUser->getCp()}','{$oUser->getCity()}')";

            return DBOperation::exec($sQuery);
        }

        public static function connect(User $oUser)
        {
            $sQuery = "select * from user where email ='{$oUser->getEmail(
            )}' and password = '{$oUser->getCryptedPassword()}' limit 1";

            $bResult = false !== DBOperation::getOne($sQuery);
            if ($bResult) {
                $_SESSION['email'] = $oUser->getEmail();
            } else {
                unset($_SESSION['email']);
            }
            return $bResult;
        }

        public static function logout(User $oUser)
        {
            unset($_SESSION['email']);
        }


        public static function get(User $oUser)
        {
            $sQuery = "select * from user where email ='{$oUser->getEmail()}' limit 1";

            return self::convertToObject(DBOperation::getOne($sQuery));
        }

        public static function getCurrent()
        {
            if (!array_key_exists('email', $_SESSION)) {
                return null;
            }

            $oUser = new User();
            $oUser->setEmail($_SESSION['email']);

            return self::get($oUser);
        }


        public static function updateAddress(User $oUser)
        {
            $sQuery = "UPDATE user";
            $sQuery .= " SET address='" . $oUser->getAddress() ."',cp='" . $oUser->getCp(). "',city='" . $oUser->getCity() . "'";
            $sQuery .= " WHERE email  ='" . $oUser->getEmail(). "'";

            //echo $sQuery;

            return DBOperation::exec($sQuery);
        }

         public static function updatePassword(User $oUser)
        {
            $sQuery = "UPDATE user";
            $sQuery .= " SET password='" . $oUser->getCryptedPassword() . "'";
            $sQuery .= " WHERE email  ='" . $oUser->getEmail(). "'";

            //echo $sQuery;

            return DBOperation::exec($sQuery);
        }


   }