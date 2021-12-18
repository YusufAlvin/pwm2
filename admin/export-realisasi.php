<?php
session_start();
require_once "../koneksi.php";
require_once '../vendor/autoload.php';

if($_SESSION['login'] != true){
	header('Location: ../');
	exit();
}

$nospk = $_GET['projects'];
$itemid = $_GET['itemid'];
$tanggalawal = $_GET['tanggalawal'];
$tanggalakhir = $_GET['tanggalakhir'];


if($nospk == "" && $itemid == "" && $tanggalawal == "" && $tanggalakhir == ""){
	header('Location: export-realisasi-filter.php?pesan=fieldkosong');
	exit();
} elseif ($nospk != "" && $itemid != "" && $tanggalawal == "" && $tanggalakhir == ""){
	$queryrealisasi = mysqli_query($conn, "SELECT * FROM realisasi JOIN item ON item.item_id = realisasi.so_item_id JOIN material ON material.material_id = realisasi.so_material_id JOIN divisi ON divisi.divisi_id = realisasi.so_divisi_id WHERE realisasi.so_no_spk = '$nospk' AND realisasi.so_item_id = '$itemid'");
	$queryrealisasi2 = mysqli_query($conn, "SELECT * FROM realisasi JOIN item ON item.item_id = realisasi.so_item_id JOIN material ON material.material_id = realisasi.so_material_id JOIN divisi ON divisi.divisi_id = realisasi.so_divisi_id WHERE realisasi.so_no_spk = '$nospk' AND realisasi.so_item_id = '$itemid'");
} elseif ($nospk != "" && $itemid != "" && $tanggalawal != "" && $tanggalakhir != ""){
	$queryrealisasi = mysqli_query($conn, "SELECT * FROM realisasi JOIN item ON item.item_id = realisasi.so_item_id JOIN material ON material.material_id = realisasi.so_material_id JOIN divisi ON divisi.divisi_id = realisasi.so_divisi_id WHERE realisasi.so_no_spk = '$nospk' AND realisasi.so_item_id = '$itemid' AND (realisasi.so_tanggal BETWEEN '$tanggalawal' AND '$tanggalakhir')");
	$queryrealisasi2 = mysqli_query($conn, "SELECT * FROM realisasi JOIN item ON item.item_id = realisasi.so_item_id JOIN material ON material.material_id = realisasi.so_material_id JOIN divisi ON divisi.divisi_id = realisasi.so_divisi_id WHERE realisasi.so_no_spk = '$nospk' AND realisasi.so_item_id = '$itemid' AND (realisasi.so_tanggal BETWEEN '$tanggalawal' AND '$tanggalakhir')");
} elseif ($nospk == "" && $itemid == "" && $tanggalawal == "" && $tanggalakhir != ""){
	header('Location: export-realisasi-filter.php?pesan=tanggalawalkosong');
	exit();
} elseif ($nospk == ""){
	header('Location: export-realisasi-filter.php?pesan=nospkkosong');
	exit();
} elseif ($itemid == ""){
	header('Location: export-realisasi-filter.php?pesan=itemidkosong');
	exit();
} elseif ($tanggalawal == "" && $tanggalakhir != ""){
	header('Location: export-realisasi-filter.php?pesan=tanggalawalkosong');
	exit();
} elseif ($tanggalawal != "" && $tanggalakhir == ""){
	header('Location: export-realisasi-filter.php?pesan=tanggalakhirkosong');
	exit();
}

if(mysqli_num_rows($queryrealisasi) < 1 && mysqli_num_rows($queryrealisasi2) < 1){
	header('Location: export-realisasi-filter.php?pesan=datakosong');
	exit();
}
$mpdf = new \Mpdf\Mpdf(['format' => [294, 500]]);
$realisasi2 = mysqli_fetch_assoc($queryrealisasi2);
ob_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<style>
		.material{
			width: 100%;
		}
		.material, .material th, .material td {
		  border: 1px solid black;
		  border-collapse: collapse;
		  padding: 5px;
		}
		.totalkebutuhan {
			width: 150px;
		}
		.item{
			width: 500px;
		}
		.menu{
			width: 120px;
		}
		.td {
			text-align: center;
			font-weight: bold;
		}
		.center{
			text-align: center;
		}
		h3 {
			text-align: center;
		}
		p {
			text-align: center;
		}
		.approval-title{
			margin-top: 30px;
			margin-bottom: 90px;
		}
		.approval{
			width: 100%;
		}
		.approval tr, .approval td{
			text-align: center;
		}
	</style>
</head>
<body>
	<h3>CV SINAR BAJA ELECTRIC CO.LTD</h3>
	<p>Jl. Raya Pilang KM.8, Wonoayu, Sidoarjo 61261, Indonesia</p>
	<h3>Bon Material</h3>
	<table class="item">
		<tr>
			<td class="menu">Item Code</td>
			<td class="semicolon">: <?php echo $realisasi2['item_id'] ?></td>
		</tr>
		<tr>
			<td class="menu">Item Name</td>
			<td class="semicolon">: <?php echo $realisasi2['item_nama'] ?></td>
		</tr>
		<tr>
			<td class="menu">LotNbr / SO</td>
			<td class="semicolon">: <?php echo $realisasi2['so_lot_number']. " / " . $realisasi2['so_no_spk'] ?></td>
		</tr>
		<tr>
			<td class="menu">Qty Order</td>
			<td class="semicolon">: <?php echo $realisasi2['so_qty_order'] ?> PCS</td>
		</tr>
	</table>
	<br>
	<table class="material">
		<tr>
			<td class="td">Code</td>
			<td class="td">Nama</td>
			<td class="td">Quantity</td>
			<td class="td">UoM</td>
			<td class="td">Divisi</td>
			<td class="td">Total Kebutuhan</td>
			<td class="td">Realisasi</td>
			<td class="td">Realisasi</td>
		</tr>
		<?php while($realisasi = mysqli_fetch_assoc($queryrealisasi)) : ?>
		<tr>
			<td><?= $realisasi['material_id']; ?></td>
			<td class="materialnama"><?= $realisasi['material_nama']; ?></td>
			<td class="center"><?= $realisasi['so_material_qty']; ?></td>
			<td class="center"><?= $realisasi['material_uom']; ?></td>
			<td class="center"><?= $realisasi['divisi_nama']; ?></td>
			<td class="center totalkebutuhan"><?= $realisasi['so_total_kebutuhan']; ?></td>
			<td class="center"><?= $realisasi['so_realisasi']; ?></td>
			<td><?= $realisasi['so_kosong']; ?></td>
		</tr>
		<?php endwhile; ?>
	</table>
	<section>
		<h3 class="approval-title">Approval Sheet</h3>
		<table class="approval">
			<tr>
				<td>
					<p>(...........................................)</p>
					<br>
					<p class="jabatan"><strong>PREPARED</strong></p>
				</td>
				<td>
					<p>(...........................................)</p>
					<br>
					<p class="jabatan"><strong>KABAG PRODUKSI</strong></p>
				</td>
				<td>
					<p>(...........................................)</p>
					<br>
					<p class="jabatan"><strong>PIC. PRODUKSI</strong></p>
				</td>
				<td>
					<p>(...........................................)</p>
					<br>
					<p class="jabatan"><strong>MWH</strong></p>
				</td>
				<td>
					<p>(...........................................)</p>
					<br>
					<p class="jabatan"><strong>PPIC</strong></p>
				</td>
			</tr>
		</table>
	</section>
</body>
</html>
<?php 
$html = ob_get_contents();
ob_end_clean();
$mpdf->WriteHTML(utf8_encode($html));
$mpdf->Output();
?>