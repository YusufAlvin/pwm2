<?php 
session_start();

require_once "../koneksi.php";
require_once "../vendor/autoload.php";
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

if($_SESSION['login'] != true){
  header('Location: ../');
  exit();
}

$itemid = $_GET['itemid'];
$tanggalawal = $_GET['tanggalawal'];
$tanggalakhir = $_GET['tanggalakhir'];

$spreadsheet = new Spreadsheet();
$active_sheet = $spreadsheet->getActiveSheet();
$count = 2;
$no = 1;
// $jmlqtyorder = 0;


if($itemid != "" && $tanggalawal == "" && $tanggalakhir == ""){
  $queryitem = mysqli_query($conn, "SELECT * FROM realisasi JOIN item ON item.item_id = realisasi.so_item_id JOIN material ON material.material_id = realisasi.so_material_id JOIN divisi ON divisi.divisi_id = realisasi.so_divisi_id WHERE realisasi.so_item_id = '$itemid'");

  if(mysqli_num_rows($queryitem) < 1){
    header('Location: export-so-excel.php?pesan=datakosong');
    exit();
  }
} 
elseif($itemid == "" && $tanggalawal != "" && $tanggalakhir != "") {
  $queryitem = mysqli_query($conn, "SELECT * FROM realisasi JOIN item ON item.item_id = realisasi.so_item_id JOIN material ON material.material_id = realisasi.so_material_id JOIN divisi ON divisi.divisi_id = realisasi.so_divisi_id WHERE realisasi.so_tanggal BETWEEN '$tanggalawal' AND '$tanggalakhir'");

  if(mysqli_num_rows($queryitem) < 1){
    header('Location: export-so-excel.php?pesan=datakosong');
    exit();
  }
} 
elseif ($itemid != "" && $tanggalawal != "" && $tanggalakhir != ""){
  $queryitem = mysqli_query($conn, "SELECT * FROM realisasi JOIN item ON item.item_id = realisasi.so_item_id JOIN material ON material.material_id = realisasi.so_material_id JOIN divisi ON divisi.divisi_id = realisasi.so_divisi_id WHERE (realisasi.so_tanggal BETWEEN '$tanggalawal' AND '$tanggalakhir') AND realisasi.so_item_id = '$itemid'");

  if(mysqli_num_rows($queryitem) < 1){
    header('Location: export-so-excel.php?pesan=datakosong');
    exit();
  }
}
elseif ($itemid == "" && $tanggalawal != "" && $tanggalakhir == ""){
  $queryitem = mysqli_query($conn, "SELECT * FROM realisasi JOIN item ON item.item_id = realisasi.so_item_id JOIN material ON material.material_id = realisasi.so_material_id JOIN divisi ON divisi.divisi_id = realisasi.so_divisi_id WHERE realisasi.so_tanggal = '$tanggalawal'");

  if(mysqli_num_rows($queryitem) < 1){
    header('Location: export-so-excel.php?pesan=datakosong');
    exit();
  }
} 
elseif ($itemid == "" && $tanggalawal == "" && $tanggalakhir == ""){
  header('Location: export-so-excel.php?pesan=fieldkosong');
  exit();
}
elseif ($tanggalakhir != "" && $tanggalawal == ""){
  header('Location: export-so-excel.php?pesan=tanggalakhirkosong');
  exit();
}

while($item = mysqli_fetch_assoc($queryitem)){
  $jmlqtyorder += $item['so_qty_order'];
}

$active_sheet = $spreadsheet->getActiveSheet();

  $active_sheet->setCellValue('A1', 'No');
  $active_sheet->setCellValue('B1', 'No PO');
  $active_sheet->setCellValue('C1', 'Item Id');
  $active_sheet->setCellValue('D1', 'Lot Number');
  $active_sheet->setCellValue('E1', 'Quantity Order');
  $active_sheet->setCellValue('F1', 'Item Nama');
  $active_sheet->setCellValue('G1', 'Material Code');
  $active_sheet->setCellValue('H1', 'Material Nama');
  $active_sheet->setCellValue('I1', 'UoM');
  $active_sheet->setCellValue('J1', 'Material Quantity');  
  $active_sheet->setCellValue('K1', 'Divisi');
  $active_sheet->setCellValue('L1', 'Total Kebutuhan');
  $active_sheet->setCellValue('M1', 'Realisasi');
  $active_sheet->setCellValue('N1', 'Tanggal');

  while($item = mysqli_fetch_assoc($queryitem)){
    $active_sheet->setCellValue('A'.$count, $no++);
    $active_sheet->setCellValue('B'.$count, $item['so_no_spk']);
    $active_sheet->setCellValue('C'.$count, $item['item_id']);
    $active_sheet->setCellValue('D'.$count, $item['so_lot_number']);
    $active_sheet->setCellValue('E'.$count, $item['so_qty_order']);
    $active_sheet->setCellValue('F'.$count, $item['item_nama']);
    $active_sheet->setCellValue('G'.$count, $item['material_id']);
    $active_sheet->setCellValue('H'.$count, $item['material_nama']);
    $active_sheet->setCellValue('I'.$count, $item['material_uom']);  
    $active_sheet->setCellValue('J'.$count, $item['so_material_qty']);
    $active_sheet->setCellValue('K'.$count, $item['divisi_nama']);
    $active_sheet->setCellValue('L'.$count, $item['so_total_kebutuhan']);
    $active_sheet->setCellValue('M'.$count, $item['so_realisasi']);
    $active_sheet->setCellValue('N'.$count, $item['so_tanggal']);

    $count++;
  }

  $writer = new Xlsx($spreadsheet);  

  $writer->save('CV Premiere Wood Manufactur.xlsx');

  header('Content-Type: application/x-www-form-urlencoded');
  header('Content-Transfer-Encoding: Binary');
  header("Content-disposition: attachment; filename=CV Premiere Wood Manufactur.xlsx");

  readfile('CV Premiere Wood Manufactur.xlsx');
  unlink('CV Premiere Wood Manufactur.xlsx');
  exit();