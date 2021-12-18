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

extract($_GET);

$spreadsheet = new Spreadsheet();
$active_sheet = $spreadsheet->getActiveSheet();
$count = 2;
$no = 1;
// $jmlqtyorder = 0;


if($itemid != "" && $tanggalawal == "" && $tanggalakhir == ""){
  $queryitem = mysqli_query($conn, "SELECT * FROM so JOIN bom ON bom.bom_id = so.so_bom_id JOIN item ON item.item_id = bom.bom_item_id JOIN divisi ON divisi.divisi_id = bom.bom_divisi_id JOIN material ON material.material_id = bom.bom_material_id JOIN uom ON uom.uom_id = material.material_uom_id WHERE item.item_id = '$itemid'");

  if(mysqli_num_rows($queryitem) < 1){
    header('Location: export-so-excel.php?pesan=datakosong');
    exit();
  }
} 
elseif($itemid == "" && $tanggalawal != "" && $tanggalakhir != "") {
  $queryitem = mysqli_query($conn, "SELECT * FROM so JOIN bom ON bom.bom_id = so.so_bom_id JOIN item ON item.item_id = bom.bom_item_id JOIN divisi ON divisi.divisi_id = bom.bom_divisi_id JOIN material ON material.material_id = bom.bom_material_id JOIN uom ON uom.uom_id = material.material_uom_id WHERE so.so_tanggal BETWEEN '$tanggalawal' AND '$tanggalakhir'");

  if(mysqli_num_rows($queryitem) < 1){
    header('Location: export-so-excel.php?pesan=datakosong');
    exit();
  }
} 
elseif ($itemid != "" && $tanggalawal != "" && $tanggalakhir != ""){
  $queryitem = mysqli_query($conn, "SELECT * FROM so JOIN bom ON bom.bom_id = so.so_bom_id JOIN item ON item.item_id = bom.bom_item_id JOIN divisi ON divisi.divisi_id = bom.bom_divisi_id JOIN material ON material.material_id = bom.bom_material_id JOIN uom ON uom.uom_id = material.material_uom_id WHERE (so.so_tanggal BETWEEN '$tanggalawal' AND '$tanggalakhir') AND bom.bom_item_id = '$itemid'");

  if(mysqli_num_rows($queryitem) < 1){
    header('Location: export-so-excel.php?pesan=datakosong');
    exit();
  }
}
elseif ($itemid == "" && $tanggalawal != "" && $tanggalakhir == ""){
  $queryitem = mysqli_query($conn, "SELECT * FROM so JOIN bom ON bom.bom_id = so.so_bom_id JOIN item ON item.item_id = bom.bom_item_id JOIN divisi ON divisi.divisi_id = bom.bom_divisi_id JOIN material ON material.material_id = bom.bom_material_id JOIN uom ON uom.uom_id = material.material_uom_id WHERE so.so_tanggal = '$tanggalawal'");

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

$active_sheet = $spreadsheet->getActiveSheet();

  $active_sheet->setCellValue('A1', 'No');
  $active_sheet->setCellValue('B1', 'No PO');
  $active_sheet->setCellValue('C1', 'Item Id');
  $active_sheet->setCellValue('D1', 'Lot Number');
  $active_sheet->setCellValue('E1', 'Quantity Order');
  $active_sheet->setCellValue('F1', 'Item Nama');
  $active_sheet->setCellValue('G1', 'Material Code');
  $active_sheet->setCellValue('H1', 'Material Nama');
  $active_sheet->setCellValue('I1', 'Material Harga');
  $active_sheet->setCellValue('J1', 'UoM');
  $active_sheet->setCellValue('K1', 'Material Quantity');  
  $active_sheet->setCellValue('L1', 'Divisi');
  $active_sheet->setCellValue('M1', 'Total Kebutuhan');
  $active_sheet->setCellValue('N1', 'Realisasi');
  $active_sheet->setCellValue('O1', 'BA');
  $active_sheet->setCellValue('P1', 'Tanggal');
  $active_sheet->setCellValue('Q1', 'Total Harga');

  while($item = mysqli_fetch_assoc($queryitem)){
    $totalkebuthan = floatval($item['bom_quantity'] * $item['so_qty_order']);
    $totalharga  = number_format($item['so_realisasi'] * $item['material_harga'], 0, ".", ".");

    $active_sheet->setCellValue('A'.$count, $no++);
    $active_sheet->setCellValue('B'.$count, $item['so_no_po']);
    $active_sheet->setCellValue('C'.$count, $item['item_id']);
    $active_sheet->setCellValue('D'.$count, $item['so_lot_number']);
    $active_sheet->setCellValue('E'.$count, $item['so_qty_order']);
    $active_sheet->setCellValue('F'.$count, $item['item_nama']);
    $active_sheet->setCellValue('G'.$count, $item['material_id']);
    $active_sheet->setCellValue('H'.$count, $item['material_nama']);
    $active_sheet->setCellValue('I'.$count, $item['material_harga']);
    $active_sheet->setCellValue('J'.$count, $item['uom_nama']);  
    $active_sheet->setCellValue('K'.$count, $item['bom_quantity']);
    $active_sheet->setCellValue('L'.$count, $item['divisi_nama']);
    $active_sheet->setCellValue('M'.$count, $totalkebuthan);
    $active_sheet->setCellValue('N'.$count, $item['so_realisasi']);
    $active_sheet->setCellValue('O'.$count, $item['so_ba']);
    $active_sheet->setCellValue('P'.$count, $item['so_tanggal']);
    $active_sheet->setCellValue('Q'.$count, $totalharga);


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