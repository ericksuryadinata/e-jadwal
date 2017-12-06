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
    <title>Jadwal Tata Usaha | Fakultas Teknik</title>
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

  </style>
  <body id="body">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
      <div class="container">
        <a class="navbar-brand js-scroll-trigger" href="<?php echo base_url()?>">Fakultas Teknik</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="<?php echo base_url('front/jadwal_dosen');?>">Jadwal Dosen</a>
            </li>
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="<?php echo base_url('front/bimbingan_dosen');?>">Jadwal Bimbingan Dosen</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <!-- Header -->
    <section class="container" id="top">
      <div class="container">
        <div class="text-center space">
          <h1>Jadwal Tata Usaha Fakultas Teknik</h1>
          <h3>Universitas 17 Agustus 1945 Surabaya</h3>
          <div class="row">
            <table id="table" class="table table-striped" cellspacing="0" width="100%">
              <thead class="tbl">
                <tr>
                  <th>No</th>
                  <th>Fakultas - Prodi</th>
                  <th>Kode Tata Usaha</th>
                  <th>Nama Petugas</th>
                  <th>Jadwal</th>
                </tr>
              </thead>
              <tbody style="font-size: 12px;">
              </tbody>
            </table>
          </div>
        </div>  
      </div>
    </section>
    <!-- Footer -->
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
  <script>
  shortcut.add("Alt+F1",function() {
    location.replace("<?php echo site_url('MP_Back')?>");
  });
  shortcut.add("Alt+F2",function() {
    location.replace("<?php echo site_url('Front')?>");
  });
  </script>
  <script type="text/javascript">
    var table;
    $(document).ready(function() {
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
        iDisplayLength : '50',
        stripeClasses: ['table-active','table-default'],
        lengthChange : false,
        searching : false,
        processing: true,
        serverSide: true,
        order: [],
        ajax: {
            url: '<?php echo site_url('Front/list_jadwal_tu')?>',
            type: 'POST',
            data: {'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'}
        },
        columnDefs: [
            { 
                targets: [ 0 ],
                orderable: false, 
            },
        ],
      });
    });
  </script>
</html>
