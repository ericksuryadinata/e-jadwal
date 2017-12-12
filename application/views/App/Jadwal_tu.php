<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="content-wrapper">
  <div class="row">
    <div class="col-xs-12">
     	<section class="content">
	        <section class="content-header">
	          <h1>Jadwal<small>Tata Usaha</small></h1>
	          <ol class="breadcrumb">
	            <li class="active"><i class="fa fa-book"></i> Jadwal Tata Usaha</li>
	          </ol>
	        </section>
	        <section class="content">
				<div class="row">
                    <div class="col-xs-12">
						<?php
						if($sekarang['tahunajar'] === FALSE){
							echo "<h4 class='text-danger'>Tidak ada tahun ajar yang diaktifkan</h4>";
						}else{
							echo "<h4>Tahun Ajaran ".$sekarang['tahun']." Semester ".$sekarang['semester']."</h4>";
						}
						?>
					</div>
					<div class="col-xs-12">
						<div class="box box-default">
							<div class="box-header with-border">
								<i class="fa fa-user-plus"></i>
								<h3 class="box-title">Upload Jadwal Tata Usaha</h3>
							</div>
							<div class="box-body">
								<p>Gunakan fitur ini untuk Upload Jadwal Tata Usaha</p>
								<?php echo form_open_multipart('MP_Back/upload_excel_tu','class="form-inline"')?>
								<input name="btn" type="submit" class="btn btn-primary" value="Upload Jadwal Tata Usaha">
								<div class="form-group">
									<input class="form-control" type="file" name="file">
								</div>
								<?php echo form_close()?>
							</div>
						</div>
					</div>
                    <div class="col-xs-12">
                        <button class="btn btn-primary" id="tambah"><span class="fa fa-user-plus"></span>&nbsp;Tambah Jadwal Tata Usaha</button>
                        <button class="btn btn-default" id="refresh"><span class="fa fa-refresh"></span>&nbsp;Refresh Tabel</button>
                    </div>
					<div class="col-xs-12">
					<!-- content box -->
						<div class="box">
							<div class="box-body table-responsive">
								<table id="dt-1" class="table table-bordered table-striped ">
									<thead>
										<tr>
											<th>No</th>
											<th>Fakjur</th>
											<th>Nama Fakultas</th>
											<th>Kode Tata Usaha</th>
											<th>Nama Tata Usaha</th>
                                            <th>Jadwal</th>
                                            <th>Tahun Ajar - Semester</th>
                                            <th>Action</th>
										</tr>
									</thead>
									<tbody>
									</tbody>
								</table>
							</div>
						</div>
						<!-- content box -->

					<!-- another content goes here-->
					</div>
				</div>
	        </section>
	        <p class="col-xs-12">Page rendered in <strong>{elapsed_time}</strong> seconds. <?php echo  (ENVIRONMENT === 'development') ?  'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?></p>
     	</section>
    </div>
  </div>
</div>
<?php echo $pesan ?>

<!-- Bootstrap modal -->
<div class="modal fade" id="tu_modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Tambah Jadwal Tata Usaha</h3>
            </div>
            <div class="modal-body form">
                <?php echo form_open('#','class="form-horizontal", id="form_tu"');?>
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Prodi / Fakultas</label>
                            <div class="col-md-9">
                                <select class="form-control" id="prodi" name="prodi" required>
                                <option value="pd">-- Program Studi --</option>
                                <?php
                                    foreach ($jurusan as $jrsn) {
                                        echo "<option value='$jrsn->kode_jurusan'>$jrsn->nama_jurusan</option>";
                                    }
                                ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Kode Tata Usaha</label>
                            <div class="col-md-9">
                                <select class="form-control" id="kodetu" name="kodetu" required>
                                    <option value="">-- Pilih Tata Usaha --</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Hari</label>
                            <div class="col-md-9">
                                <select class="form-control" id="hari" name="hari" required>
                                    <option value="">-- PILIH HARI --</option>
                                    <option value="senin">Senin</option>
                                    <option value="selasa">Selasa</option>
                                    <option value="rabu">Rabu</option>
                                    <option value="kamis">Kamis</option>
                                    <option value="jumat">Jumat</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Jam</label>
                            <div class="col-md-9">
                                <input name="jam" id='jam' placeholder="Jam Kerja" class="form-control" type="text" required>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Tahun Ajar - Semester</label>
                            <div class="col-md-9">
                                <input name="tahunajar" id='tahunajar' placeholder="Contoh Pengisian : 20171" class="form-control" type="text" required>
                                <span class="help-block"></span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="btnSave" class="btn btn-primary">Simpan</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    </div>
                <?php echo form_close();?>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->

<script type="text/javascript">
	var sm, table, oid;
    $(document).ready(function () {
        table = $('#dt-1').DataTable({

            processing: true,
            serverSide: true,
            order: [],
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            ajax: {
                url: '<?php echo site_url('MP_Back/list_jadwal_tu')?>',
                type: 'POST',
                data: {'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'}
            },
            columnDefs: [
                { 
                    targets: [ 0, 5, 6, -1 ],
                    orderable: false, 
                },
            ],

        });

        $("#tambah").on('click',function(event) {
            event.preventDefault();
            sm = "tambah";
            $('#form_tu')[0].reset(); 
            $('.form-group').removeClass('has-error'); 
            $('.help-block').empty();
            $('#tu_modal').modal('show');
        });

        $("#refresh").on('click', function(event) {
            event.preventDefault();
            table.ajax.reload(null,false);
        });

        $("#prodi").on('change', function(event) {
            event.preventDefault();
            var prodi = $('#prodi option:selected').val();
            var csrf = {'prodi':prodi, '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'};
            $.ajax({
                url: '<?php echo site_url('MP_Back/kode_tu')?>',
                type: 'POST',
                dataType: 'JSON',
                data: csrf,
                success: function(data) {
                    $('#kodetu').empty();
                    if(data == null){
                        $('#kodetu').append('<option value="" selected>-- Pilih Tata Usaha--</option>');
                    }else{
                        $('#kodetu').append('<option value="">-- Pilih Tata Usaha--</option>');
                        for(var i=0;i<data.length;i++){
                            $('#kodetu').append('<option value='+data[i].kode_tu+'>'+data[i].kode_tu+' - '+data[i].nama_tu+'</option>');
                        }
                    }
                }
            });
        });

        $("#form_tu").validate({
            rules:{
                prodi: "required",
                kodetu: "required",
                hari: "required",
                jam: "required"
            },
            messages:{
                prodi: "pilih fakultas",
                kodetu: "masukkan kode tu",
                hari: "masukkan hari",
                jam: "masukkan jam"
            },
            submitHandler: function(form){
                var url;
                var get;
                $('#btnSave').text('saving...');
                $('#btnSave').attr('disabled',true);

                if(sm == 'tambah') {
                    url = "<?php echo site_url('MP_Back/tambah_jadwal_tu')?>";
                    get = $(form).serialize();
                } else {
                    url = "<?php echo site_url('MP_Back/update_jadwal_tu')?>";
                    get = $(form).serialize() + "&val=" + oid;
                }
                // ajax adding data to database
                $.ajax({
                    url : url,
                    type: "POST",
                    data: get,
                    dataType: "JSON",
                    success: function(data)
                    {
                        if(data.status)
                        {
                            $('#tu_modal').modal('hide');
                            $("#refresh").trigger('click');
                            if(sm == 'tambah'){
                                swal("Sukses", "Penambahan data sukses", "success");
                            }else{
                                swal("Sukses", "Perubahan data sukses", "success");
                            }
                            
                        }
                        $('#btnSave').text('save');
                        $('#btnSave').attr('disabled',false);
                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        swal("Error", "Penambahan data gagal", "error");
                        $('#btnSave').text('save');
                        $('#btnSave').attr('disabled',false);
                    }
                });
            }
        });
    });

    function delete_jadwal_tu(id){
        swal({
          title: 'Apakah Anda Yakin?',
          text: "Data Akan Terhapus!",
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Ya, Hapus Data!',
          cancelButtonText: 'Tidak, Batalkan!'
        }).then(function () {
            var csrf = {'id_jadwal':id,'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'};
            $.ajax({
                url : "<?php echo site_url('MP_Back/hapus_jadwal_tu')?>",
                type: "POST",
                dataType: "JSON",
                data: csrf,
                success: function(data)
                {
                    //if success reload ajax table
                    if(data.status){
                        table.search('');
                        $("#refresh").trigger('click');
                        swal("Sukses", "Penghapusan data berhasil", "success");    
                    }else{
                        table.search('');
                        $("#refresh").trigger('click');
                        swal("Error", "Penghapusan data gagal", "error");    
                    }
                    
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    swal("Error", "Penghapusan data gagal", "error");
                }
            });
        }).catch(swal.noop);
    }

    function update_jadwal_tu(id){
        sm = 'update';
        $('#form_tu')[0].reset();
        $('.form-group').removeClass('has-error');
        $('.help-block').empty();

        var csrf = {'id_jadwal':id,'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'};
        //Ajax Load data from ajax
        $.ajax({
            url : "<?php echo site_url('MP_Back/edit_jadwal_tu')?>",
            type: "POST",
            dataType: "JSON",
            data: csrf,
            success: function(data)
            {
                $('[name="prodi"]').val(data.edit.fakjur);
                $('#kodetu').empty();
                for(var i=0;i<data.tu.length;i++){
                    if(data.tu[i].kode_tu === data.edit.kode_tata_usaha){
                        $('#kodetu').append('<option value='+data.tu[i].kode_tu+'selected>'+data.tu[i].kode_tu+' - '+data.tu[i].nama_tu+'</option>');
                    }else{
                        $('#kodetu').append('<option value='+data.tu[i].kode_tu+'>'+data.tu[i].kode_tu+' - '+data.tu[i].nama_tu+'</option>');
                    }
                }
                $('[name="hari"]').val(data.edit.hari);
                oid = data.edit.id_jadwal_tu;
                $('[name="jam"]').val(data.edit.jam);
                $('[name="tahunajar"]').val(data.edit.tahun_ajaran);
                $('#tu_modal').modal('show');
                $('.modal-title').text('Edit Tata Usaha');
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                swal("Error", "Error Mendapatkan Data Ajax", "error");
            }
        });
    }
</script>