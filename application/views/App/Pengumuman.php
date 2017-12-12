<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="content-wrapper">
  <div class="row">
    <div class="col-xs-12">
     	<section class="content">
	        <section class="content-header">
	          <h1>Data<small> Pengumuman dan Pesan</small></h1>
	          <ol class="breadcrumb">
	            <li class="active"><i class="fa fa-book"></i> Data Pengumanan dan Pesan</li>
	          </ol>
	        </section>
	        <section class="content">
                <div class="row">
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="box box-default">
                            <div class="box-header with-border">
                                <i class="fa fa-user-plus"></i>
                                <h3 class="box-title">Data Pengumuman</h3>
                            </div>
                            <div class="box-body">
                                <p>Digunakan untuk mengisi pengumuman / banner</p>
                                <div class="row">
                                    <div class="col-xs-12">
                                        <button class="btn btn-primary" id="tambahpengumuman"><span class="fa fa-user-plus"></span>&nbsp;Tambah Pengumuman</button>
                                        <button class="btn btn-default" id="refreshpengumuman"><span class="fa fa-refresh"></span>&nbsp;Refresh Tabel</button>
                                    </div>
                                    <div class="col-xs-12">
                                    <!-- content box -->
                                        <div class="box">
                                            <div class="box-body table-responsive">
                                                <table id="pengumumantable" class="table table-bordered table-striped ">
                                                    <thead>
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Nama Pengumuman</th>
                                                            <th>Tanggal Tayang</th>
                                                            <th>Tanggal Berakhir</th>
                                                            <th>Gambar</th>
                                                            <th>Status</th>
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
                                
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="box box-default">
                            <div class="box-header with-border">
                                <i class="fa fa-user-plus"></i>
                                <h3 class="box-title">Data Pesan</h3>
                            </div>
                            <div class="box-body">
                                <p>Digunakan untuk mengisi pesan / teks berjalan</p>
                                <div class="row">
                                    <div class="col-xs-12">
                                        <button class="btn btn-primary" id="tambahpesan"><span class="fa fa-user-plus"></span>&nbsp;Tambah Pesan</button>
                                        <button class="btn btn-default" id="refreshpesan"><span class="fa fa-refresh"></span>&nbsp;Refresh Tabel</button>
                                    </div>
                                    <div class="col-xs-12">
                                    <!-- content box -->
                                        <div class="box">
                                            <div class="box-body table-responsive">
                                                <table id="pesantable" class="table table-bordered table-striped ">
                                                    <thead>
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Pesan</th>
                                                            <th>Tanggal Tayang</th>
                                                            <th>Tanggal Berakhir</th>
                                                            <th>Status</th>
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
                                
                            </div>
                        </div>
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
<div class="modal fade" id="pengumuman_modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Tambah Data Pengumuman / Banner</h3>
            </div>
            <div class="modal-body form">
                <?php echo form_open_multipart('#','class="form-horizontal", id="form_pengumuman"');?>
                    <div class="form-body">
                         <div class="form-group">
                            <label class="control-label col-md-3">Nama Pengumuman</label>
                            <div class="col-md-9">
                                <input name="pengumuman" id='pengumuman' placeholder="Pengumuman" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Tanggal Tayang</label>
                            <div class="col-md-9">
                                <input name="tayangpengumuman" id='tayangpengumuman' placeholder="Tanggal Tayang" class="form-control" type="text" required>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Tanggal Berakhir</label>
                            <div class="col-md-9">
                                <input name="akhirpengumuman" id='akhirpengumuman' placeholder="Tanggal Berakhir" class="form-control" type="text" required>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Gambar</label>
                            <div class="col-md-9">
                                <input name="gambar" id='gambar' placeholder="Gambar" class="form-control" type="file" required>
                                <span class="help-block"></span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="btnSavePengumuman" class="btn btn-primary">Simpan</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    </div>
                <?php echo form_close();?>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->


<!-- Bootstrap modal -->
<div class="modal fade" id="pesan_modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Tambah Data Pesan / Teks Berjalan</h3>
            </div>
            <div class="modal-body form">
                <?php echo form_open('#','class="form-horizontal", id="form_pesan"');?>
                    <div class="form-body">
                         <div class="form-group">
                            <label class="control-label col-md-3">Isi Pesan</label>
                            <div class="col-md-9">
                                <input name="pesan" id='pesan' placeholder="pesan" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Tanggal Tayang</label>
                            <div class="col-md-9">
                                <input name="tayangpesan" id='tayangpesan' placeholder="Tanggal Tayang" class="form-control" type="text" required>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Tanggal Berakhir</label>
                            <div class="col-md-9">
                                <input name="akhirpesan" id='akhirpesan' placeholder="Tanggal Berakhir" class="form-control" type="text" required>
                                <span class="help-block"></span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="btnSavePesan" class="btn btn-primary">Simpan</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    </div>
                <?php echo form_close();?>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->

<script type="text/javascript">
    $(document).ready(function () {
        /**
         * Pengumuman
         */
        table = $('#pengumumantable').DataTable({

            processing: true,
            serverSide: true,
            order: [],
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            ajax: {
                url: '<?php echo site_url('MP_Back/list_pengumuman')?>',
                type: 'POST',
                data: {'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'}
            },
            columnDefs: [
                { 
                    targets: [ 0, 4, -1 ],
                    orderable: false, 
                },
            ],

        });

        $("#refreshpengumuman").on('click', function(event) {
            event.preventDefault();
            table.ajax.reload(null,false);
        });

        $("#tambahpengumuman").on('click',function(event) {
            event.preventDefault();
            sm = "tambahpengumuman";
            $('#form_pengumuman')[0].reset(); 
            $('.form-group').removeClass('has-error'); 
            $('.help-block').empty();
            $('#pengumuman_modal').modal('show');
        });

        $("#form_pengumuman").validate({
            rules:{
                pengumuman:"required",
                tayangpengumuman:"required",
                akhirpengumuman:"required",
                gambar:"required"
            },
            messages:{
                pengumuman:"Masukkan nama pengumuman",
                tayangpengumuman:"Masukkan tanggal tayang",
                akhirpengumuman:"Masukkan tanggal akhir",
                gambar:"Masukkan gambar"
            },
            submitHandler: function(form){
                var url;
                var get;
                $('#btnSavePengumuman').text('saving...');
                $('#btnSavePengumuman').attr('disabled',true);

                if(sm == 'tambahpengumuman') {
                    url = "<?php echo site_url('MP_Back/tambah_pengumuman')?>";
                    get = $(form).serialize();
                } else if(sm == 'updatepengumuman'){
                    url = "<?php echo site_url('MP_Back/update_pengumuman')?>";
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
                            $('#pengumuman_modal').modal('hide');
                            $("#refreshpengumuman").trigger('click');
                            if(sm == 'tambahpengumuman'){
                                swal("Sukses", "Penambahan data sukses", "success");
                            }else{
                                swal("Sukses", "Perubahan data sukses", "success");
                            }
                            
                        }
                        $('#btnSavePengumuman').text('save');
                        $('#btnSavePengumuman').attr('disabled',false);
                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        swal("Error", "Penambahan data gagal", "error");
                        $('#btnSavePengumuman').text('save');
                        $('#btnSavePengumuman').attr('disabled',false);
                    }
                });
            }
        });

        /**
         * Pesan
         */
        $("#refreshpesan").on('click', function(event) {
            event.preventDefault();
            table.ajax.reload(null,false);
        });

        $("#tambahpesan").on('click',function(event) {
            event.preventDefault();
            sm = "tambahpesan";
            $('#form_pesan')[0].reset(); 
            $('.form-group').removeClass('has-error'); 
            $('.help-block').empty();
            $('#pesan_modal').modal('show');
        });

    });

    /**
     * Pengumuman
     */
    function delete_pengumuman(id){
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
            var csrf = {'id_pengumuman':id,'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'};
            $.ajax({
                url : "<?php echo site_url('MP_Back/hapus_pengumuman')?>",
                type: "POST",
                dataType: "JSON",
                data: csrf,
                success: function(data)
                {
                    //if success reload ajax table
                    if(data.status){
                        table.search('');
                        $("#refreshpengumuman").trigger('click');
                        swal("Sukses", "Penghapusan data berhasil", "success");    
                    }else{
                        table.search('');
                        $("#refreshpengumuman").trigger('click');
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

    function update_pengumuman(id){
        sm = 'updatepengumuman';
        $('#form_pengumuman')[0].reset();
        $('.form-group').removeClass('has-error');
        $('.help-block').empty();

        var csrf = {'id_pengumuman':id,'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'};
        //Ajax Load data from ajax
        $.ajax({
            url : "<?php echo site_url('MP_Back/edit_pengumuman')?>",
            type: "POST",
            dataType: "JSON",
            data: csrf,
            success: function(data)
            {
                $('[name="pengumuman"]').val(data.nm_pengumuman);
                $('[name="tayangpengumuman"]').val(data.tgl_mulai);
                $('[name="akhirpengumuman"]').val(data.tgl_selesai);
                $('[name="gambar"]').val(data.nm_gambar);
                oid = data.id_pengumuman;
                $('#pengumuman_modal').modal('show');
                $('.modal-title').text('Edit Pengumuman');
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                swal("Error", "Error Mendapatkan Data Ajax", "error");
            }
        });
    }

    /**
     * Pesan
     */
</script>