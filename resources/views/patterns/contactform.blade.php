<form class="contact-form mb-3" method="POST" action="/contact">
  <input type="hidden" name="_token" value="%%csrf_token%%">
  <div class="row">
    <div class="col-sm">
      <div class="form-group"><label for="contact-name">Họ Tên / Name <span style="color: red;">(*)</span></label><input type="text" id="contact-name" name="name" maxlength="255" class="form-control" required /></div>
      <div class="form-group"><label for="contact-email">Email <span style="color: red;">(*)</span></label><input type="email" id="contact-email" name="email" maxlength="255" class="form-control" required /></div>
      <div class="form-group"><label for="contact-tel">Điện Thoại / Phone Number</label><input type="text" id="contact-tel" name="tel" maxlength="255" class="form-control" /></div>
    </div>
    <div class="col-sm">
      <div class="form-group"><label for="contact-msg">Tin Nhắn / Message <span style="color: red;">(*)</span></label><textarea id="contact-msg" name="msg" maxlength="1000" rows="11" class="form-control" required></textarea></div>
      <div class="form-group"><label></label><input type="submit" value="Gửi Tin Nhắn / Send Message" class="btn btn-primary" /></div>
    </div>
  </div>
</form>
