<?php

/**
 * OldUploadFile actions.
 *
 * @package    OpenPNE
 * @author     Your name here
 */
class comoptActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfWebRequest $request A request object
  */
  public function executeShow(sfWebRequest $request)
  {
    $filename = sprintf('%s', $request->getParameter('filename'));

    $sql = '';
    $sql .= 'select * from c_file';
    $sql .= ' where filename = "';
    $sql .= $filename;
    $sql .= '"';

    $conn = Doctrine_Manager::getInstance()->getCurrentConnection();
    $files = $conn->fetchAll($sql);
    $this->forward404Unless($files);
    $file = $files[0];
    $data = $file['bin'];
    $originalFileName = $file['original_filename'];
    if (!$data)
    {
      return $this->renderJSON(array('status' => 'error', 'message' => "file download error"));
    }
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $type = $finfo->buffer($data);
    $this->getResponse()->setHttpHeader('Content-Type',$type);
    $this->getResponse()->setHttpHeader('Content-Disposition', 'attachment; filename="'.$originalFileName.'"');

    return $this->renderText($data);
  }
}
