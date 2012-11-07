<?php
class comoptActions extends opJsonApiActions
{
  public function executeList(sfWebRequest $request)
  {
    $communityId = $request['id'];
    $type = $request['type'];
    if ('' == $communityId || '' == $type)
    {
      return $this->renderJSON(array('status' => 'error' ,'message' => "parameter error."));
    }

    $sql = '';
    $sql .= 'select c_file_id, filename, original_filename from c_file';
    $sql .= ' where filename like "';
    if ('topic' == $type)
    {
      $sql .= 't_';
    }
    elseif ('comment' == $type) {
      $sql .= 'tc_';
    }
    $sql .= $communityId.'_4_%';
    $sql .= '"';

    $conn = Doctrine_Manager::getInstance()->getCurrentConnection();
    $files = $conn->fetchAll($sql);

    return $this->renderJSON(array('status' => 'success', 'data' => $files));
  }
}
