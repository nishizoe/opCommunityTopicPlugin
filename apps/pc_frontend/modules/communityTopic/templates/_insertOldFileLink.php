<?php if ('topic' == $type): ?>
<script id="uploadedFileTemplate" type="text/x-jquery-tmpl">
  <a id="uploadedFileList" href="<?php echo $sf_request->getRelativeUrlRoot(); ?>/comopt/show/${filename}" data-file-path="${filename}" data-file-name="${original_filename}">
    ${original_filename}
  </a>
</script>
<?php endif; ?>
<script type="text/javascript">
$(function(){
  var url = openpne.apiBase;
      url += 'comopt/list?';
      url += 'id=<?php echo $id; ?>';
      url += '&type=<?php echo $type; ?>';
      url += '&apiKey=';
      url += openpne.apiKey;
  $.getJSON(url, function(json) {
    $result = $('#uploadedFileTemplate').tmpl(json.data);
<?php if ('topic' == $type): ?>
      $('#uploadedFileList').html($result);
      $('#uploadedFileList').show();
<?php elseif ('comment' == $type): ?>
    $('#uploadedFileCommentList_<?php echo $id; ?>').html($result);
    $('#uploadedFileCommentList_<?php echo $id; ?>').show();
<?php endif; ?>
  });
});
</script>
<?php if ('topic' == $type): ?>
<div id="uploadedFileList" class="attachFile"></div>
<?php elseif ('comment' == $type): ?>
<div id="uploadedFileCommentList_<?php echo $id; ?>" class="attachFile"></div>
<?php endif; ?>
