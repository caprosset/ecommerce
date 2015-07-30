<?php

    namespace ecommerce\model\dao;

    use ecommerce\model\Comment;
    use ecommerce\model\Product;
    use ecommerce\model\User;

    /**
     * Class CommentManager.
     * Manage all Comment operations.
     *
     * @package ecommerce\model\dao
     */
    class CommentManager
    {
        /**
         * Convert a Comment array into a Comment object.
         *
         * @param array $aComment Comment.
         *
         * @return Comment converted object.
         */
        private static function convertToObject($aComment)
        {
            $oComment = new Comment();
            $oComment->setComment($aComment['comment']);
            $oComment->setMark(intval($aComment['mark']));
            $oComment->setDate($aComment['date']);
            $oComment->setName($aComment['name']);

            $oUser = new User();
            $oUser->setEmail($aComment['user_email']);
            $oComment->setUser(UserManager::get($oUser));
            $oComment->setProduct(ProductManager::get($aComment['product_id']));
            return $oComment;
        }


        public static function create(Comment $oComment)
        {
            $sQuery = 'insert into comment(product_id,user_email,comment,mark,date,name) values(';
            $sQuery .= "'{$oComment->getProduct()->getId()}','{$oComment->getUser()->getEmail(
            )}','{$oComment->getComment()}','{$oComment->getMark()}','{$oComment->getDate()}','{$oComment->getName()}'";
            $sQuery .= ')';

            $iRetExec = DBOperation::exec($sQuery);
            if(null !== $sLastSqlError = DBOperation::getLastSqlError()){
                throw new \Exception($sLastSqlError);
            }
        }


        //recuperer le commentaire d'un produit d'un utilisateur précis
        public static function get(Product $oProduct, User $oUser)
        {
            $sQuery = "select * from comment ";
            $sQuery .= " where product_id = " . $oProduct->getId() . " AND user_email = '" . $oUser->getEmail() . "'";
            $sQuery .= " limit 1";
            $aCommentRow = DBOperation::getOne($sQuery);
            $oComment = null;
            if (false !== $aCommentRow) {
                $oComment = self::convertToObject($aCommentRow);
            }
            return $oComment;
        }


        //recuperer tous les commentaires pas encore validés d'un produit
        public static function getQueuedComments(Product $oProduct = null)
        {
            $sQuery = 'select * from comment ';

            if($oProduct !== null){
                $sQuery .= ' where product_id = ' . $oProduct->getId();
                $sQuery .= ' and validation = 0';
            }else{
                $sQuery .= ' where validation = 0';
            }

            $aQueuedComments = array();
            foreach (DBOperation::getAll($sQuery) as $aComment) {
                $aQueuedComments[] = self::convertToObject($aComment);
            }
            return $aQueuedComments;
        }


        //recuperer tous les commentaires validés
        public static function getAllFromProduct(Product $oProduct, $iLimit = 10)
        {
            $sQuery = 'select * from comment ';
            $sQuery .= ' where product_id = ' . $oProduct->getId();
            $sQuery .= ' AND validation = 1';
            $sQuery .= ' limit ' . $iLimit;
            $aComments = array();
            foreach (DBOperation::getAll($sQuery) as $aComment) {
                $aComments[] = self::convertToObject($aComment);
            }
            return $aComments;
        }


        //supprimer un commentaire précis
        public static function remove(Product $oProduct, User $oUser)
        {
            $oComment = CommentManager::get($oProduct, $oUser);
            $sQuery = "delete from comment ";

            //if($oProduct !== null && $oUser !== null){
                $sQuery .= " where product_id = " . $oProduct->getId();
                $sQuery .= " AND user_email = '" . $oUser->getEmail() . "'";
            //}

            $iRetExec = DBOperation::exec($sQuery);
            if(null !== $sLastSqlError = DBOperation::getLastSqlError()){
                throw new \Exception($sLastSqlError);
            }

        }

        public static function approve(Product $oProduct, User $oUser)
        {
            $oComment = CommentManager::get($oProduct, $oUser);
            $sQuery = "UPDATE `comment` SET `validation` = 1";

            //if($oProduct !== null && $oUser !== null){
                $sQuery .= " where product_id = " . $oProduct->getId();
                $sQuery .= " AND user_email = '" . $oUser->getEmail() . "'";
            //}

            $iRetExec = DBOperation::exec($sQuery);
            if(null !== $sLastSqlError = DBOperation::getLastSqlError()){
                throw new \Exception($sLastSqlError);
            }

        }


    }