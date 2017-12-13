<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Fakultas Teknik | Universitas 17 Agustus 1945 Surabaya</title>
        <?php $this->load->view('Partials/Front/Head');?>
        <link href="<?php echo base_url('assets/front/css/index.css');?>" rel="stylesheet">
    </head>
    <body>
        <main role="main">
    
            <section class="jumbotron text-center">
                <div class="container">
                    <h1 class="jumbotron-heading">Universitas 17 Agustus 1945 Surabaya</h1>
                    <h1 class="jumbotron-heading">Fakultas Teknik</h1>
                </div>
            </section>
    
            <div class="album">
                <div class="container">
                    <div class="row">
                        <div class="col-md-4 col-sm-4">
                            <div class="card text-center jadwal" style="width: 20rem;" id="jadwaldosen">
                                <div class="card-body">
                                    <h4 class="card-title">Jadwal Dosen</h4>
                                    <p class="card-text">Jadwal Seluruh Dosen Fakultas Teknik Universitas 17 Agustus 1945 Surabaya</p>
                                </div>
                                <div class="card-footer">
                                    <a href="<?php echo base_url('front/jadwal_dosen')?>" class="btn btn-primary">Lihat Jadwal Dosen</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4">
                            <div class="card text-center jadwal" style="width: 20rem;" id="jadwaltu">
                                <div class="card-body">
                                    <h4 class="card-title">Jadwal Tata Usaha</h4>
                                    <p class="card-text">Jadwal Tata Usaha Fakultas Teknik Universitas 17 Agustus 1945 Surabaya</p>
                                </div>
                                <div class="card-footer">
                                    <a href="<?php echo base_url('front/jadwal_tata_usaha')?>" class="btn btn-primary">Lihat Jadwal Tata Usaha</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4">
                            <div class="card text-center jadwal" style="width: 20rem;" id="jadwalbimbingan">
                                <div class="card-body">
                                    <h4 class="card-title">Jadwal Bimbingan Dosen</h4>
                                    <p class="card-text">Jadwal Bimbingan Dosen Fakultas Teknik Universitas 17 Agustus 1945 Surabaya</p>
                                </div>
                                <div class="card-footer">
                                    <a href="<?php echo base_url('front/bimbingan_dosen')?>" class="btn     btn-primary">Lihat Jadwal Bimbingan</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-sm-4">
                            <div class="card text-center jadwal" style="width: 20rem;" id="datadosen">
                                <div class="card-body">
                                    <h4 class="card-title">Data Dosen</h4>
                                    <p class="card-text">Jadwal Data Dosen Fakultas Teknik Universitas 17 Agustus 1945 Surabaya</p>
                                </div>
                                <div class="card-footer">
                                    <a href="<?php echo base_url('front/data_dosen')?>" class="btn btn-primary">Lihat Data Dosen</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4">
                            <div class="card text-center jadwal" style="width: 20rem;" id="suratsurat">
                                <div class="card-body">
                                    <h4 class="card-title">Surat - Surat</h4>
                                    <p class="card-text">Kumpulan Surat - Surat Fakultas Teknik Universitas 17 Agustus 1945 Surabaya</p>
                                </div>
                                <div class="card-footer">
                                    <a href="#" class="btn btn-primary">Surat - Surat</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4">
                            <div class="card text-center jadwal" style="width: 20rem;" id="keluhan">
                                <div class="card-body">
                                    <h4 class="card-title">Keluhan</h4>
                                    <p class="card-text">Gunakan dengan bijak form pengaduan keluhan ini</p>
                                    
                                </div>
                                <div class="card-footer">
                                    <a href="#" class="btn btn-primary">Keluhan</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <footer class="footer text-center">
                <div class="container">
                    <p class="text-muted small mb-0">Copyright &copy; Fakultas Teknik 2017</p>
                </div>
            </footer>
        </main>
        <?php $this->load->view('Partials/Front/Foot');?>
        <script src="<?php echo base_url('assets/front/vendor/jquery.mobile/jquery.mobile-1.4.5.min.js');?>"></script>
        <script>
            var url ="http://localhost/pengumuman/pengumuman";
            var jadwaldosen = [$("#jadwaldosen"),"front/jadwal_dosen"];
            var jadwaltu = [$("#jadwaltu"),"front/jadwal_tata_usaha"];
            var jadwalbimbingan = [$("#jadwalbimbingan"),"front/bimbingan_dosen"];
            var datadosen = [$("#datadosen"),"front/data_dosen"];
            var surat = [$("#suratsurat"),"front/#"];
            var keluhan = [$("#keluhan"),"front/#"];
            var base = "<?php echo base_url()?>";
            var styles = {cursor:"pointer"};
            var content = [];
            var menu = [jadwaldosen, jadwaltu, jadwalbimbingan, datadosen, surat, keluhan];
            for(var i in menu){
                content = menu[i][0];
                content.css(styles);
            }

            $(document).idle({
                onIdle: function(){
                    location.replace(url);
                },
                idle: 5000 //5 menit, default : 60000 [1m]
            });

            $(".jadwal").on('click',function(){
                for(var i in menu){
                    if(this.id === menu[i][0][0].id){
                        location.replace(base+menu[i][1]);
                    }
                }
            });

            $(".jadwal").on('tap',function(){
                for(var i in menu){
                    if(this.id === menu[i][0][0].id){
                        location.replace(base+menu[i][1]);
                    }
                }
            });

        </script>
      </body>
    </html>
</html>