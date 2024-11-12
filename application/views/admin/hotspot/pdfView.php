<!DOCTYPE html>
<html>
<head>
	<title><?=$title?></title>
	<style type="text/css">
		.table{
			width: 100%;
			border-spacing: 0
		}
		.table tr:first-child th,
		.table tr:first-child td{
			border-top: 1px solid #000
		}
		.table tr th:first-child,
		.table tr td:first-child{
			border-left: 1px solid #000
		}
		.table tr th,
		.table tr td{
			border-right: 1px solid #000;
			border-bottom: 1px solid #000;
			padding:4px;
			vertical-align: top
		}
		.text-center{
			text-align: center;
		}
	</style>
</head>
<body>
	<h1>Data bendung dan pintu air</h1>
	<table class="table table-bordered">
		<thead>
			<tr>
				<th width="50px" class="text-center">No</th>
				<th>Nama</th>
				<th>Kecamatan</th>
				<th>Struktur</th>
				<th>Jumlah Pintu</th>
				<th>Dimensi</th>
				<th>Jenis</th>
				<th>Lat</th>
				<th>Lng</th>
				<th>Kategori</th>
			</tr>
		</thead>
		<tbody>
			<?php
				$no=1;
				foreach ($datatable->result() as $row) {
					?>
						<tr>
							<td class="text-center"><?=$no?></td>
							<td><?=$row->nama?></td>
							<td><?=$row->nm_kecamatan?></td>
							<td><?=$row->struktur?></td>
							<td><?=$row->jumlah_pintu?></td>
							<td><?=$row->dimensi?></td>
							<td><?=$row->jenis_pintu?></td>
							<td><?=$row->lat?></td>
							<td><?=$row->lng?></td>
							<td><?=$row->nm_kategori_bendung?></td>
						</tr>
					<?php
					$no++;
				}

			?>
		</tbody>
	</table>

</body>
</html>