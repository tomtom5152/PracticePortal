<?php
/*******************************************************************************
 * function loadTable($tablename)
 *******************************************************************************
 * Variables
 * $tablename = (String) name of table to be loaded
 *******************************************************************************
 * Returns
 * Data array of the table called
 */
function loadTable($tablename, $options = array()) {
    global $gCms;
    $db = $gCms->GetDb();
    $idfld = 'id'.$tablename;
    
    $order;
    if(array_key_exists('order_by', $options)) {
        $order = ' ORDER BY '.$options['order_by'];
    } else 
        $order = null;
    
    $data = array();
    $sql = 'SELECT * FROM '.cms_db_prefix().'module_practiceportal_'.$tablename.$order;
    $dbr = $db->Execute($sql);
    
    if( !$dbr )
      {
        echo "DEBUG: SQL = ".$db->sql."<br/>";
        die($db->ErrorMsg());
      }
    
    while($dbr && $row = $dbr->FetchRow()) {
        
        $data[$row[$idfld]] = $row;
    }
    
    return $data;
}

function loadSettings() {
    global $gCms;
    $db = $gCms->GetDb();
    $settings = array();
    $sql = 'SELECT * FROM '.cms_db_prefix().'module_practiceportal_settings';
    $dbr=  $db->Execute($sql);
    
    if(!$dbr) {
        echo "DEBUG: SQL = ".$db->sql."<br/>";
        die($db->ErrorMsg());
    }
    
    while($dbr && $row = $dbr->FetchRow()) {
        $data[$row['key']] = $row['value'];
    }
    
    return $data;
}