<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="content-wrapper">
    <div class="row">
        <div class="col-xs-12">
            <section class="content">
                <section class="content-header">
                    <h1>Data<small>Tahun Ajar</small></h1>
                    <ol class="breadcrumb">
                        <li class="active"><i class="fa fa-book"></i> Tahun Ajar</li>
                    </ol>
                </section>
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            <button class="btn btn-primary" id="tambah"><span class="fa fa-user-plus"></span>&nbsp;Tambah Jadwal</button>
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
                                                <th>Tahun</th>
                                                <th>Semester</th>
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
                </section>
                <p class="col-xs-12">Page rendered in <strong>{elapsed_time}</strong> seconds. <?php echo  (ENVIRONMENT === 'development') ?  'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?></p>
            </section>
        </div>
    </div>
</div>
<?php echo $pesan ?>

<!-- Bootstrap modal -->
<div class="modal fade" id="tahunajar_modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Tambah Tahun Ajar</h3>
            </div>
            <div class="modal-body form">
                <?php echo form_open('#','class="form-horizontal", id="form_tahunajar"');?>
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Tahun Ajar</label>
                            <div class="col-md-9">
                                <input class="form-control" placeholder="Tahun Ajar" type="text" name="tahunajar" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Semester</label>
                            <div class="col-md-9">
                                <select class="form-control" id="semester" name="semester" required>
                                	<option value="1">Ganjil</option>
                                	<option value="2">Genap</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" id="btnSave" class="btn btn-primary">Save</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                <?php echo form_close();?>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->

<script type="text/javascript">
    var sm, table, oid;
    $(document).ready(function() {
        table = $('#dt-1').DataTable({

            processing: true,
            serverSide: true,
            order:[],
            lengthMenu:[[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            "ajax":{
                "url": "<?php echo site_url('MP_Back/list_tahunajar')?>",
                "type": "POST",
                "data": {'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'}
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
            $('#form_tahunajar')[0].reset(); 
            $('.form-group').removeClass('has-error'); 
            $('.help-block').empty();
            $('#tahunajar_modal').modal('show');
        });

        $("#refresh").on('click', function(event) {
            event.preventDefault();
            table.ajax.reload(null,false);
        });

        $("#form_tahunajar").validate({
            rules:{
                tahun:"required",
                semester:"required"
            },
            messages:{
                tahun:"Masukkan tahun",
                semester:"Masukkan semester"
            },
            submitHandler: function(form){
                var url;
                var get;
                $('#btnSave').text('saving...');
                $('#btnSave').attr('disabled',true);

                if(sm == 'tambah') {
                    url = "<?php echo site_url('MP_Back/tambah_tahunajar')?>";
                    get = $(form).serialize();
                } else {
                    url = "<?php echo site_url('MP_Back/update_tahunajar')?>";
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
                            $('#tahunajar_modal').modal('hide');
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
                        if(sm == 'tambah'){
                            swal("Error", "Penambahan data gagal", "error");
                        }else{
                            swal("Error", "Perubahan data gagal", "error");
                        }
                        $('#btnSave').text('save');
                        $('#btnSave').attr('disabled',false);
                    }
                });
            }
        });
    });

    function aktifkan_ta(id,stat){
        if(stat === 'Aktifkan'){
            status = 'A';
        }else{
            status = 'T';
        }
        var csrf = {'id_tahunajar':id,'status':status,'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'};

        $.ajax({
            url : "<?php echo site_url('MP_Back/aktifkan_tahunajar')?>",
            type: "POST",
            dataType: "JSON",
            data: csrf,
            success: function(data)
            {
                if(data.status){
                    table.search('');
                    $("#refresh").trigger('click');
                    if(data.aktif === 'A'){
                        swal("Sukses", "Aktifasi", "success");        
                    }else{
                        swal("Sukses", "Non Aktifkan", "success");    
                    }
                    
                } else {
                    table.search('');
                    $("#refresh").trigger('click');
                    swal("Error", "Terjadi kesalahan aktifasi", "error");
                }
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                swal("Error", "Error Mendapatkan Data Ajax", "error");
            }
        });
    }

    function update_ta(id){
        sm = 'update';
        $('#form_tahunajar')[0].reset();
        $('.form-group').removeClass('has-error');
        $('.help-block').empty();

        var csrf = {'id_tahunajar':id,'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'};
        //Ajax Load data from ajax
        $.ajax({
            url : "<?php echo site_url('MP_Back/edit_tahunajar')?>",
            type: "POST",
            dataType: "JSON",
            data: csrf,
            success: function(data)
            {
                $('#tahunajar_modal').modal('show');
                $('.modal-title').text('Edit Tahun Ajar');
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                swal("Error", "Error Mendapatkan Data Ajax", "error");
            }
        });
    }

    function delete_ta(id){
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
            var csrf = {'id_tahunajar':id,'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'};
            $.ajax({
                url : "<?php echo site_url('MP_Back/hapus_tahunajar')?>",
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
</script>