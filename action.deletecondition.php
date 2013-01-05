<?php
if (!isset($gCms)) exit;

if (!$this->CheckPermission('Edit Conditions'))
  {
    echo $this->ShowErrors($this->Lang('accessdenied'));
    return;
  }

$idconditions = isset($params['idconditions']) ? $params['idconditions'] : '';

// Do a usage search on the location to remove it and prevent errors
$sql = 'SELECT idquestions, idconditions FROM '.cms_db_prefix().'module_practiceportal_questions';
$dbr = $db->Execute($sql);
while($dbr && $row = $dbr->FetchRow()) {
    $cons = json_decode($row['idconditions'], true);
    if(($key = array_search($idconditions, $cons)) !== false) {
        unset($cons[$key]);
    }
    $cons = json_encode($cons);
    $sql = 'UPDATE '.cms_db_prefix().'module_practiceportal_questions SET idconditions=? WHERE idquestions=?';
    $db->Execute($sql, array($cons, $row['idquestions']));
}

$sql = 'DELETE FROM '.cms_db_prefix().'module_practiceportal_conditions '
    .'WHERE idconditions=?;';
$dbr = $db->Execute($sql, array($idconditions));

if( !$dbr )
  {
    // Check and echo errors with SQL
    echo "DEBUG: SQL = ".$db->sql."<br/>";
    die($db->ErrorMsg());
  }

$params = array('tab_message'=> 'deletesuccess', 'active_tab' => 'conditions');
$this->Redirect($id, 'defaultadmin', $returnid, $params);
?>
