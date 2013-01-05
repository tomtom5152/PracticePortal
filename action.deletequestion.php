<?php
if (!isset($gCms)) exit;

if (!$this->CheckPermission('PracticePortalQuestions'))
  {
    echo $this->ShowErrors($this->Lang('accessdenied'));
    return;
  }

$idquestions = isset($params['idquestions']) ? $params['idquestions'] : '';

$sql = 'DELETE FROM '.cms_db_prefix().'module_practiceportal_questions '
    .'WHERE idquestions=?;';
$dbr = $db->Execute($sql, array($idquestions));

if( !$dbr )
  {
    // Check and echo errors with SQL
    echo "DEBUG: SQL = ".$db->sql."<br/>";
    die($db->ErrorMsg());
  }

$params = array('tab_message'=> 'deletesuccess', 'active_tab' => 'questions');
$this->Redirect($id, 'defaultadmin', $returnid, $params);
?>
