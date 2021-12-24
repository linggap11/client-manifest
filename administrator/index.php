<?php 
	include('../config/connection.php');
	session_start();     
    if (empty($_SESSION['client_id'])) {
        header("Location: login.php");
    }	
	$client_id = $_SESSION['client_id'];
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<?php 
        include('layout/header.php');
    ?>

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
                    <div class="card">	
                        
                       
						<table class="table datatable-basic" style="font-size: 12px;">
							<thead>
								<tr>
									<th style="width: 5%;">No.</th>
									<th>Client Name</th>
									<th>Company</th>
									<th>Total Unit</th>
									<th>Total Retail</th>
									<th>Client Cost</th>
									<th>Total Fulfilled</th>
									<th>Total Cost Left</th>
									<th>AVG Unit Client Cost</th>
									<th>AVG Unit Retail</th>
									
								</tr>
							</thead>
							<tbody>
                                <?php
                                    $sql = "SELECT client_transaction.client_id, fullname, company, SUM(qty) as total_unit, SUM(original_value) as total_retail, SUM(DISTINCT investment.cost) as total_client_cost, SUM(client_transaction.cost) as total_fulfilled, (investment.cost-(SUM(client_transaction.cost))) as cost_left ,(investment.cost/SUM(qty)) as avg_client_cost, (SUM(original_value)/SUM(qty)) as avg_unit_retail FROM investment LEFT JOIN client_transaction ON investment.id = client_transaction.investment_id LEFT JOIN user ON client_transaction.client_id = user.id WHERE user.role='client' GROUP BY investment.client_id";
									$result = mysqli_query($conn, $sql);

                                    if (mysqli_num_rows($result) > 0) {
                                        // output data of each row
                                        $no=1;
                                        while($row = mysqli_fetch_assoc($result)) {
                                            ?>
                                            <tr>
                                                <td class="text-center"><?= $no++ ?></td>
                                                <td><?= $row['fullname'] ?></td>
                                                <td><?= $row['company'] ?></td>
                                                <td class="text-center"><?= $row['total_unit'] ?></td>
                                                <td class="text-center">$ <?= number_format($row['total_retail'], 2) ?></td>
                                                <td class="text-center">$ <?= number_format($row['total_client_cost'], 2) ?></td>
                                                <td class="text-center">$ <?= number_format($row['total_fulfilled'], 2) ?></td>
                                                <td class="text-center">$ <?= number_format($row['cost_left'], 2) ?></td>
                                                <td class="text-center">$ <?= number_format($row['avg_client_cost'], 2) ?></td>
                                                <td class="text-center">$ <?= number_format($row['avg_unit_retail'], 2) ?></td>
                                                
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

<script>
    $(document).ready(function() {


        $('#password, #confirm_password').on('keyup', function () {
        if ($('#password').val() == $('#confirm_password').val()) {
            $('#message').html('Matching').css('color', 'green');
        } else 
            $('#message').html('Not Matching').css('color', 'red');
        });
    });
</script>
