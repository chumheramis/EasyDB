<?php
/**
 * @name $edb
 * @author Mark Heramis <chumheramis@gmail.com>
 * @copyright (c) 2014, Mark Heramis
 * @version 1.0
 */
class edb{
    
    /**
     * The mysqli link variable.
     * @var mysqli_link
     */
    private $connection = null;
    /**
     * The mysqli result variable.
     * @var mysqli_result
     */
    private $resultSet = null;
    /**
     * @var string The current database name.
     */
    private $currentDB = null;
    /**
     * @var string The current table name.
     */
    private $currentTBL = null;
    /**
     * The current position of the pointer in the result set.
     * @var int
     */
    private $pointerOffset=0;
    /**
     *
     * @var array The array of errors.
     */
    private $error_message=array();
    
    
    /**
     * Initiate the EasyDatabase class and connect to the server.
     * @category Main
     * @uses connect initiate connection to database.
     * @param String $dbhost the database server host url/ip address.
     * @param String $dbname the database name.
     * @param String $username the database username.
     * @param String $password the database password.
     */
    public function __construct($dbhost, $dbname, $username, $password){
        $this::connect($dbhost, $dbname, $username, $password);
    }
    /**
     * @category Main
     * Close the database connection.
     * @final
     * @category Main
     * @uses close to close the existing connection if connected.
     */
    public final function __destruct(){
        $this::clearQuery();
        $this::close();
    }
    /**
     * Initiate a connection to a database server.
     * @category Main
     * @param type $dbhost
     * @param type $dbname
     * @param type $username
     * @param type $password
     
     */
    private function connect($dbhost,$dbname,$username,$password){
        $this->connection=mysqli_connect($dbhost, $username, $password, $dbname);
        $this->currentDB=($this->isConnected())?$dbname:null;
    }
    /**
     * @category Main
     * @access private
     * @final
     */
    private final function close(){
        @mysqli_close($this->connection);
        $this->connection=null;
        $this->currentDB=null;
    }
    /*
     * @todo finish this function.
     */
    public function useDatabase($dbname){
        
    }
    /**
     * @final
     * @access public
     * Returns true if a connection to a database server is established, return false otherwise.
     * @return boolean
     */
    public final function isConnected(){
        return ($this->connection!=null)?(!mysqli_connect_errno())?true:false:false;
    }
    /*
     * Get an array containing the names of all tables in the current database.
     * @final
     * @return array
     */
    public final function getTables(){
        if(!$this::isConnected()) return;
        $result=mysqli_query($this->connection,'SHOW TABLES');
        $tbls=array();
        while($row=mysqli_fetch_array($result)) array_push($tbls,$row[0]);
        return $tbls;
    }
    /*
     * Get an array containing the nemaes of all columns inside the given table.
     * @params string $tblname the name of the table.
     * @final
     * @retrun array
     */
    public final function getColumn($tblname){
        if(!$this::isConnected()) return;
        $result=mysqli_query($this->connection,"SHOW COLUMNS FROM ".$tblname);
        if($result){
            $columns=array();
            while($col=mysqli_fetch_row($result)) array_push($columns,$col[0]);
            return $columns;
        }
    }
    /**
     * @todo Not done yet
     * @param string $tblname The name of the table to be checked.
     * @return boolean True if the table exsists and false otherwise.
     */
    public function hasTable($tblname){
        if(!$this::isConnected()) return;
        $result=mysqli_query($this->connection,"SHOW TABLES LIKE '".$tblname."'");
        return (mysqli_num_rows($result))?true:false;
    }
    // ************************************************************************* //
    //      Query Functions                                                      //
    // ************************************************************************* //
    
    /**
     * Query a table from the database.
     * Parameter possible value: array(
     *      'tblname'=>'THE NAME OF THE TABLE TO BE QUERIED',
     *      'where'=>array(
     *          array(
     *              'fieldname'=>'THE FIELDNAME',
     *              'operator'=>'THE OPERATOR',
     *              'value'=>'THE VALUE TO CHECK'
     *          ),
     *          ...
     *      ),
     *      'sort'=>'
     * );
     * Example:
     * <?php
     * include "this class";
     * $edb=new edb('thehost', 'thedatabase', 'theuser', 'thepassword');
     * if($edb->query(array('tblname'=>'user'))){
     *      echo 'Query failed or result is empty';
     * }else{
     *      echo 'Query succesfull';
     * }
     * ?>
     * @param Array $option
     *
     * Note: This function is not yet final, It's too messy. Please do give suggestion or
     * just fork the repo and contribute by coding it yourself thankyou. 
     */
    public function select($option){
        if(!$this::isConnected()) return;
        if(empty($option['tblname'])) return;
        $str="SELECT * FROM ".$option['tblname']." ";
        $str.=(!empty($option['where']))?$this::encodeSelectConditions($option['where']):'';
        $str.=(!empty($option['sort']))?$this::encodeSelectSorting($option['sort']):'';

        try{
            $this->resultSet=mysqli_query($this->connection, $str);
            $this->pointerOffset=0;
            return true;
        }catch (Exception $ex){
            return false;
        }
    }
    public function customQuery($sql){
        try{
            $this->resultSet=mysqli_query($this->connection, $sql);
            $this->pointerOffset=0;
            return true;
        }catch(Exception $ex){
            return false;
        }
    }

    public function deleteData($option){
        $str="DELETE FROM `" . $option['tblname'] . "` ";
        $str.= (!empty($option['where']))?$this::encodeSelectConditions($option['where']):'';
        $this->resultSet=mysqli_query($this->connection, $str);
        $this->pointerOffset=0;
        return true;
    }

    public function updateData($option){
        if(!$this::isConnected()) return;
        if(empty($option['tblname'])) return;
        $str="UPDATE ". $option['tblname'] . " SET ";
        $array_keys = array_keys($option['set']);
        $lastElement = array_pop($array_keys);
        foreach($option['set'] as $key => $value){
            $mykey = $key;
            $str.= $key ."='$value' ";
            $str.= ($key != $lastElement) ?",":"";
        }
        $str.=(!empty($option['where']))?$this::encodeSelectConditions($option['where']):'';
    
        try{
            $this->resultSet=mysqli_query($this->connection,$str);
            $this->pointerOffset=0;
            return true;
        }catch(Exception $ex){
            return false;
        }
    }
    public function clearQuery(){
        @mysqli_free_result($this->resultSet);
        $this->resultSet=null;
        $this->currentTBL=null;
    }
    /**
     * @access private
     * @category Query
     * @uses validateQueryOperator The function that validates the operator of the query condition.
     * @uses validateConditionOperator The function that validates the conditional symbol/operator of the query condition.
     * @param Array $option
     * @return String
     */
    private function encodeSelectConditions($option){
        $str='';
        for($i=0;$i<sizeof($option);$i++):
            $operator=$this::validateQueryOperator($option[$i]['operator']);
            $option[$i]['value']=($operator=='LIKE')?"'%".$option[$i]['value']."%'":$option[$i]['value'];
            if(empty($str)):
                #$str.=($operator)?$option[$i]['fieldname'].' '.$operator.' '.$option[$i]['value'].' ':'';
                $str.= ($operator)? $option[$i]['fieldname'] . " " . $operator . " '" . $option[$i]['value'] . "' ": "";
            else:
                if(!empty($option[$i]['condition'])):
                    $cnd=$this::validateConditionOperator($option[$i]['condition']);
                    $str.=($cnd)?($operator)?' '.$cnd.' '.$option[$i]['fieldname'].' '.$operator." '".$option[$i]['value']."' ":'':'';
                endif;
            endif;
        endfor;
        return (!empty($str))?' WHERE '.$str:'';
    }
    /**
     * @category Query
     * @param Array $option
     * @return String
     */
    private function encodeSelectSorting($option){
        $str='';
        if(is_array($option['fieldname'])){
            for($i=0;$i<sizeof($option['fieldname']);$i++){ $str.=(empty($str))?' '.$option['fieldname'][$i].' ':' , '.$option['fieldname'][$i].' '; }
        }else{ $str.=' '.$option['fieldname'].' '; }
        $str.=(array_key_exists('order', $option))?' '.strtoupper($option['order']):' DESC';
        return ' ORDER BY '.$str;
    }
    /**
     * @category General
     * @param String $op
     * @return String || False
     */
    private function validateQueryOperator($op){
        $op=strtoupper($op);
        return ($op=='=' || $op=='<>' || $op=='>' || $op=='<' || $op=='<=' || $op=='>=' || $op=='BETWEEN' || $op=='LIKE' || $op=='IN')?$op:false;
    }
    /**
     * @category General
     * @param String $op
     * @return String || False
     */
    private function validateConditionOperator($op){
        $op=strtoupper($op);
        return ($op=='AND' || $op=='OR')?$op:false;
    }
    /**
     * Return the next data in the resultset if it has, return null otherwise.
     * @category Query
     * @return array
     */
    public function getNext(){
        return @mysqli_fetch_object($this->resultSet);
    }
    /**
     * Move the result pointer to the row number specified by the value of offset,
     * returns true if succesfull and false otherwise.
     * @category Query
     * @param int $offset
     * @return boolean
     */
    public function movePointer($offset){
        return @mysqli_data_seek($this->resultSet, $offset);
    }
    /**
     * Get and return the number of rows in the resultset.
     * @return int
     */
    public function getRowCount(){
        return @mysqli_num_rows($this->resultSet);
    }
    /**
     * Return true if a result has been succesfully queried and false if result is empty or nothing has been queried yet.
     * @return Boolean
     */
    public function isEmpty(){
        return ($this->getRowCount())?true:false;
    }
    /**
     * Create database table.
     * @category createTable
     * @uses encodeColumns Used to handle column sql string.
     * @param array $option
     * @return boolean true if the table is succesfully created and false otherwise.
     */
    public function createTable($option){
        if(!empty($option['tblname']) && !empty($option['columns'])):
            $str="CREATE TABLE `".$option['tblname']."` ";
            $str.='('.$this::encodeColumns($option['columns']).')';
            return (mysqli_query($this->connection, $str))?true:false;  
        endif;
    }
    public function deleteTable($tblname){
        $str='DROP TABLE `'.$tblname.'`';
        if(mysqli_query($this->connection,$str)){
            return true;
        }
    }

    public function insertData($option){

        
        $tblname=$option['tblname'];
        $cols='';
        $vals=array();
        $cols = implode(',', $option['columns']);
        $vals = implode("','", $option['value']);
        
        $sql="INSERT INTO $tblname ($cols) VALUES ('$vals')";

        try{
            return (mysqli_query($this->connection, $sql))?true:false;
        }
        catch(Exception $ex){
            var_dump($ex);
            return false;
        }
    }

    public function insertId(){
        return $this->connection->insert_id;
    }
    
    /**
     * create the columns sql string statement.
     * @param array $colOptions The columns option array.
     * @return string The SQL code of all columns.
     */
    private function encodeColumns($colOptions){
        if(count($colOptions)){
            $str='';
            $primaryArray=array();
            $uniqueArray=array();
            foreach($colOptions as $cols){
                $str.=(empty($str))?$this::encodeColumn($cols):','.$this::encodeColumn($cols);
                if(!empty($cols['primary']) && $cols['primary']){array_push($primaryArray, $cols['name']);}
                if(!empty($cols['unique']) && $cols['unique']){array_push($uniqueArray,$cols['name']);}
            }
            $str.=(count($primaryArray))?','.$this::encodePrimary($primaryArray):',PRIMARY KEY (`'.$colOptions[0]['name'].'`)';
            $str.=(count($uniqueArray))?','.$this::encodeUnique($uniqueArray):'';
            return $str;
        }
    }
    private function encodePrimary($primaryArray){
        $str='';
        foreach($primaryArray as $element){
            $str.=(empty($str))?$element:','.$element;
        }
        return 'PRIMARY KEY('.$str.')';
    }
    private function encodeUnique($uniqueArray){
        $str='';
        foreach($uniqueArray as $element){
            if(empty($str)){
                $str.='UNIQUE INDEX `'.$element.'_UNIQUE`(`'.$element.'` ASC)';
            }else{
                $str.=', UNIQUE INDEX `'.$element.'_UNIQUE`(`'.$element.'` ASC)';
            }
        }
        return $str;
    }
    /**
     * create the single column string sql statement.
     * @param array $colOption
     * @return string
     */
    private function encodeColumn($colOption){
        $str='`'.$colOption['name'].'` ';
        $str.=$this::validateDataType($colOption['type']).' ';
        $str.=(!empty($colOption['length']))?'('.$colOption['length'].') ':$this::getDefaultLength($colOption['type']);
        $str.=(!empty($colOption['unsigned']))?$this::encodeColumnUnsigned($colOption).' ':'';
        $str.=(!empty($colOption['zerofill']))?$this::encodeColumnZeroFill($colOption).' ':'';
        $str.=(!empty($colOption['notnull']))?$this::encodeColumnNotNull($colOption).' ':'';
        $str.=(!empty($colOption['autoincrement']))?$this::encodeColumnAutoIncrement($colOption).' ':'';
        $str.=(!empty($colOption['binary']))?$this::encodeColumnBinary($colOption).' ':'';
        $str.=(!empty($colOption['default']))?$this::encodeColumnDefault($colOption).' ':'';
        return $str;
    }
    /**
     * check if an sql table column is null or not null.
     * @param array $colOption
     * @return string
     */
    private function encodeColumnNotNull($colOption){
        return ($colOption['notnull'])?' NOT NULL ':' NULL ';
    }
    /**
     * check if an sql table column is binary.
     * @param array $colOption
     * @return string
     */
    private function encodeColumnBinary($colOption){
        return ($colOption['binary'] && !$this::isNumeric($colOption['type']))?' BINARY ':'';
    }
    /**
     * check if an sql table column is unsigned.
     * @param array $colOption
     * @return string
     */
    private function encodeColumnUnsigned($colOption){
        return ($colOption['unsigned'] && $this::isNumeric($colOption['type']))?' UNSIGNED ':'';
    }
    /**
     * check if an sql table column is zerofill.
     * @param array $colOption
     * @return string
     */
    private function encodeColumnZeroFill($colOption){
        return ($colOption['zerofill'] && $this::isNumeric($colOption['type']))?' ZEROFILL ':'';
    }
    private function encodeColumnDefault($colOption){
        return "DEFAULT '".$colOption['default']."'";
    }
    /**
     * check if an sql table column is auto incremented.
     * @param array $colOption
     * @return string
     */
    private function encodeColumnAutoIncrement($colOption){
        return ($colOption['autoincrement'] && $this::isNumeric($colOption['type']))?' AUTO_INCREMENT ':'';
    }
    /**
     * check if the sql column datatype is a valid datatype, return the default "VARCHAR" is not valid or return true otherwise.
     * @param string $type
     * @return string
     */
    private function validateDataType($type){
        $type=strtoupper($type);
        $typearray=array(
            'BIGINT','DECIMAL','DOUBLE','FLOAT','INT','MEDIUMINT','SMALLINT','TINYINT', // Numbers
            'CHAR','VARCHAR','LONGTEXT','MEDIUMTEXT','TEXT','TINYTEXT',                 // Texts and Characters
            'DATETIME','DATE','TIME','TIMESTAMP','YEAR',                                // Date and Time
            'BLOB','BINARY','LONGBLOB','MEDIUMBLOB','TINYBLOB','VARBINARY','BIT'        // Bits and Bytes
        );
        return (array_search($type,$typearray))?$type:'VARCHAR';
    }
    /**
     * check if the sql column datatype is a numeric datatype, return true if the conditions are true and false otherwise.
     * @param string $type
     * @return boolean
     */
    private function isNumeric($type){
        $numericType=array('BIGINT','DECIMAL','DOUBLE','FLOAT','INT','MEDIUMINT','SMALLINT','TINYINT');
        return (array_search(strtoupper($type),$numericType))?true:false;
    }
    /**
     * get the default column value max length.
     * @param string $type
     * @return string
     */
    private function getDefaultLength($type){
        $type=strtoupper($type);
        $default=array('VARCHAR'=>'80','DECIMAL'=>'12');
        return (!empty($default[$type]))?'('.$default[$type].')':'';
    }


}
