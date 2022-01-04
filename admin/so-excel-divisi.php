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

if($divisi == ""){
  header('Location: export-so-excel2.php');
  exit();
}

$table = "CREATE TABLE IF NOT EXISTS temp (
  id int(11) NOT NULL AUTO_INCREMENT,
  so_id int(11) DEFAULT NULL,
  so_no_po varchar(255) DEFAULT NULL,
  so_bom_id int(11) DEFAULT NULL,
  so_qty_order float DEFAULT NULL,
  so_lot_number varchar(255) DEFAULT NULL,
  so_realisasi float DEFAULT NULL,
  so_ba float DEFAULT NULL,
  so_tanggal date DEFAULT NULL,
  bom_id int(11) DEFAULT NULL,
  bom_item_id varchar(255) DEFAULT NULL,
  bom_material_id varchar(255) DEFAULT NULL,
  bom_quantity float DEFAULT NULL,
  bom_divisi_id int(11) DEFAULT NULL,
  item_id varchar(255) DEFAULT NULL,
  item_nama varchar(255) DEFAULT NULL,
  item_panjang float DEFAULT NULL,
  item_lebar float DEFAULT NULL,
  item_tebal float DEFAULT NULL,
  item_kubikasi float DEFAULT NULL,
  item_uom_id int(11) DEFAULT NULL,
  divisi_id int(11) DEFAULT NULL,
  divisi_nama varchar(255) DEFAULT NULL,
  material_id varchar(255) DEFAULT NULL,
  material_nama varchar(255) DEFAULT NULL,
  material_harga float DEFAULT NULL,
  material_uom_id int(11) DEFAULT NULL,
  uom_id int(11) DEFAULT NULL,
  uom_nama varchar(255) DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";


mysqli_query($conn, $table);

for ($i=0; $i < count($divisi); $i++) {
  $queryitem = mysqli_query($conn, "SELECT * FROM so JOIN bom ON bom.bom_id = so.so_bom_id JOIN item ON item.item_id = bom.bom_item_id JOIN divisi ON divisi.divisi_id = bom.bom_divisi_id JOIN material ON material.material_id = bom.bom_material_id JOIN uom ON uom.uom_id = material.material_uom_id WHERE divisi.divisi_id = $divisi[$i]");

  if(mysqli_num_rows($queryitem) < 1){
    header('Location: export-so-excel2.php?datakosong');
    exit();
  }

  while($item = mysqli_fetch_assoc($queryitem)){
    mysqli_query($conn, "INSERT INTO temp (id, so_id, so_no_po, so_bom_id, so_qty_order, so_lot_number, so_realisasi, so_ba, so_tanggal, bom_id, bom_item_id, bom_material_id, bom_quantity, bom_divisi_id, item_id, item_nama, item_panjang, item_lebar, item_tebal, item_kubikasi, item_uom_id, divisi_id, divisi_nama, material_id, material_nama, material_harga, material_uom_id, uom_id, uom_nama) VALUES ('', $item[so_id], '$item[so_no_po]', $item[so_bom_id], $item[so_qty_order], '$item[so_lot_number]', $item[so_realisasi], $item[so_ba], '$item[so_tanggal]', $item[bom_id], '$item[bom_item_id]', '$item[bom_material_id]', $item[bom_quantity], $item[bom_divisi_id], '$item[item_id]', '$item[item_nama]', $item[item_panjang], $item[item_lebar], $item[item_tebal], $item[item_kubikasi], $item[item_uom_id], $item[divisi_id], '$item[divisi_nama]', '$item[material_id]', '$item[material_nama]', $item[material_harga], $item[material_uom_id], $item[uom_id], '$item[uom_nama]')");
  }
}

$query = mysqli_query($conn, "SELECT * FROM temp");

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

  while($data = mysqli_fetch_assoc($query)){
    $bom = $data['bom_quantity'] * $data['so_qty_order'];
    $hasilbom  = $bom * $data['material_harga'];
    $aktual = $data['so_realisasi'] + $data['so_ba'];
    $hasilaktual = $aktual * $data['material_harga'];
    $balance = $bom - $aktual;
    $hasilbalance = $balance * $data['material_harga'];

    $active_sheet->setCellValue('A'.$count, $no++);
    $active_sheet->setCellValue('B'.$count, $data['so_no_po']);
    $active_sheet->setCellValue('C'.$count, $data['item_id']);
    $active_sheet->setCellValue('D'.$count, $data['so_lot_number']);
    $active_sheet->setCellValue('E'.$count, $data['so_qty_order']);
    $active_sheet->setCellValue('F'.$count, $data['item_nama']);
    $active_sheet->setCellValue('G'.$count, $data['material_id']);
    $active_sheet->setCellValue('H'.$count, $data['material_nama']);
    $active_sheet->setCellValue('I'.$count, $data['uom_nama']);
    $active_sheet->setCellValue('J'.$count, $data['material_harga']); 
    $active_sheet->setCellValue('K'.$count, $data['divisi_nama']);
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
  mysqli_query($conn, "DROP TABLE temp");
  exit();