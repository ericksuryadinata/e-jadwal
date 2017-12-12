<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="content-wrapper">
  <div class="row">
    <div class="col-xs-12">
     	<section class="content">
	        <section class="content-header">
	          <h1>Jadwal<small>Dosen</small></h1>
	          <ol class="breadcrumb">
	            <li class="active"><i class="fa fa-book"></i> Jadwal Dosen</li>
	          </ol>
	        </section>
	        <section class="content">
				<div class="row">
					<div class="col-xs-12">
						<div class="box box-default">
							<div class="box-header with-border">
								<i class="fa fa-user-plus"></i>
								<h3 class="box-title">Upload Jadwal</h3>
							</div>
							<div class="box-body">
								<p>Gunakan fitur ini untuk Upload Jadwal</p>
								<?php echo form_open_multipart('MP_Back/upload_excel_jadwal','class="form-inline"')?>
								<input name="btn" type="submit" class="btn btn-primary" value="Upload Jadwal">
								<div class="form-group">
									<input class="form-control" type="file" name="file">
								</div>
								<?php echo form_close()?>
							</div>
						</div>
					</div>
					<div class="col-xs-12">
					<!-- content box -->
						<div class="box">
							<div class="box-body table-responsive">
								<table id="dt-1" class="table table-bordered table-striped ">
									<thead>
										<tr>
											<th>No</th>
											<th>Kode Program Studi</th>
											<th>Nama Program Studi</th>
											<th>Kode Mata Kuliah</th>
											<th>Nama Mata Kuliah</th>
											<th>Kelas</th>
											<th>SKS</th>
											<th>Semester</th>
											<th>Jadwal</th>
											<th>Pengajar</th>
											<th>Ruang</th>
											<th>Peserta</th>
											<th>Tahun Ajar - Semester</th>
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
<script type="text/javascript">
	var table;
	$(document).ready(function($) {
		table = $('#dt-1').DataTable({
			processing: true,
			serverSide: true,
			order: [],
			lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
			ajax: {
					url: '<?php echo site_url('MP_Back/list_jadwal')?>',
					type: 'POST',
					data: {'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'}
			},
			columnDefs: [
					{ 
							targets: [ 0, 12, -1 ],
							orderable: false, 
					},
			],

		});
	});
</script>