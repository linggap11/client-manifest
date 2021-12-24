<?php 
	include('config/connection.php');
	session_start();     
    if (empty($_SESSION['client_id'])) {
        header("Location: login.php");
    }	
	$client_id = $_SESSION['client_id'];
	
	
	if (!empty($_GET['invest-date'])) {
		$investmentDate = $_GET['invest-date'];
		$getLastDate = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM investment WHERE client_id='$client_id' AND id ='".$investmentDate."' LIMIT 1"));
		$investmentId = $getLastDate['id'];
	} else {
		$getLastDate = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM investment WHERE client_id='$client_id' ORDER BY id DESC LIMIT 1"));
		$investmentId = $getLastDate['id'];
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<?php 
        include('layout/header.php');
    ?>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
	<script src="assets/js/plugins/tables/datatables/datatables.min.js"></script>
    <script src="assets/js/demo_pages/datatables_basic.js"></script>
	<script src="assets/js/plugins/ui/moment/moment.min.js"></script>
	<script src="assets/js/plugins/pickers/daterangepicker.js"></script>
	<script src="assets/js/plugins/pickers/pickadate/picker.js"></script>
	<script src="assets/js/plugins/pickers/pickadate/picker.date.js"></script>
	<script src="assets/js/plugins/pickers/pickadate/picker.time.js"></script>
	<script src="assets/js/plugins/pickers/pickadate/legacy.js"></script>
	<script src="assets/js/plugins/notifications/jgrowl.min.js"></script>

	<script src="assets/js/demo_pages/picker_date.js"></script>
	<script src="assets/js/plugins/visualization/echarts/echarts.min.js"></script>
	<script src="assets/js/demo_charts/echarts/light/bars/bars_basic.js"></script>
	<script src="assets/js/demo_charts/echarts/light/bars/bars_stacked.js"></script>
	<script src="assets/js/demo_charts/echarts/light/bars/bars_stacked_clustered.js"></script>
	<script src="assets/js/demo_charts/echarts/light/bars/bars_floating.js"></script>
	<script src="assets/js/demo_charts/echarts/light/bars/bars_line.js"></script>
	<script src="assets/js/demo_charts/echarts/light/bars/tornado_negative_stack.js"></script>
	<script src="assets/js/demo_charts/echarts/light/bars/tornado_staggered.js"></script>
	
	<style>
		.wrapper{
			background: #fff;
			border-radius: 5px;
			box-shadow: 7px 7px 12px rgba(0,0,0,0.05);
		}
		.wrapper header{
			color: #6990F2;
			font-size: 27px;
			font-weight: 600;
			text-align: center;
		}
		.wrapper form{
		    height: 250px;
			display: flex;
			cursor: pointer;
			align-items: center;
			justify-content: center;
			flex-direction: column;
			border-radius: 5px;
			border: 2px dashed #45748a;
			margin-bottom: 30px;
		}
		form :where(i, p){
			color: #45748a;
		}
		form i{
			font-size: 50px;
		}
		form p{
			margin-top: 15px;
			font-size: 16px;
		}
		section .row{
			margin-bottom: 10px;
			background: #E9F0FF;
			list-style: none;
			padding: 15px 20px;
			border-radius: 5px;
			display: flex;
			align-items: center;
			justify-content: space-between;
		}
		section .row i{
			color: #6990F2;
			font-size: 30px;
		}
		section .details span{
			font-size: 14px;
		}
		.progress-area .row .content{
		
			margin-left: 15px;
		}
		.progress-area .details{
			display: flex;
			align-items: center;
			margin-bottom: 7px;
			justify-content: space-between;
		}
		.progress-area .content .progress-bar{
			height: 6px;
		
			margin-bottom: 4px;
			background: #fff;
			border-radius: 30px;
		}
		.content .progress-bar .progress{
			height: 100%;
			width: 0%;
			background: #6990F2;
			border-radius: inherit;
		}
		.uploaded-area{
			max-height: 232px;
		}
		.uploaded-area.onprogress{
			max-height: 150px;
		}
		.uploaded-area::-webkit-scrollbar{
			width: 0px;
		}
		.uploaded-area .row .content{
			display: flex;
			align-items: center;
		}
		.uploaded-area .row .details{
			display: flex;
			margin-left: 15px;
			flex-direction: column;
		}
		.uploaded-area .row .details .size{
			color: #45748a;
			font-size: 11px;
		}
		.uploaded-area i.fa-check{
			font-size: 16px;
		}

		.overview {
			font-size: 12px;
		}
	</style>
	<script>
		$(document).ready(function() {
			var investDate = $('#investDate').find(":selected").text();
			
		});
	</script>
</head>

<body>

	<!-- Main navbar -->
	<div class="navbar navbar-expand-lg navbar-dark navbar-static">
		<div class="d-flex flex-1 d-lg-none">
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-mobile">
				<i class="icon-paragraph-justify3"></i>
			</button>
			<button class="navbar-toggler sidebar-mobile-main-toggle" type="button">
				<i class="icon-transmission"></i>
			</button>
		</div>

		<div class="navbar-brand text-center text-lg-left" >
			<a href="index.php" class="d-inline-block">
				<img src="assets/images/wholesales-logo.png" class="d-sm-block" alt="" >				
			</a>
			
		</div>

		<div class="collapse navbar-collapse  order-2 order-lg-1" id="navbar-mobile">	
		</div>

		<?php include('layout/navbar.php') ?>
	</div>
	<!-- /main navbar -->


	<!-- Page content -->
	<div class="page-content">

		<!-- Main sidebar -->
		<div class="sidebar sidebar-dark sidebar-main sidebar-expand-lg">

			<!-- Sidebar content -->
			<div class="sidebar-content">

				<!-- User menu -->
				<div class="sidebar-section sidebar-user my-1">
					<div class="sidebar-section-body">
						<div class="media">
							<?php 
                                $user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM user WHERE id='$client_id'"));
                            ?>
							<a href="#" class="mr-3">
								<img src="assets/images/user-profile.png" class="rounded-circle" alt="">
							</a>

							<div class="media-body">
								<div class="font-weight-semibold"><?= $user['company'] ?></div>
								<div class="font-size-sm line-height-sm opacity-50">
									<?= $user['fullname'] ?>
								</div>
							</div>

							<div class="ml-3 align-self-center">
								<button type="button" class="btn btn-outline-light-100 text-white border-transparent btn-icon rounded-pill btn-sm sidebar-control sidebar-main-resize d-none d-lg-inline-flex">
									<i class="icon-transmission"></i>
								</button>

								<button type="button" class="btn btn-outline-light-100 text-white border-transparent btn-icon rounded-pill btn-sm sidebar-mobile-main-toggle d-lg-none">
									<i class="icon-cross2"></i>
								</button>
							</div>
						</div>
					</div>
				</div>
				<!-- /user menu -->


				<!-- Main navigation -->
				<div class="sidebar-section">
					<?php include("layout/sidebar.php") ?>
				</div>
				<!-- /main navigation -->

			</div>
			<!-- /sidebar content -->
			
		</div>
		<!-- /main sidebar -->


		<!-- Main content -->
		<div class="content-wrapper">

			<!-- Inner content -->
			<div class="content-inner">

				<!-- Page header -->
				<div class="page-header page-header-light">
					<div class="page-header-content header-elements-lg-inline">
						<div class="page-title d-flex">
							<h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Home</span> - Dashboard</h4>
							<a href="#" class="header-elements-toggle text-body d-lg-none"><i class="icon-more"></i></a>
						</div>
					</div>

					<div class="breadcrumb-line breadcrumb-line-light header-elements-lg-inline">
						<div class="d-flex">
							<div class="breadcrumb">
								<a href="index.html" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Home</a>
								<span class="breadcrumb-item active">Dashboard</span>
							</div>

							<a href="#" class="header-elements-toggle text-body d-lg-none"><i class="icon-more"></i></a>
						</div>

						
					</div>
				</div>
				<!-- /page header -->


				<!-- Content area -->
				<div class="content">
					<!-- Dashboard content -->
					<div class="row">
						<div class="col-xl-12">

							<!-- Quick stats boxes -->
							<div class="row">
								<div class="col-lg-3">

									<!-- Members online -->
									<div class="card bg-primary text-white">
										<div class="card-body">
											<div class="d-flex">
												<?php 
													$cost = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM investment WHERE client_id = '$client_id' AND id='$investmentId' "));
													
												?>
												<h3 class="font-weight-semibold mb-0">$ <?= number_format($cost['cost'], 2) ?></h3>
												<!-- <span class="align-self-center ml-auto chart-icon"><img src="assets/images/icons/charts.png"> </span> -->
						                	</div>
						                	
						                	<div>
												Total Client Cost
												<div class="font-size-sm opacity-75"></div>
											</div>
										</div>

										
									</div>
									<!-- /members online -->

								</div>								

								<div class="col-lg-3">

									<!-- Current server load -->
									<div class="card bg-pink text-white">
										<div class="card-body">
											<div class="d-flex">
												<?php 
													$totalItem = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(qty) as qty FROM client_transaction WHERE client_id = '$client_id' AND investment_id = '$investmentId' "));												
										
												?>
												<h3 class="font-weight-semibold mb-0"><?php if (empty($totalItem['qty'])) { echo "0"; } else { echo $totalItem['qty']; } ?></h3>
						                	</div>
						                	
						                	<div>
												Total Unit
											</div>
										</div>

									</div>
									<!-- /current server load -->

								</div>
								<div class="col-lg-3">

									<!-- Members online -->
									<div class="card bg-teal text-white">
										<div class="card-body">
											<div class="d-flex">
												<?php 
													$retail = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(original_value) as retail FROM client_transaction WHERE client_id = '$client_id' AND investment_id = '$investmentId' "));
													
													
												?>
												<h3 class="font-weight-semibold mb-0">$ <?= number_format($retail['retail'], 2) ?></h3>
												<!-- <span class="align-self-center ml-auto chart-icon"><img src="assets/images/icons/charts.png"> </span> -->
						                	</div>
						                	
						                	<div>
												Total Original Retail
												<div class="font-size-sm opacity-75"></div>
											</div>
										</div>

										
									</div>
									<!-- /members online -->

								</div>	

								<div class="col-lg-3">

									<!-- Today's revenue -->
									<div class="card bg-secondary text-white">
										<div class="card-body">
											<div class="d-flex">
												<?php 
													$totalInvest = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(cost) as cost FROM client_transaction WHERE client_id = '$client_id' AND investment_id = '$investmentId' "));


													
												?>
												<h3 class="font-weight-semibold mb-0">$ <?= number_format(($cost['cost']-$totalInvest['cost']), 2) ?></h3>
												
						                	</div>
						                	
						                	<div>
												Cost Left
											</div>
										</div>

										
									</div>
									<!-- /today's revenue -->

								</div>
								
							</div>
							<!-- /quick stats boxes -->

														
							<!-- Support tickets -->
							<div class="card">
								<div class="card-header header-elements-sm-inline">
									<h6 class="card-title">Overview</h6>
									<div class="header-elements">
											<form method="GET">
												<?php 
													$investDate = mysqli_query($conn, "SELECT * FROM investment where client_id ='$client_id'  ");
												?>
												<select class="form-control" name="invest-date" id="investDate" onchange="this.form.submit()">
													<?php 
														if (mysqli_num_rows($investDate) > 0) {
															while ($date = mysqli_fetch_assoc($investDate)) {
																$newDate = date("m-d-Y", strtotime($date['date']));
																if ($date['id'] == $investmentId) {
																	echo "<option value='".$date['id']."' selected>".$newDate."</option>";
																} else {
																	echo "<option value='".$date['id']."'>".$newDate."</option>";
																}
															}
														} else {
															echo "<option>-</option>";
														}
													?>
												</select>
											</form>
											
				                	</div>
								</div>

								<div class="card-body d-lg-flex align-items-lg-center justify-content-lg-between flex-lg-wrap">
									

									

									<div class="d-flex align-items-center mb-3 mb-lg-0">
										<a href="#" class="btn bg-transparent border-indigo text-indigo rounded-pill border-2 btn-icon">
											<i class="icon-table2"></i>
										</a>
										<div class="ml-3">
											<h5 class="font-weight-semibold mb-0"><?php if (empty($totalItem['qty'])) { echo "0"; } else { echo $totalItem['qty']; } ?></h5>
											<span class="text-muted">Total Unit</span>
											
										</div>
									</div>
									<div class="d-flex align-items-center mb-3 mb-lg-0">
										<a href="#" class="btn bg-transparent border-indigo text-indigo rounded-pill border-2 btn-icon">
											<i class="icon-cart-remove"></i>
										</a>
										<div class="ml-3">
											<?php 
												$total_rows = "SELECT SUM(cost) as cost FROM client_transaction WHERE client_id = '$client_id'  AND investment_id = '$investmentId' ";
												$result_rows = mysqli_num_rows(mysqli_query($conn, $total_rows));
												
												if ($result_rows > 0) {
													$total_rows_imported = mysqli_fetch_assoc(mysqli_query($conn, $total_rows));	
													?>
													<h5 class="font-weight-semibold mb-0">$ <?= number_format($total_rows_imported['cost'], 2) ?></h5>
													<span class="text-muted">Total Fulfilled</span>
													<?php
												} else {
													?>
													<h5 class="font-weight-semibold mb-0">0</h5>
													<span class="text-muted">Total Fulfilled</span>
													<?php

												}
												
											?>
											
										</div>
									</div>
									<div class="d-flex align-items-center mb-3 mb-lg-0">
										<a href="#" class="btn bg-transparent border-indigo text-indigo rounded-pill border-2 btn-icon">
											<i class="icon-cube"></i>
										</a>
										<div class="ml-3">
											<?php 
												$total_rows = "SELECT COUNT(*) as total_row FROM client_transaction WHERE client_id = '$client_id' AND investment_id = '$investmentId' ";
												$result_rows = mysqli_num_rows(mysqli_query($conn, $total_rows));
												if ($result_rows > 0) {
													$total_rows_imported = mysqli_fetch_assoc(mysqli_query($conn, $total_rows));	
													?>
													<h5 class="font-weight-semibold mb-0">$ <?php if (!empty($totalItem['qty'])) { echo number_format(($cost['cost']/$totalItem['qty']), 2); } ?> 
														<span class="text-success font-size-sm font-weight-normal">AVG UNIT RETAIL ( $ <?php if (!empty($totalItem['qty'])) { echo number_format(($retail['retail']/$totalItem['qty']), 2); } ?> )</span>
													</h5>
													<span class="text-muted">AVG Unit Client Cost</span>
													<?php
												} else {
													?>
													<h5 class="font-weight-semibold mb-0">0</h5>
													<span class="text-muted">AVG Unit Client Cost</span>
													<?php

												}
												
											?>
											
										</div>
									</div>

									<div>
									<!-- <button type="button" class="btn btn-teal" data-toggle="modal" data-target="#modal_form_upload"><i class="icon-file-upload mr-2"></i>Upload Report</button> -->
								
									<div id="modal_form_upload" class="modal fade" tabindex="-1">
										<div class="modal-dialog modal-lg">
											<div class="modal-content">
												<div class="modal-header bg-secondary text-white">
													<h5 class="modal-title">Upload Your Report</h5>
													<button type="button" class="close" data-dismiss="modal">&times;</button>
												</div>
												<form action="import_file.php" method="POST" enctype="multipart/form-data">
												<div class="modal-body">	
													<div class="form-group">
														<label>Investment Date:</label>
														<div class="input-group">
															<span class="input-group-prepend">
																<span class="input-group-text"><i class="icon-calendar22"></i></span>
															</span>
															<input type="text" class="form-control daterange-single" name="date" value="12/21/2021">
														</div>
													</div>
													<div class="form-group">
														<label>Your File:</label>
														<label class="custom-file">
															<input type="file" name="file" class="custom-file-input" id="file-upload"  accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
															<span class="custom-file-label" id="file-upload-filename">Choose file</span>
														</label>
														<span class="form-text text-muted">Accepted formats: xlsx, csv. Max file size 10Mb</span>
													</div>
												</div>

												<div class="modal-footer">
													<div class="text-right">
														<button type="submit" class="btn btn-secondary">Save <i class="icon-paperplane ml-2"></i></button>
													</div>
													
												</div>
												</form>
											</div>
										</div>
									</div>
									<!-- /form upload -->
									</div>
								</div>

								<table class="table datatable-basic overview">
									<thead> 
										<tr>
											<th style="width: 5%">No</th>
											<th>Item Description</th>
											<th style="width: 20%;">Vendor Name</th>												
											<th class="text-center" style="width: 5%;">Qty</th>
											<th class="text-center " style="width: 10%;">Retail</th>
											<th class="text-center" style="width: 10%;">Total</th>
											<th class="text-center " style="width: 10%;">Cost</th>
										</tr>
									</thead>
									<tbody>
										<?php												
											$overview = "SELECT * from client_transaction WHERE client_id = '$client_id'  AND investment_id = '$investmentId'  ";
											$result = mysqli_query($conn, $overview);

											if (mysqli_num_rows($result) > 0) {
												// output data of each row
												$no = 1;
												while($row = mysqli_fetch_assoc($result)) {
													?>
													<tr>
														<td class="text-center">
															<h6 class="mb-0"><?= $no++ ?></h6>
														</td>
														<td>
															<a href="#" class="text-body">
																<div class="font-weight-semibold"><?= $row['item_description'] ?></div>
																<span class="text-muted">SKU: <?= $row['sku'] ?></span>
															</a>
														</td>
														<td>
															<div class="d-flex align-items-center">														
																<div>
																	<a href="#" class="text-body font-weight-semibold letter-icon-title"><?= $row['vendor'] ?></a>															
																</div>
															</div>
														</td>
														
														<td class="text-center">
															<?= $row['qty'] ?>
														</td>
														<td class="text-center">$ <?= $row['retail_value'] ?></td>
														<td class="text-center">$ <?= $row['original_value'] ?></td>
														<td class="text-center">$ <?= $row['cost'] ?></td>
														
													</tr>
													<?php
													
												}													
											}
											
										?>
										
									</tbody>
								</table>
							</div>
							<div class="row">
								<div class="col-xl-8">
									<!-- Multi level donut chart -->
									<div class="card">
										<div class="card-header">
											<h5 class="card-title">Sales By Vendor </h5>
										</div>
										
										<div class="card-body">
											<div class="chart-container">
												<div class="chart has-fixed-height" id="main"></div>
												<?php 
													$getVendorQuery = mysqli_query($conn, "SELECT count(qty) as qty, vendor FROM `client_transaction` WHERE client_id = '$client_id'  AND investment_id = '$investmentId'  GROUP BY vendor ORDER BY qty");
													$vendorNames = array();
													$vendorQty = array();
													if (mysqli_num_rows($getVendorQuery) > 0) {
														while ($vendorRow = mysqli_fetch_assoc($getVendorQuery)) {
															array_push($vendorNames, $vendorRow['vendor']);
															array_push($vendorQty, $vendorRow['qty']);
														}
													}
													$vendorNames = json_encode($vendorNames);	
													$vendorQty = json_encode($vendorQty);	
												?>
												<script type="text/javascript">
													// Initialize the echarts instance based on the prepared dom
													var myChart = echarts.init(document.getElementById('main'));
													// Specify the configuration items and data for the chart
													option = {
														
													tooltip: {
														trigger: 'axis',
														axisPointer: {
														// Use axis to trigger tooltip
														type: 'shadow' // 'shadow' as default; can also be 'line' or 'shadow'
														}
													},
													legend: {},
													grid: {
														
														right: '4%',
														bottom: '3%',
														containLabel: false
													},
													xAxis: {
														type: 'value'
													},
													yAxis: {
														type: 'category',
														data: <?= $vendorNames ?>
													},
													series: [
														{
															name: 'Total Sales',
															type: 'bar',
															stack: 'total',
															itemStyle: {
																color: '#749f83'
															},
															emphasis: {
																focus: 'series'
															},
															
															data: <?= $vendorQty ?>
														},
														
														
													]
													};

													// Display the chart using the configuration items and data just specified.
													myChart.setOption(option);
												</script>
											</div>
										</div>
									</div>
									<!-- /multi level donut chart -->

								</div>
								<div class="col-xl-4">
									<!-- Multi level donut chart -->
									<div class="card">
									
										
										<div class="card-body">
											<div class="chart-container">
												<div class="chart has-fixed-height" id="percentage"></div>
												<?php 
													$totalFulfilled = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(cost) as cost FROM client_transaction WHERE client_id = '$client_id'  AND investment_id = '$investmentId' "));													
													$fulfilledPercent = ($totalFulfilled['cost']/$cost['cost'])*100;
													$clientCostPercent = 100 - $fulfilledPercent;

												?>
												<script type="text/javascript">
													// Initialize the echarts instance based on the prepared dom
													var myChart = echarts.init(document.getElementById('percentage'));
													// Specify the configuration items and data for the chart
													option = {
														title: {
															text: 'Cost Percentage',
															left: 'right'
														},
														tooltip: {
															trigger: 'item'
														},
														legend: {
															orient: 'vertical',
															left: 'left'
														},
														series: [
															{
															name: 'Total',
															type: 'pie',
															radius: '40%',
															data: [
																{ value: 767.41, name: 'Fulfilled <?= number_format($fulfilledPercent, 1) ?>%' },
																{ value: 4650, name: 'Client Cost <?= number_format($clientCostPercent, 1) ?>%' }
																
															],
															emphasis: {
																itemStyle: {
																	shadowBlur: 10,
																	shadowOffsetX: 0,
																	shadowColor: 'rgba(0, 0, 0, 0.5)'
																}
															}
															}
														]
														};

													// Display the chart using the configuration items and data just specified.
													myChart.setOption(option);
												</script>
											</div>
										</div>
									</div>
									<!-- /multi level donut chart -->

								</div>		
								
							</div>
							
							
						</div>

						
					</div>
					<!-- /dashboard content -->

				</div>
				<!-- /content area -->


				<!-- Footer -->
				<?php include('layout/footer.php') ?>
				<!-- /footer -->

			</div>
			<!-- /inner content -->

		</div>
		<!-- /main content -->

	</div>
	<!-- /page content -->

</body>
</html>

<script>
var input = document.getElementById( 'file-upload' );
var infoArea = document.getElementById( 'file-upload-filename' );

input.addEventListener( 'change', showFileName );

function showFileName( event ) {
  // the change event gives us the input it occurred in 
  var input = event.srcElement;
  // the input has an array of files in the `files` property, each one has a name that you can use. We're just using the name here.
  var fileName = input.files[0].name;
  // use fileName however fits your app best, i.e. add it into a div
  infoArea.textContent = '' + fileName;
}

</script>
