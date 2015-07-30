<?php

   namespace ecommerce\model;


    class Order
    {
        private $iId;
        private $sUser_email;
        private $dDate;
        private $iTotal;
        private $aProduct = array();	


			/**
         * @param mixed $iId
         */
        public function setId($iId)
        {
            $this->iId = $iId;
        }

         /**
         * @return int
         */
        public function getId()
        {
            return $this->iId;
        }


        /**
         * @param mixed $dDate
         */
        public function setDate($dDate)
        {
            $this->dDate = $dDate;
        }

        /**
         * @return mixed
         */
        public function getDate()
        {
            return $this->dDate;
        }


			/**
         * @param mixed $aProduct
         */
        public function addProduct($aProduct)
        {
            $this->aProduct[] = $aProduct;
        }

        /**
         * @return mixed
         */
        public function getProduct()
        {
            return $this->aProduct;
        }


			/**
         * @param mixed $iTotal
         */
        public function setTotal($iTotal)
        {
            $this->iTotal = $iTotal;
        }

        /**
         * @return mixed
         */
        public function getTotal()
        {
            return $this->iTotal;
        }


        /**
         * @param mixed $sUser_email
         */
        public function setUserMail($sUser_email)
        {
            $this->sUser_email = $sUser_email;
        }

        /**
         * @return mixed
         */
        public function getUserMail()
        {
            return $this->sUser_email;
        }

   }