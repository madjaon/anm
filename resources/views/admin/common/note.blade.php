<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Chú ý</h4>
      </div>
      <div class="modal-body">
        <!-- Custom Tabs -->
        <div class="nav-tabs-custom">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#tab_3" data-toggle="tab">Slug / đường dẫn</a></li>
            <li><a href="#tab_4" data-toggle="tab">Patterns</a></li>
            <li><a href="#tab_5" data-toggle="tab">Tiện ích</a></li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane active" id="tab_3">
              <p><b>Cấu trúc slug / đường dẫn:</b></p>
              <p>Trong cặp dấu ngoặc vuông [] là giá trị thay đổi.</p>
              <p>[quoc-gia]: {{ SLUG_NATION_JAPAN }}, {{ SLUG_NATION_USA }}, {{ SLUG_NATION_KOREAN }}, {{ SLUG_NATION_CHINA }}, {{ SLUG_NATION_VIETNAM }}, {{ SLUG_NATION_OTHER }}</p>
              <p>[tinh-trang]: {{ SLUG_POST_KIND_FULL }}, {{ SLUG_POST_KIND_UPDATING }}</p>
              <ul>
                <li><strong>Trang thể loại: </strong>/the-loai/[ten-the-loai]</li>
                <li><strong>Trang chi tiết truyen: </strong>/[ten-truyen]</li>
                <li><strong>Trang xem truyen: </strong>/[ten-truyen]/[ten-ep]</li>
                <li><strong>Trang danh sách theo quốc gia: </strong>/doc-truyen-[quoc-gia]</li>
                <li><strong>Trang danh sách tác giả: </strong>/tac-gia</li>
                <li><strong>Trang tác giả: </strong>/tag/[tac-gia]</li>
                <li><strong>Trang seri truyen: </strong>/seri/[ten-seri]</li>
                <li><strong>Trang danh sách tình trạng truyen: </strong>/danh-sach-truyen-[tinh-trang]</li>
              </ul>
            </div>
            <!-- /.tab-pane -->
            <div class="tab-pane" id="tab_4">
              <p><b>Mẫu form nhập vào mục Patterns để tạo form chức năng trên trang</b></p>
              <ol>
                <li><strong>Form liên hệ : </strong>%ContactForm%</li>
              </ol>
            </div>
            <!-- /.tab-pane -->
            <div class="tab-pane" id="tab_5">
                <p><b>Hello, my darling!</b></p>
                <ul>
                    <li><a href="/admin/clearallstorage">Xóa Cache Website</a></li>
                    <li><a href="/admin/genthumb">Tạo Thumbnail cho ảnh đại diện avatar (chỉ những ảnh chưa có thumbnail)</a></li>
                    <li><a href="/admin/genwatermark">Gắn Watermark vào ảnh</a></li>
                    <li><a href="/admin/gensitemap">Tạo mới sitemap.xml</a></li>
                    <li><a href="/admin/crawler2">Crawler</a></li>
                </ul>
                <p><span class="label label-warning">Chú ý về chức năng Xóa Cache Website!</span> Hiếm khi sử dụng (ấn nhiều gây ảnh hưởng tới tốc độ load trang). Sử dụng khi có thay đổi về source code hoặc database trên host.</p>
                <p><span class="label label-warning">Chú ý về chức năng tạo Thumbnail!</span> Có thể mất thời gian để tạo Thumbnail.</p>
                <p>Sử dụng khi Ảnh avatar (ảnh đại diện) có thể bị lỗi do file PNG, GIF có thể không tạo được thumbnail khi upload bằng trình upload ảnh.</p>
            </div>
            <!-- /.tab-pane -->
          </div>
          <!-- /.tab-content -->
        </div>
        <!-- nav-tabs-custom -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>