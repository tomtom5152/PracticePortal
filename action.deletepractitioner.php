<?php
if (!isset($gCms)) exit;

if (!$this->CheckPermission('Edit Practitioners'))
  {
    echo $this->ShowErrors($this->Lang('accessdenied'));
    return;
  }

$idpractitioners = isset($params['idpractitioners']) ? $params['idpractitioners'] : '';

// Do a usage search on the practitioner to remove it and prevent errors
$sql = 'SELECT idconditions, idpractitioners FROM '.cms_db_prefix().'module_practiceportal_conditions';
$dbr = $db->Execute($sql);
while($dbr && $row = $dbr->FetchRow()) {
    $practs = json_decode($row['idpractitioners'], true);
    if(($key = array_search($idpractitioners, $practs)) !== false) {
        unset($practs[$key]);
    }
    $practs = json_encode($practs);
    $sql = 'UPDATE '.cms_db_prefix().'module_practiceportal_conditions SET idpractitioners=? WHERE idconditions=?';
    $db->Execute($sql, array($practs, $row['idconditions']));
}

$sql = 'DELETE FROM '.cms_db_prefix().'module_practiceportal_practitioners '
    .'WHERE idpractitioners=?;';
$dbr = $db->Execute($sql, array($idpractitioners));

if( !$dbr )
  {
    // Check and echo errors with SQL
    echo "DEBUG: SQL = ".$db->sql."<br/>";
    die($db->ErrorMsg());
  }

$params = array('tab_message'=> 'deletesuccess', 'active_tab' => 'practitioners');
$this->Redirect($id, 'defaultadmin', $returnid, $params);
?>
