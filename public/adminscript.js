function comment_edit(e,id) {
  var p_body = e.closest('div.panel.panel-default').find('.panel-body');

  // Ajax fuer Commentquellkot nachladen


  p_body.attr('contenteditable','true');
  alert(id);
}
