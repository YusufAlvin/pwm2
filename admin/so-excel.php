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


if($nopo == "" && $itemid != "" && $tanggalawal == "" && $tanggalakhir == ""){
  $queryitem = mysqli_query($conn, "SELECT * FROM so JOIN bom ON bom.bom_id = so.so_bom_id JOIN item ON item.item_id = bom.bom_item_id JOIN divisi ON divisi.divisi_id = bom.bom_divisi_id JOIN material ON material.material_id = bom.bom_material_id JOIN uom ON uom.uom_id = material.material_uom_id WHERE item.item_id = '$itemid'");

  if(mysqli_num_rows($queryitem) < 1){
    header('Location: export-so-excel.php?pesan=datakosong');
    exit();
  }
} 
elseif($nopo == "" && $itemid == "" && $tanggalawal != "" && $tanggalakhir != "") {
  $queryitem = mysqli_query($conn, "SELECT * FROM so JOIN bom ON bom.bom_id = so.so_bom_id JOIN item ON item.item_id = bom.bom_item_id JOIN divisi ON divisi.divisi_id = bom.bom_divisi_id JOIN material ON material.material_id = bom.bom_material_id JOIN uom ON uom.uom_id = material.material_uom_id WHERE so.so_tanggal BETWEEN '$tanggalawal' AND '$tanggalakhir'");

  if(mysqli_num_rows($queryitem) < 1){
    header('Location: export-so-excel.php?pesan=datakosong');
    exit();
  }
} 
elseif ($nopo == "" && $itemid != "" && $tanggalawal != "" && $tanggalakhir != ""){
  $queryitem = mysqli_query($conn, "SELECT * FROM so JOIN bom ON bom.bom_id = so.so_bom_id JOIN item ON item.item_id = bom.bom_item_id JOIN divisi ON divisi.divisi_id = bom.bom_divisi_id JOIN material ON material.material_id = bom.bom_material_id JOIN uom ON uom.uom_id = material.material_uom_id WHERE (so.so_tanggal BETWEEN '$tanggalawal' AND '$tanggalakhir') AND bom.bom_item_id = '$itemid'");

  if(mysqli_num_rows($queryitem) < 1){
    header('Location: export-so-excel.php?pesan=datakosong');
    exit();
  }
}
elseif ($nopo == "" && $itemid == "" && $tanggalawal != "" && $tanggalakhir == ""){
  $queryitem = mysqli_query($conn, "SELECT * FROM so JOIN bom ON bom.bom_id = so.so_bom_id JOIN item ON item.item_id = bom.bom_item_id JOIN divisi ON divisi.divisi_id = bom.bom_divisi_id JOIN material ON material.material_id = bom.bom_material_id JOIN uom ON uom.uom_id = material.material_uom_id WHERE so.so_tanggal = '$tanggalawal'");

  if(mysqli_num_rows($queryitem) < 1){
    header('Location: export-so-excel.php?pesan=datakosong');
    exit();
  }
}
elseif ($nopo != "" && $itemid == "" && $tanggalawal == "" && $tanggalakhir == ""){
  $queryitem = mysqli_query($conn, "SELECT * FROM so JOIN bom ON bom.bom_id = so.so_bom_id JOIN item ON item.item_id = bom.bom_item_id JOIN divisi ON divisi.divisi_id = bom.bom_divisi_id JOIN material ON material.material_id = bom.bom_material_id JOIN uom ON uom.uom_id = material.material_uom_id WHERE so.so_no_po = '$nopo'");

  if(mysqli_num_rows($queryitem) < 1){
    header('Location: export-so-excel.php?pesan=datakosong');
    exit();
  }
}
elseif ($nopo != "" && $itemid != "" && $tanggalawal == "" && $tanggalakhir == ""){
  $queryitem = mysqli_query($conn, "SELECT * FROM so JOIN bom ON bom.bom_id = so.so_bom_id JOIN item ON item.item_id = bom.bom_item_id JOIN divisi ON divisi.divisi_id = bom.bom_divisi_id JOIN material ON material.material_id = bom.bom_material_id JOIN uom ON uom.uom_id = material.material_uom_id WHERE so.so_no_po = '$nopo' AND item.item_id = '$itemid'");

  if(mysqli_num_rows($queryitem) < 1){
    header('Location: export-so-excel.php?pesan=datakosong');
    exit();
  }
}
elseif ($nopo != "" && $itemid != "" && $tanggalawal != "" && $tanggalakhir != ""){
  $queryitem = mysqli_query($conn, "SELECT * FROM so JOIN bom ON bom.bom_id = so.so_bom_id JOIN item ON item.item_id = bom.bom_item_id JOIN divisi ON divisi.divisi_id = bom.bom_divisi_id JOIN material ON material.material_id = bom.bom_material_id JOIN uom ON uom.uom_id = material.material_uom_id WHERE so.so_no_po = '$nopo' AND (so.so_tanggal BETWEEN '$tanggalawal' AND '$tanggalakhir')");

  if(mysqli_num_rows($queryitem) < 1){
    header('Location: export-so-excel.php?pesan=datakosong');
    exit();
  }
}
elseif ($nopo != "" && $itemid == "" && $tanggalawal != "" && $tanggalakhir != ""){
  $queryitem = mysqli_query($conn, "SELECT * FROM so JOIN bom ON bom.bom_id = so.so_bom_id JOIN item ON item.item_id = bom.bom_item_id JOIN divisi ON divisi.divisi_id = bom.bom_divisi_id JOIN material ON material.material_id = bom.bom_material_id JOIN uom ON uom.uom_id = material.material_uom_id WHERE so.so_no_po = '$nopo' AND item.item_id = '$itemid' AND (so.so_tanggal BETWEEN '$tanggalawal' AND '$tanggalakhir')");

  if(mysqli_num_rows($queryitem) < 1){
    header('Location: export-so-excel.php?pesan=datakosong');
    exit();
  }
} 
elseif ($nopo == "" && $itemid == "" && $tanggalawal == "" && $tanggalakhir == ""){
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
  $active_sheet->setCellValue('I1', 'UoM');
  $active_sheet->setCellValue('J1', 'Harga'); 
  $active_sheet->setCellValue('K1', 'Divisi');
  $active_sheet->setCellValue('L1', 'BOM');
  $active_sheet->setCellValue('M1', 'Hasil BOM');
  $active_sheet->setCellValue('N1', 'Aktual');
  $active_sheet->setCellValue('O1', 'Hasil Aktual');
  $active_sheet->setCellValue('P1', 'Balance');
  $active_sheet->setCellValue('Q1', 'Hasil Balance');

  while($item = mysqli_fetch_assoc($queryitem)){
    $bom = $item['bom_quantity'] * $item['so_qty_order'];
    $hasilbom  = $bom * $item['material_harga'];
    $aktual = $item['so_realisasi'] + $item['so_ba'];
    $hasilaktual = $aktual * $item['material_harga'];
    $balance = $bom - $aktual;
    $hasilbalance = $balance * $item['material_harga'];

    $active_sheet->setCellValue('A'.$count, $no++);
    $active_sheet->setCellValue('B'.$count, $item['so_no_po']);
    $active_sheet->setCellValue('C'.$count, $item['item_id']);
    $active_sheet->setCellValue('D'.$count, $item['so_lot_number']);
    $active_sheet->setCellValue('E'.$count, $item['so_qty_order']);
    $active_sheet->setCellValue('F'.$count, $item['item_nama']);
    $active_sheet->setCellValue('G'.$count, $item['material_id']);
    $active_sheet->setCellValue('H'.$count, $item['material_nama']);
    $active_sheet->setCellValue('I'.$count, $item['uom_nama']);
    $active_sheet->setCellValue('J'.$count, $item['material_harga']); 
    $active_sheet->setCellValue('K'.$count, $item['divisi_nama']);
    $active_sheet->setCellValue('L'.$count, $bom);
    $active_sheet->setCellValue('M'.$count, $hasilbom);
    $active_sheet->setCellValue('N'.$count, $aktual);
    $active_sheet->setCellValue('O'.$count, $hasilaktual);
    $active_sheet->setCellValue('P'.$count, $balance);
    $active_sheet->setCellValue('Q'.$count, $hasilbalance);

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