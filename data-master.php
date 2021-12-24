<?php 
	include("config/connection.php");	
	session_start();     
    if (empty($_SESSION['client_id'])) {
        header("Location: login.php");
    }	
	$client_id = $_SESSION['client_id'];

	$getLastDate = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM investment WHERE client_id='$client_id' ORDER BY id DESC LIMIT 1"));
	$investmentId = $getLastDate['id'];
	

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<?php 
        include('layout/header.php');
    ?>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
    <!-- Theme JS files -->
	<script src="assets/js/plugins/tables/datatables/datatables.min.js"></script>
    <script src="assets/js/demo_pages/datatables_basic.js"></script>
	
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

		<div class="navbar-brand text-center text-lg-left">
			<a href="index.html" class="d-inline-block">
				<img src="assets/images/logo_light.png" class="d-none d-sm-block" alt="">
				<img src="assets/images/logo_icon_light.png" class="d-sm-none" alt="">
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
							<a href="#" class="mr-3">
								<img src="assets/images/user-profile.png" class="rounded-circle" alt="">
							</a>

							<div class="media-body">
								<div class="font-weight-semibold">Administrator</div>
								<div class="font-size-sm line-height-sm opacity-50">
									Senior Administrator
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
							<h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Home</span> - Data Master</h4>
							<a href="#" class="header-elements-toggle text-body d-lg-none"><i class="icon-more"></i></a>
						</div>
					</div>

					<div class="breadcrumb-line breadcrumb-line-light header-elements-lg-inline">
						<div class="d-flex">
							<div class="breadcrumb">
								<a href="index.html" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Home</a>
								<span class="breadcrumb-item active">Data Master</span>
							</div>

							<a href="#" class="header-elements-toggle text-body d-lg-none"><i class="icon-more"></i></a>
						</div>

						
					</div>
				</div>
				<!-- /page header -->


				<!-- Content area -->
				<div class="content">
                	<div class="card">
						
					<table class="table datatable-basic" style="font-size: 12px">
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
