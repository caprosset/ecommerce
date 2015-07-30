<?php

        namespace ecommerce\model\dao;

        /**
         * Class DBOperation.
         * DataBase operation.
         *
         * @package ecommerce\db
         */
        class DBOperation
        {
            const HOST = 'localhost';
            const USER = 'root';
            const PWD = 'troiswa';
            const NAME = 'ecommerce';

            /**
             * @var \PDO database.
             */
            private static $oDataBase = null;

            /**
             * Initialize the DataBase connection.
             */
            private static function init()
            {
                if (null === self::$oDataBase) {
                    self::$oDataBase = new \PDO('mysql:host=' . self::HOST . ';dbname=' . self::NAME, self::USER, self::PWD);
                    self::$oDataBase->exec("SET CHARACTER SET utf8");
                    self::$oDataBase->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC); // FETCH_BOTH, FETCH_NUM, FETCH_OBJ
                }
            }

            /**
             * Get all results from a query.
             *
             * @param $sQuery query to execute.
             *
             * @return array all results.
             */
            public static function getAll($sQuery)
            {
                self::init();
                try {
                    $aAll = array();

                    foreach (self::$oDataBase->query($sQuery) as $aRow) {
                        $aAll[] = $aRow;
                    }
                } catch (\PDOException $oPdoException) {
                    echo 'PDO Exception : ' . $oPdoException->getMessage();
                }
                return $aAll;
            }

            /**
             * Get a single row from a query.
             *
             * @param $sQuery query to execute.
             *
             * @return array single row.
             */
            public static function getOne($sQuery)
            {
                self::init();
                try {
                    $oQueryResult = self::$oDataBase->query($sQuery);
                    $aRow = $oQueryResult->fetch();
                } catch (PDOException $oPdoException) {
                    echo 'PDO Exception : ' . $oPdoException->getMessage();
                }
                return $aRow;
            }

            /**
             * Execute a query. Used for insert/update/delete queries.
             *
             * @param $sQuery query to execute.
             *
             * @return bool true if success, false otherwise.
             */
            public static function exec($sQuery)
            {
                self::init();
                try {
                    $iAffectedRows = self::$oDataBase->exec($sQuery);
                } catch (PDOException $oPdoException) {
                    //echo 'PDO Exception : ' . $oPdoException->getMessage();
                    throw new \Exception($oPdoException->getMessage());
                }
                return false !== $iAffectedRows;
            }

            public static function getLastSqlError()
            {
                // Vérifier si la dernière requête avait généré une erreur
                // la méthode errorInfo() de PDO envoie un tableau. Le 3ème élement contient le texte de l'erreur
                $aLasError = self::$oDataBase->errorInfo();

                $sLastError = null;
                if ($aLasError) {
                    $sLastError = $aLasError[2];
                }
                return $sLastError ;
            }

            public static function getLastId()
            {
                return self::$oDataBase->lastInsertId();
            }

        }