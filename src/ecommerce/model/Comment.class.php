<?php

    namespace ecommerce\model;


    class Comment
    {
        private $oProduct;
        private $oUser;
        private $sComment;
        private $iMark;
        private $dDate;
        private $sName;

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
         * @param mixed $iMark
         */
        public function setMark($iMark)
        {
            $this->iMark = $iMark;
        }

        /**
         * @return mixed
         */
        public function getMark()
        {
            return $this->iMark;
        }

        /**
         * @param Product $oProduct
         */
        public function setProduct(Product $oProduct)
        {
            $this->oProduct = $oProduct;
        }

        /**
         * @return Product product
         */
        public function getProduct()
        {
            return $this->oProduct;
        }

        /**
         * @param User $oUser
         */
        public function setUser(User $oUser)
        {
            $this->oUser = $oUser;
        }

        /**
         * @return User user
         */
        public function getUser()
        {
            return $this->oUser;
        }

        /**
         * @param mixed $sComment
         */
        public function setComment($sComment)
        {
            $this->sComment = $sComment;
        }

        /**
         * @return mixed
         */
        public function getComment()
        {
            return $this->sComment;
        }

        public function getShortComment($limit)
        {
            return substr($this->getComment(), 0, $limit) . '...';
        }

        /**
         * @param Name $sName
         */
        public function setName($sName)
        {
            $this->sName = $sName;
        }

        /**
         * @return Name name
         */
        public function getName()
        {
            return $this->sName;
        }
		
		
		// function getDateOld()
  //       {
		
		// 	$startDate = $this->getDate();
		// 	$endDate = date("Y-m-d H:i:s");
			
  //           $startDate = strtotime($startDate);
  //           $endDate = strtotime($endDate);
  //           if ($startDate === false || $startDate < 0 || $endDate === false || $endDate < 0 || $startDate > $endDate)
  //               return false;
               
  //           $years = date('Y', $endDate) - date('Y', $startDate);
           
  //           $endMonth = date('m', $endDate);
  //           $startMonth = date('m', $startDate);
           
  //           // Calculate months
  //           $months = $endMonth - $startMonth;
  //           if ($months <= 0)  {
  //               $months += 12;
  //           }
  //           if ($years !== 0)  {
  //               $years--;
  //           }
  //           if ($years < 0)
  //               return false;
           
  //           // Calculate the days
  //                       $offsets = array();
  //                       if ($years > 0)
  //                           $offsets[] = $years . (($years == 1) ? ' year' : ' years');
  //                       if ($months > 0)
  //                           $offsets[] = $months . (($months == 1) ? ' month' : ' months');
  //                       $offsets = count($offsets) > 0 ? '+' . implode(' ', $offsets) : 'now';

  //                       $days = $endDate - strtotime($offsets, $startDate);
  //                       $days = date('z', $days);   
                       
  //           return array('years'=>$years, 'months'=>$months, 'days'=>$days);
  //       } 

        function getDateOld()
        {

            $startDate = $this->getDate();
            $endDate = date("Y-m-d H:i:s");

            $date1 = new \DateTime($startDate);
            $date2 = new \DateTime($endDate);
            $interval = $date1->diff($date2);

            return array('years'=>$interval->y, 'months'=>$interval->m, 'days'=>$interval->d);
        }
		
    }