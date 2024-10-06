<div class="col-md-12">
  <!-- general form elements disabled -->
  <div class="card card-primary">
    <div class="card-header">
      <h3 class="card-title">Form Edit Akun Saya</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
      <?php
      echo form_open_multipart('pelanggan/edit') ?>

      <div class="row">
        <div class="col-sm-6">
          <div class="form-group">
            <label>Nama Akun</label>
            <input name="nama_pelanggan" class="form-control" placeholder="Nama Akun" value="<?= set_value('nama_pelanggan') ?>">
          </div>
        </div>
        <div class="col-sm-6">
          <div class="form-group">
            <label>Email</label>
            <input name="email" class="form-control" placeholder="Email" value="<?= set_value('email') ?>">
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-sm-6">
          <div class="form-group">
            <label>Gambar</label>
            <input type="file" name="gambar" class="form-control" id="preview_gambar" required>
          </div>
        </div>

        <div class="col-sm-6">
          <div class="form-group">
            <img src="<?= base_url('assets/foto/default.jpg') ?>" id="gambar_load" width="150px">
          </div>
        </div>
      </div>

      <div class="form-group">
        <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
      </div>

      <?php echo form_close() ?>
    </div>
  </div>
</div>
</div>
<script>
  function bacaGambar(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function(e) {
        $('#gambar_load').attr('src', e.target.result);
      }
      reader.readAsDataURL(input.files[0]);
    }
  }

  $("#preview_gambar").change(function() {
    bacaGambar(this);
  });
</script>