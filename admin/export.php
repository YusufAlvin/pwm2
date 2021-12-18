<?php  
session_start();
require_once "../koneksi.php";
require_once '../vendor/autoload.php';

if($_SESSION['login'] != true){
	header('Location: ../');
	exit();
}

$soprojects = $_GET['projects'];
$itemid = $_GET['itemid'];
$divisi = $_GET['divisi'];

if($divisi == "" || $soprojects == "" || $itemid == ""){
	header('Location: export-filter.php?pesan=fieldkosong');
	exit();
}

$queryso = mysqli_query($conn, "SELECT * FROM so INNER JOIN item ON item.item_id = so.so_item_id INNER JOIN material ON material.material_id = so.so_material_id INNER JOIN divisi ON divisi.divisi_id = so.so_divisi_id WHERE so_no_spk = '$soprojects' AND so_divisi_id = $divisi AND so_item_id = '$itemid'");
$queryso2 = mysqli_query($conn, "SELECT * FROM so INNER JOIN item ON item.item_id = so.so_item_id INNER JOIN material ON material.material_id = so.so_material_id INNER JOIN divisi ON divisi.divisi_id = so.so_divisi_id WHERE so_no_spk = '$soprojects' AND so_divisi_id = $divisi AND so_item_id = '$itemid'");

// if($itemid == ""){
// 	$queryso = mysqli_query($conn, "SELECT * FROM so INNER JOIN item ON item.item_id = so.so_item_id INNER JOIN material ON material.material_id = so.so_material_id INNER JOIN divisi ON divisi.divisi_id = so.so_divisi_id WHERE so_no_spk = '$soprojects' AND so_divisi_id = $divisi");
// 	$queryso2 = mysqli_query($conn, "SELECT * FROM so INNER JOIN item ON item.item_id = so.so_item_id INNER JOIN material ON material.material_id = so.so_material_id INNER JOIN divisi ON divisi.divisi_id = so.so_divisi_id WHERE so_no_spk = '$soprojects' AND so_divisi_id = $divisi");
// } elseif ($itemid != ""){
// 	$queryso = mysqli_query($conn, "SELECT * FROM so INNER JOIN item ON item.item_id = so.so_item_id INNER JOIN material ON material.material_id = so.so_material_id INNER JOIN divisi ON divisi.divisi_id = so.so_divisi_id WHERE so_no_spk = '$soprojects' AND so_divisi_id = $divisi AND so_item_id = '$itemid'");
// 	$queryso2 = mysqli_query($conn, "SELECT * FROM so INNER JOIN item ON item.item_id = so.so_item_id INNER JOIN material ON material.material_id = so.so_material_id INNER JOIN divisi ON divisi.divisi_id = so.so_divisi_id WHERE so_no_spk = '$soprojects' AND so_divisi_id = $divisi AND so_item_id = '$itemid'");
// }

if(mysqli_num_rows($queryso) < 1 && mysqli_num_rows($queryso2) < 1){
	header('Location: export-filter.php?pesan=datakosong');
	exit();
}
// 'A4-L'
// [294, 500]
$mpdf = new \Mpdf\Mpdf(['format' => [294, 500]]);
$so2 = mysqli_fetch_assoc($queryso2);
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
		  border: 2px solid black;
		  border-collapse: collapse;
		  padding: 5px;
		}
		.material td, .menu, .semicolon{
			font-weight: bold;
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
			<td class="semicolon">: <?php echo $so2['item_id'] ?></td>
		</tr>
		<tr>
			<td class="menu">Item Name</td>
			<td class="semicolon">: <?php echo $so2['item_nama'] ?></td>
		</tr>
		<tr>
			<td class="menu">LotNbr / SO</td>
			<td class="semicolon">: <?php echo $so2['so_lot_number']. " / " . $so2['so_no_spk'] ?></td>
		</tr>
		<tr>
			<td class="menu">Qty Order</td>
			<td class="semicolon">: <?php echo $so2['so_qty_order'] ?> PCS</td>
		</tr>
		<tr>
			<td class="menu">Divisi</td>
			<td class="semicolon">: <?php echo $so2['divisi_nama'] ?></td>
		</tr>
	</table>
	<br>
	<table class="material">
		<tr>
			<td class="td">Code</td>
			<td class="td">Nama</td>
			<td class="td">Quantity</td>
			<td class="td">UoM</td>
			<td class="td">Total Kebutuhan</td>
			<td class="td">Realisasi</td>
			<td class="td">Realisasi</td>
		</tr>
		<?php while($so = mysqli_fetch_assoc($queryso)) : ?>
		<tr>
			<td><?= $so['material_id']; ?></td>
			<td><?= $so['material_nama']; ?></td>
			<td class="center"><?= $so['so_material_qty']; ?></td>
			<td class="center"><?= $so['material_uom']; ?></td>
			<td class="center"><?= $so['so_total_kebutuhan']; ?></td>
			<td><?= $so['so_realisasi']; ?></td>
			<td><?= $so['so_realisasi']; ?></td>
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