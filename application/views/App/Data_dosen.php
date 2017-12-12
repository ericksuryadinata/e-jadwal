<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="content-wrapper">
  <div class="row">
    <div class="col-xs-12">
     	<section class="content">
	        <section class="content-header">
	          <h1>Data<small> Dosen</small></h1>
	          <ol class="breadcrumb">
	            <li class="active"><i class="fa fa-book"></i> Data Dosen</li>
	          </ol>
	        </section>
	        <section class="content">
				<div class="row">
                    <div class="col-xs-12">
						<div class="box box-default">
							<div class="box-header with-border">
								<i class="fa fa-user-plus"></i>
								<h3 class="box-title">Upload Data Dosen</h3>
							</div>
							<div class="box-body">
								<p>Gunakan fitur ini untuk Upload Data Dosen</p>
								<?php echo form_open_multipart('MP_Back/upload_excel_dosen','class="form-inline"')?>
								<input name="btn" type="submit" class="btn btn-primary" value="Upload Data Dosen">
								<div class="form-group">
									<input class="form-control" type="file" name="file">
								</div>
								<?php echo form_close()?>
							</div>
						</div>
					</div>
                    <div class="col-xs-12">
                        <button class="btn btn-primary" id="tambah"><span class="fa fa-user-plus"></span>&nbsp;Tambah Data Dosen</button>
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
                                            <th>Fakultas</th>
                                            <th>NIP / NPP</th>
											<th>Kode Dosen</th>
											<th>Nama Dosen</th>
											<th>Telepon</th>
                                            <th>Aksi</th>
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
<div class="modal fade" id="dosen_modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Tambah Data Dosen</h3>
            </div>
            <div class="modal-body form">
                <?php echo form_open('#','class="form-horizontal", id="form_dosen"');?>
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Prodi / Fakultas</label>
                            <div class="col-md-9">
                                <select class="form-control" id="prodi" name="prodi" required>
                                <option value="pd">-- Program Studi --</option>
                                <?php
                                    foreach ($jurusan as $jrsn) {
                                        if($jrsn->kode_jurusan == 40){

                                        }else{
                                            echo "<option value='$jrsn->kode_jurusan'>$jrsn->nama_jurusan</option>";  
                                        }
                                    
                                    }
                                ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">NIP / NPP</label>
                            <div class="col-md-9">
                                <input name="nip" id='nip' placeholder="NIP / NPP" class="form-control" type="text" required>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Kode Dosen</label>
                            <div class="col-md-9">
                                <input name="kodedosen" id='kodedosen' placeholder="Kode Dosen" class="form-control" type="text" required>
                                <span class="help-block" id='koderes'></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Nama Dosen</label>
                            <div class="col-md-9">
                                <input name="namadosen" id='namadosen' placeholder="Nama Dosen" class="form-control" type="text" required>
                                <span class="help-block" id='dosenres'></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Telepon</label>
                            <div class="col-md-9">
                                <input name="telepon" id='telepon' placeholder="Telepon" class="form-control" type="text">
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
                url: '<?php echo site_url('MP_Back/list_data_dosen')?>',
                type: 'POST',
                data: {'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'}
            },
            columnDefs: [
                { 
                    targets: [ 0, -1 ],
                    orderable: false, 
                },
            ],
        });

        $("#tambah").on('click',function(event) {
            event.preventDefault();
            sm = "tambah";
            $('#form_dosen')[0].reset(); 
            $('.form-group').removeClass('has-error'); 
            $('.help-block').empty();
            $('#dosen_modal').modal('show');
        });

        $("#refresh").on('click', function(event) {
            event.preventDefault();
            table.ajax.reload(null,false);
        });

        $("#form_dosen").validate({
            rules:{
                nip: "required",
                kodedosen: "required",
                namadosen: "required",
            },
            messages:{
                nip: "pilih fakultas",
                kodedosen: "masukkan kode dosen",
                namadosen: "masukkan kode dosen",
            },
            submitHandler: function(form){
                var url;
                var get;
                $('#btnSave').text('saving...');
                $('#btnSave').attr('disabled',true);

                if(sm == 'tambah') {
                    url = "<?php echo site_url('MP_Back/tambah_data_dosen')?>";
                    get = $(form).serialize();
                } else {
                    url = "<?php echo site_url('MP_Back/update_data_dosen')?>";
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
                            $('#dosen_modal').modal('hide');
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

    function delete_dosen(id){
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
            var csrf = {'id_dosen':id,'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'};
            $.ajax({
                url : "<?php echo site_url('MP_Back/hapus_data_dosen')?>",
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

    function update_dosen(id){
        sm = 'update';
        $('#form_dosen')[0].reset();
        $('.form-group').removeClass('has-error');
        $('.help-block').empty();

        var csrf = {'id_dosen':id,'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'};
        //Ajax Load data from ajax
        $.ajax({
            url : "<?php echo site_url('MP_Back/edit_data_dosen')?>",
            type: "POST",
            dataType: "JSON",
            data: csrf,
            success: function(data)
            {
                $('[name="prodi"]').val(data.fakjur);
                $('[name="nip"]').val(data.nip);
                $('[name="kodedosen"]').val(data.kode_dosen);
                $('[name="namadosen"]').val(data.nama_dosen);
                $('[name="telepon"]').val(data.telepon);
                oid = data.id_dosen;
                $('#dosen_modal').modal('show');
                $('.modal-title').text('Edit dosen');
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                swal("Error", "Error Mendapatkan Data Ajax", "error");
            }
        });
    }

</script>