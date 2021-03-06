<?php 
    /**
     * PDO Database Class
     * Connect to database
     * Create prepared statements
     * Bind values
     * Return row and values
     */
    class Database{
        private $host = DB_HOST;
        private $user = DB_USER;
        private $password = DB_PASS;
        private $dbname = DB_NAME;

        private $dbh;// database handler => prepare a statement
        private $stmt;
        private $error;

        /**
         * Establish the connection to the database
         */
        public function __construct(){
            //set DSN
            $dsn = 'mysql:host='.$this->host.';dbname='.$this->dbname;
            $options = array(
                PDO::ATTR_PERSISTENT =>true, //persist connection for better performance
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION //errors handling;
            );

            //Create PDO instance
            try {
                $this->dbh = new PDO($dsn, $this->user,$this->password, $options);
            } catch(PDOException $error){
                $this->error = $error->getMessage();
            }
        }

        /**
         * Prepare statement with query
         *
         * @param [type] $sql
         * @return void
         */
        public function query($sql){
            $this->stmt = $this->dbh->prepare($sql);
        }

        /**
         * Bind values
         *
         * @param [type] $param
         * @param [type] $value
         * @param [type] $type
         * @return void
         */
        public function bind($param, $value, $type=null){
            if(is_null($type)){
                switch(true){
                    case is_int($value):
                        $type = PDO::PARAM_INT;
                        break;
                    case is_bool($value):
                        $type = PDO::PARAM_BOOL;
                        break;
                    case is_null($value):
                        $type = PDO::PARAM_NULL;
                        break;
                    default:
                        $type = PDO::PARAM_STR;
                }
            }
            $this->stmt->bindValue($param,$value,$type);            
        }
        
        /**
         * Execute the prepared statement
         *
         * @return void
         */
        public function execute(){
            return $this->stmt->execute();
        }

       /**
        * Get result set as array of objects
        *
        * @return void
        */
        public function resultSet(){
            $this->execute();
            return $this->stmt->fetchAll(PDO::FETCH_OBJ);
        }

        /**
         * Get single record as object
         *
         * @return void
         */
        public function single(){
            $this->execute();
            return $this->stmt->fetch(PDO::FETCH_OBJ);
        }

        /**
         * Get row count
         *
         * @return void
         */
        public function rowCount(){
            return $this->stmt->rowCount();
        }
    }