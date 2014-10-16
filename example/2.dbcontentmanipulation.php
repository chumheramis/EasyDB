<?php
if($edb->isConnected()){
    /********************************************
     * Create Tables                            *
     ********************************************/
    echo "<p class='msgHeader'>Create Tables</p>";
    $user=array(
        'tblname'=>'user',
        'columns'=>array(
            array(
                'name'=>'id',
                'type'=>'int',
                'primary'=>true,
                'unique'=>true,
                'autoincrement'=>true,
                'notnull'=>true
            ),
            array(
                'name'=>'userlevel',
                'type'=>'int',
                'length'=>1,
                'default'=>'2'
            ),
            array(
                'name'=>'username',
                'type'=>'varchar',
                'length'=>45,
                'unique'=>true,
                'notnull'=>true
            ),
            array(
                'name'=>'password',
                'type'=>'varchar',
                'length'=>20,
                'notnull'=>true
            ),
            array(
                'name'=>'firstname',
                'type'=>'varchar',
                'length'=>45
            ),
            array(
                'name'=>'midname',
                'type'=>'varchar',
                'length'=>1,
            ),
            array(
                'name'=>'lastname',
                'type'=>'varchar',
                'length'=>45
            ),
            array(
                'name'=>'age',
                'type'=>'int',
                'length'=>2
            ),
            array(
                'name'=>'email',
                'type'=>'varchar'
            ),
            array(
                'name'=>'gender',
                'type'=>'varchar',
                'length'=>6
            )
        )
    );
    $testTable1=array(
        'tblname'=>'testtable1',
        'columns'=>array(
            array(
                'name'=>'id',
                'type'=>'varchar'
            ),
            array(
                'name'=>'content',
                'type'=>'text'
            )
        )
    );
    $testTable2=array(
        'tblname'=>'testtable2',
        'columns'=>array()
    );
    function createTable($tblOption){
        global $edb;
        echo "<p class='message'>Creating `".$tblOption['tblname']."` table: ";
        if($edb->createTable($tblOption)){
            echo "<span class='success'>Success</span>";
        }else{
            echo "<span class='error'>Failed</span>";
        }
        echo "</p>";
    }
    createTable($user); // This will be displayed because the value in the parameter array is valid.
    createTable($testTable1); // This will be displayed because the value in the parameter array has at least more than 0 columns.
    createTable($testTable2); // This will be displayed because the value in the parameter array has an empty columns.
    /********************************************
     * Delete Tables                            *
     ********************************************/
    echo "<p class='msgHeader'>Delete Tables</p>";
    function deleteTable($tblname){
        global $edb;
        echo "<p class='message'>Deleting `".$tblname."` table: ";
        if($edb->deleteTable($tblname)){
            echo "<span class='success'>Success</span>";
        }else{
            echo "<span class='error'>Failed</span>";
        }
        echo "</p>";
    }
    // This will display 'success' because 'user' was succesfully created during the createtable phase.
    // deleteTable('user'); // Uncomment this code to for testing.
    // This will display 'success' because 'testtable1' was succesfully created during the createtable phase.
    deleteTable('testtable1');
    // This will display 'failed' because the 'testtable2' was not succesfully created during the createtable phase.
    deleteTable('testtable2');
    /********************************************
     * SHOW TABLES                              *
     ********************************************/
    echo "<p class='msgHeader'>Get Tables</p>";
    echo "<p class='message'>Retrieving Table List...</p>";
    $tbls=$edb->getTables();
    if($tbls){
        foreach($tbls as $tblname){
            echo "<p class='message'><span class='success'>".$tblname."</span></p>";
        }
    }else{
        echo "<p class='message'><span class='error'>No tables</span></p>";
    }
    /********************************************
     * HAS TABLE                                *
     ********************************************/
    echo "<p class='msgHeader'>Has Table</p>";
    function hasTable($tblname){
        global $edb;
        echo "<p class='message'>Does '".$tblname."' exists? ";
        if($edb->hasTable($tblname)){
            echo "<span class='success'>Yes</span>";
        }else{
            echo "<span class='error'>No</span>";
        }
        echo "</p>";
    }
    hasTable('user');
    hasTable('testtable1');
    hasTable('testtable2');
    /********************************************
     * GET COLUMNS                              *
     ********************************************/
    echo "<p class='msgHeader'>GET COLUMNS</p>";
    echo "<p class='message'>Retrieving 'user' table's columns...</p>";
    $cols=$edb->getColumn('user');
    if($cols){
        foreach($cols as $col){
            echo "<p class='message'><span class='success'>".$col."</span></p>";
        }
    }else{
        echo "<p class='message'><span class='error'>No columns</span></p>";
    }
}
