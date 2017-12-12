<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TemplateExcel{

	public function template_jadwal_dosen(){
		$objPHPExcel = new PHPExcel();
		//set Sheet yang akan diolah 
        $objPHPExcel->setActiveSheetIndex(0)
                //mengisikan value pada tiap-tiap cell, A1 itu alamat cellnya 
                //Hello merupakan isinya
                                    ->setCellValue('A1', 'kode_jurusan')
                                    ->setCellValue('B1', 'kode_mk')
                                    ->setCellValue('C1', 'nama_mk')
                                    ->setCellValue('D1', 'kelas')
                                    ->setCellValue('E1', 'sks')
                                    ->setCellValue('F1', 'semester')
                                    ->setCellValue('G1', 'jadwal')
                                    ->setCellValue('H1', 'pengajar')
                                    ->setCellValue('I1', 'ruang')
                                    ->setCellValue('J1', 'peserta')
                                    ->setCellValue('K1', 'tahun_ajaran');
        //set title pada sheet (me rename nama sheet)
        $objPHPExcel->getActiveSheet()->setTitle('siswa');

        //mulai menyimpan excel format xlsx, kalau ingin xls ganti Excel2007 menjadi Excel5          
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

        //sesuaikan headernya 
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        //ubah nama file saat diunduh
        header('Content-Disposition: attachment;filename="siswa.xlsx"');
        //unduh file
        $objWriter->save("php://output");

        //Mulai dari create object PHPExcel itu ada dokumentasi lengkapnya di PHPExcel, 
        // Folder Documentation dan Example
        // untuk belajar lebih jauh mengenai PHPExcel silakan buka disitu
	}

	public function template_jadwal_tu()
	{
		$objPHPExcel = new PHPExcel();
        //set Sheet yang akan diolah 
        $objPHPExcel->setActiveSheetIndex(0)
                //mengisikan value pada tiap-tiap cell, A1 itu alamat cellnya 
                //Hello merupakan isinya
                                    ->setCellValue('A1', 'fakjur')
                                    ->setCellValue('B1', 'kode_tata_usaha')
                                    ->setCellValue('C1', 'hari')
                                    ->setCellValue('D1', 'jam')
                                    ->setCellValue('E1', 'tahun_ajaran');
        //set title pada sheet (me rename nama sheet)
        $objPHPExcel->getActiveSheet()->setTitle('siswa');

        //mulai menyimpan excel format xlsx, kalau ingin xls ganti Excel2007 menjadi Excel5          
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

        //sesuaikan headernya 
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        //ubah nama file saat diunduh
        header('Content-Disposition: attachment;filename="divisi.xlsx"');
        //unduh file
        $objWriter->save("php://output");

        //Mulai dari create object PHPExcel itu ada dokumentasi lengkapnya di PHPExcel, 
        // Folder Documentation dan Example
        // untuk belajar lebih jauh mengenai PHPExcel silakan buka disitu
	}

	public function template_data_dosen()
	{
		$objPHPExcel = new PHPExcel();
        //set Sheet yang akan diolah 
        $objPHPExcel->setActiveSheetIndex(0)
                //mengisikan value pada tiap-tiap cell, A1 itu alamat cellnya 
                //Hello merupakan isinya
                                    ->setCellValue('A1', 'fakjur')
                                    ->setCellValue('B1', 'nip')
                                    ->setCellValue('C1', 'kode_dosen')
                                    ->setCellValue('D1', 'nama_dosen')
                                    ->setCellValue('E1', 'telepon');
        //set title pada sheet (me rename nama sheet)
        $objPHPExcel->getActiveSheet()->setTitle('siswa');

        //mulai menyimpan excel format xlsx, kalau ingin xls ganti Excel2007 menjadi Excel5          
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

        //sesuaikan headernya 
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        //ubah nama file saat diunduh
        header('Content-Disposition: attachment;filename="kelas.xlsx"');
        //unduh file
        $objWriter->save("php://output");

        //Mulai dari create object PHPExcel itu ada dokumentasi lengkapnya di PHPExcel, 
        // Folder Documentation dan Example
        // untuk belajar lebih jauh mengenai PHPExcel silakan buka disitu
	}

}

/* End of file UDLib.php */
/* Location: ./application/libraries/UDLib.php */
