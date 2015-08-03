<?php
    /**
     * Created by PhpStorm.
     * User: Yoann
     * Date: 10/07/14
     * Time: 10:12
     */

    namespace ecommerce\model;


    class User
    {

        private $sEmail;
        private $sPassword;
        private $sAddress;
        private $sName;
        private $sFirstName;
        private $sCp;
        private $sCity;
        private $iRole;


        /**
         * @param mixed $sAddress
         */
        public function setAddress($sAddress)
        {
            $this->sAddress = $sAddress;
        }

        /**
         * @return mixed
         */
        public function getAddress()
        {
            return $this->sAddress;
        }

        /**
         * @param mixed $sEmail
         */
        public function setEmail($sEmail)
        {
            $this->sEmail = $sEmail;
        }

        /**
         * @return mixed
         */
        public function getEmail()
        {
            return $this->sEmail;
        }

        /**
         * @param mixed $sFirstName
         */
        public function setFirstName($sFirstName)
        {
            $this->sFirstName = $sFirstName;
        }

        /**
         * @return mixed
         */
        public function getFirstName()
        {
            return $this->sFirstName;
        }

        /**
         * @param mixed $sName
         */
        public function setName($sName)
        {
            $this->sName = $sName;
        }

        /**
         * @return mixed
         */
        public function getName()
        {
            return $this->sName;
        }

        /**
         * @param mixed $sPassword
         */
        public function setPassword($sPassword)
        {
            $this->sPassword = $sPassword;
        }

        /**
         * @return mixed
         */
        public function getPassword()
        {
            return $this->sPassword;
        }

        public function getCryptedPassword()
        {
            return sha1($this->getPassword());
        }

        /**
         * @param mixed $sCp
         */
        public function setCp($sCp)
        {
            $this->sCp = $sCp;
        }

        /**
         * @return mixed
         */
        public function getCp()
        {
            return $this->sCp;
        }

        /**
         * @param mixed $sCity
         */
        public function setCity($sCity)
        {
            $this->sCity = $sCity;
        }

        /**
         * @return mixed
         */
        public function getCity()
        {
            return $this->sCity;
        }

        /**
         * @param mixed $iRole
         */
        public function setRole($iRole)
        {
            $this->iRole = $iRole;
        }

        /**
         * @return mixed
         */
        public function getRole()
        {
            return $this->iRole;
        }
    }