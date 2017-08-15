<!-- Modal -->
<div class="modal fade" id="myModalPostTypeSelect" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Lựa chọn thể loại</h4>
      </div>
      <div class="modal-body">
        <p><strong>Lưu ý: </strong><span class="label label-warning">Cẩn thận!</span> Tất cả các mục (posts) được lựa chọn đều sẽ thay đổi.</p>
        <p>Tick chọn thể loại để hiện primary (thể loại chính). Tick lại nếu primary vẫn ẩn.</p>
        @include('admin.post.posttype', array('isCreate' => true))
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="indexposttype" onclick="callupdatetype();">Lưu lại</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>