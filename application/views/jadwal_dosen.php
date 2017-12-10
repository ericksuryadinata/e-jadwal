  <?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Jadwal Dosen | Fakultas Teknik</title>
    <?php $this->load->view('Partials/Front/Head');?>
  </head>
  <style type="text/css">
    table{
      border-radius: 4px;
    }

    .tbl{
      background-color: #b4cae8;
      border-color: #b4cae8;
    }

    .tbl:hover{
      background-color: #b4cae8;
      border-color: #b4cae8;
    }

    #body{
      background-color: #fff;
    }

    .page-item.disabled .page-link{
      color:#000;
      pointer-events: none;
      background-color: #17a2b8;
      border-color: #17a2b8;
    }

    .page-item.active .page-link{
      z-index: 2;
      color: #007bff;
      background-color: #fff;
      border-color: #17a2b8;
    }

    .page-link{
      background-color: #17a2b8;
      color: #fff;
      border: 1px solid #17a2b8;
    }

    #top{
      padding-top: 3rem;
    }

    .space{
      margin-bottom: 1rem;
    }
  </style>
  <body id="body">
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
      <div class="container">
        <a class="navbar-brand js-scroll-trigger" href="<?php echo base_url()?>">Fakultas Teknik</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="<?php echo base_url();?>">Menu Utama</a>
            </li>
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="<?php echo base_url('front/jadwal_tata_usaha');?>">Jadwal Tata Usaha</a>
            </li>
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="<?php echo base_url('front/bimbingan_dosen');?>">Jadwal Bimbingan Dosen</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <section class="container" id="top">
      <div class="container">
          <div class="space text-center">
            <h1>Jadwal Dosen Fakultas Teknik</h1>
            <h3>Universitas 17 Agustus 1945 Surabaya</h3>
          </div>
          <div class="text-clear">
            <div class="form-row">
              <div class="form-group col-md-3">
                <label>Program Studi</label>
                <select class="form-control custom-select" id="prodi">
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
              <div class="form-group col-md-3">
                <label>Kode Mata Kuliah</label>
                <select class="form-control custom-select" id="mk">
                  <option value="mk">-- Kode Mata Kuliah --</option>
                </select>
              </div>
              <div class="form-group col-md-3">
                <label>Nama Dosen</label>
                <select class="form-control custom-select" id="dosen">
                  <option value="d">-- Pilih Dosen --</option>
                </select>
              </div>
              <div class="form-group col-md-3">
                <label>&nbsp;</label>
                <div>
                  <button type="button" id="btn-filter" class="btn btn-primary">Filter</button>
                  <button type="button" id="btn-reset" class="btn btn-outline-primary">Reset</button>  
                </div>
              </div>
            </div>
          </div>
          <h1 class="text-center" id="prodihasil"></h1>
          <div class="row">
            <table id="table" class="table table-striped" cellspacing="0" width="100%">
              <thead class="tbl">
                <tr>
                  <th>No</th>
                  <th>Kode</th>
                  <th>Nama MatKul</th>
                  <th>Kelas</th>
                  <th>SKS</th>
                  <th>Semester</th>
                  <th>Jadwal</th>
                  <th>Pengajar</th>
                  <th>Ruang</th>
                  <th>Peserta</th>
                </tr>
              </thead>
              <tbody style="font-size: 12px">
              </tbody>
            </table>
          </div> 
      </div>
    </section>
    <footer class="footer text-center">
      <div class="container">
        <p class="text-muted small mb-0">Copyright &copy; Fakultas Teknik 2017</p>
      </div>
    </footer>

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded js-scroll-trigger" href="#top">
      <i class="fa fa-angle-up"></i>
    </a>
    <?php $this->load->view('Partials/Front/Foot');?>
  </body>
  <script type="text/javascript">
    var table;
    $(document).ready(function() {
      
      var prodi = $("#prodi option:selected").val();
      var mk = $("#mk option:selected").val();
      var dosen = $("#dosen option:selected").text();
      if(dosen === '-- Pilih Dosen --'){
        dosen = '0';
      }else{
        dosen = $("#dosen option:selected").text();
      }
      table = $('#table').DataTable({
        language:{
          emptyTable: "Data Kosong",
          processing: "Sedang Mencari",
          lengthMenu: "Menampilkan _MENU_ data",
          zeroRecords: "Data Kosong",
          info: "Halaman _PAGE_ dari _PAGES_ halaman",
          infoEmpty: "Data Kosong",
          infoFiltered: "(Disaring dari _MAX_ total data)",
          paginate: {
              "next":       "Berikutnya",
              "previous":   "Sebelumnya"
          },
        },
        scrollY: "325px",
        scrollCollapse: true,
        searching:false,
        stripeClasses: ['table-active','table-default'],
        processing: true,
        serverSide: true,
        order: [],
        ajax: {
            url: '<?php echo site_url('Front/list_jadwal')?>',
            type: 'POST',
            data: {'prodi':prodi,'dosen':dosen,'mk':mk,'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'}
        },
        columnDefs: [
            { 
                targets: [ 0 ],
                orderable: false, 
            },
        ],
      });

      $("#prodi").on('change',function(event) {
        event.preventDefault();
        var prodi = $("#prodi option:selected").val();
        var mk = $("#mk option:selected").val();
        var dosen = $("#dosen option:selected").text();
        if(dosen === '-- Pilih Dosen --'){
          dosen = 'd';
        }else{
          dosen = $("#dosen option:selected").text();
        }
        if(prodi === 'pd'){
          $("#prodihasil").text(''); 
        }else{
          $("#prodihasil").text($("#prodi option:selected").text());  
        }
        var data = {'prodi' : prodi, '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'}
        $.ajax({
          url: '<?php echo site_url('Front/getKuliah');?>',
          type: 'POST',
          dataType: 'JSON',
          data: data,
          success: function (data){
              var namaMk = $("#mk");
              var namaDosen = $("#dosen");
              namaDosen.empty();
              namaMk.empty();
              if(data.mk == 0 ){
                  namaMk.append('<option value="mk">-- Kode Mata Kuliah --</option>');
              }else{
                  namaMk.append('<option value="mk" selected>-- Kode Mata Kuliah --</option>');
                  for(var i = 0; i< data.mk.length; i++){
                    namaMk.append('<option value='+data.mk[i].kode_mk+'>'+data.mk[i].nama_mk+'</option>');
                  }
              }

              if(data.dosen == 0 ){
                  namaDosen.append('<option value="d">-- Pilih Dosen --</option>');
              }else{
                  namaDosen.append('<option value="d" selected>-- Pilih Dosen --</option>');
                  for(var i = 0; i< data.dosen.length; i++){
                    namaDosen.append('<option value='+data.dosen[i].pengajar+'>'+data.dosen[i].pengajar+'</option>');
                  }
              }
              mk = $("#mk option:selected").val();
              dosen = $("#dosen option:selected").text();
              if(dosen === '-- Pilih Dosen --'){
                dosen = 'd';
              }else{
                dosen = $("#dosen option:selected").text();
              }
              var data = {'prodi':prodi,'dosen':dosen,'mk':mk,'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'}
              table.destroy();
              table = $('#table').DataTable({
                language:{
                  emptyTable: "Data Kosong",
                  processing: "Sedang Mencari",
                  lengthMenu: "Menampilkan _MENU_ data",
                  zeroRecords: "Data Kosong",
                  info: "Halaman _PAGE_ dari _PAGES_ halaman",
                  infoEmpty: "Data Kosong",
                  infoFiltered: "(Disaring dari _MAX_ total data)",
                  paginate: {
                      "next":       "Berikutnya",
                      "previous":   "Sebelumnya"
                  },
                },
                scrollY: "325px",
                scrollCollapse: true,
                stripeClasses: ['table-active','table-default'],
                searching : false,
                processing: true,
                serverSide: true,
                order: [],
                ajax: {
                    url: '<?php echo site_url('Front/list_jadwal')?>',
                    type: 'POST',
                    data: data
                },
                columnDefs: [
                    { 
                        targets: [ 0 ],
                        orderable: false, 
                    },
                ],
              });
          },
          error:function(jqXHR, textStatus, errorThrown) {
              alert('error ajax');
          }
        });
      });

      $("#mk").on('change',function(event) {
        event.preventDefault();
        var prodi = $("#prodi option:selected").val();
        var mk = $("#mk option:selected").val();
        var dosen = $("#dosen option:selected").text();
        if(dosen === '-- Pilih Dosen --'){
          dosen = 'd';
        }else{
          dosen = $("#dosen option:selected").text();
        }
        var data = {'prodi':prodi,'dosen':dosen,'mk':mk,'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'}
        table.destroy();
        table = $('#table').DataTable({
          language:{
            emptyTable: "Data Kosong",
            processing: "Sedang Mencari",
            lengthMenu: "Menampilkan _MENU_ data",
            zeroRecords: "Data Kosong",
            info: "Halaman _PAGE_ dari _PAGES_ halaman",
            infoEmpty: "Data Kosong",
            infoFiltered: "(Disaring dari _MAX_ total data)",
            paginate: {
                "next":       "Berikutnya",
                "previous":   "Sebelumnya"
            },
          },
          scrollY: "325px",
          scrollCollapse: true,
          stripeClasses: ['table-active','table-default'],
          searching : false,
          processing: true,
          serverSide: true,
          order: [],
          ajax: {
              url: '<?php echo site_url('Front/list_jadwal')?>',
              type: 'POST',
              data: data
          },
          columnDefs: [
              { 
                  targets: [ 0 ],
                  orderable: false, 
              },
          ],
        });
      });

      $("#dosen").on('change',function(event) {
        event.preventDefault();
        var prodi = $("#prodi option:selected").val();
        var mk = $("#mk option:selected").val();
        var dosen = $("#dosen option:selected").text();
        if(dosen === '-- Pilih Dosen --'){
          dosen = 'd';
        }else{
          dosen = $("#dosen option:selected").text();
        }
        var data = {'prodi':prodi,'dosen':dosen,'mk':mk,'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'}
        table.destroy();
        table = $('#table').DataTable({
          language:{
            emptyTable: "Data Kosong",
            processing: "Sedang Mencari",
            lengthMenu: "Menampilkan _MENU_ data",
            zeroRecords: "Data Kosong",
            info: "Halaman _PAGE_ dari _PAGES_ halaman",
            infoEmpty: "Data Kosong",
            infoFiltered: "(Disaring dari _MAX_ total data)",
            paginate: {
                "next":       "Berikutnya",
                "previous":   "Sebelumnya"
            },
          },
          scrollY: "325px",
          scrollCollapse: true,
          stripeClasses: ['table-active','table-default'],
          searching : false,
          processing: true,
          serverSide: true,
          order: [],
          ajax: {
              url: '<?php echo site_url('Front/list_jadwal')?>',
              type: 'POST',
              data: data
          },
          columnDefs: [
              { 
                  targets: [ 0 ],
                  orderable: false, 
              },
          ],
        });
      });

      $("#btn-filter").on('click',function(event) {
        event.preventDefault();
        table.ajax.reload();
      });

      $("#btn-reset").on('click',function(event) {
        event.preventDefault();
        $('#dosen option').prop('selected', function() {
          return this.defaultSelected;
        });

        $('#mk option').prop('selected', function() {
          return this.defaultSelected;
        });

        $('#prodi option').prop('selected', function() {
          return this.defaultSelected;
        });

        $('#prodihasil').text('');

        $("#btn-filter").trigger('click');
        var prodi = $("#prodi option:selected").val();
        var mk = $("#mk option:selected").val();
        var dosen = $("#dosen option:selected").text();
        if(dosen === '-- Pilih Dosen --'){
          dosen = 'd';
        }else{
          dosen = $("#dosen option:selected").text();
        }
        var data = {'prodi':prodi,'dosen':dosen,'mk':mk,'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'}
        table.destroy();
        table = $('#table').DataTable({
          language:{
            emptyTable: "Data Kosong",
            processing: "Sedang Mencari",
            lengthMenu: "Menampilkan _MENU_ data",
            zeroRecords: "Data Kosong",
            info: "Halaman _PAGE_ dari _PAGES_ halaman",
            infoEmpty: "Data Kosong",
            infoFiltered: "(Disaring dari _MAX_ total data)",
            paginate: {
                "next":       "Berikutnya",
                "previous":   "Sebelumnya"
            },
          },
          scrollY: "325px",
          scrollCollapse: true,
          stripeClasses: ['table-active','table-default'],
          searching : false,
          processing: true,
          serverSide: true,
          order: [],
          ajax: {
              url: '<?php echo site_url('Front/list_jadwal')?>',
              type: 'POST',
              data: data
          },
          columnDefs: [
              { 
                  targets: [ 0 ],
                  orderable: false, 
              },
          ],
        });
      });
    });
  </script>
</html>
