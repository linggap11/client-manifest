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
                        <div class="card-header header-elements-sm-inline">
                            <h6 class="card-title">Client Activities</h6>
                            
                        </div>

                        <div class="card-body d-lg-flex align-items-lg-center justify-content-lg-between flex-lg-wrap">
                            

                            

                            <div class="d-flex align-items-center mb-3 mb-lg-0">
                                <a href="#" class="btn bg-transparent border-indigo text-indigo rounded-pill border-2 btn-icon">
                                    <i class="icon-table2"></i>
                                </a>
                                <div class="ml-3">
                                    <?php 
                                        $clientTotal = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM user JOIN log_client on user.id=log_client.client_id where role <> 'superadmin'  "))
                                    ?>
                                    <h5 class="font-weight-semibold mb-0"><?php if (empty($clientTotal['total'])) { echo "0"; } else { echo $clientTotal['total']; } ?></h5>
                                    <span class="text-muted">Total Activities</span>
                                    
                                </div>
                            </div>
                            <div class="d-flex align-items-center mb-3 mb-lg-0">
                                <!-- <a href="#" class="btn bg-transparent border-indigo text-indigo rounded-pill border-2 btn-icon">
                                    <i class="icon-cart-remove"></i>
                                </a> -->
                                
                            </div>
                            <div class="d-flex align-items-center mb-3 mb-lg-0">
                                <!-- <a href="#" class="btn bg-transparent border-indigo text-indigo rounded-pill border-2 btn-icon">
                                    <i class="icon-cube"></i>
                                </a> -->
                                
                            </div>
                            <button type="button" class="btn btn-teal" data-toggle="modal" data-target="#modal_form_upload"><i class="icon-file-upload mr-2"></i>Upload Report</button>
                            <div id="modal_form_upload" class="modal fade" tabindex="-1">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header bg-secondary text-white">
                                            <h5 class="modal-title">Upload User Manifest</h5>
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
                                                <label>Client Name:</label>
                                                <div class="input-group">
                                                    <span class="input-group-prepend">
                                                        <span class="input-group-text"><i class="icon-user"></i></span>
                                                    </span>
                                                    <select class="form-control" name="client">
                                                        <?php 
                                                            $getClient = mysqli_query($conn, "SELECT * FROM user WHERE role='client' ORDER BY id DESC ");
                                                            if (mysqli_num_rows($getClient) > 0) {
                                                                while ($client = mysqli_fetch_assoc($getClient)) {
                                                                    echo "<option value='".$client['id']."'>".$client['fullname']." (".$client['company'].")</option>";
                                                                }
                                                            } else {
                                                                echo "<option>-</option>";
                                                            }
                                                            
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>File:</label>
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
                        </div>

                        <table class="table datatable-basic" style="font-size: 12px;">
                            <thead> 
                                <tr>
                                    <th style="width: 5%">No</th>
                                    <th>Client Name</th>
                                    <th>Company Name</th>			
                                    <th>File Uploaded</th>			
                                    <th>Date Uploaded</th>			
                                    <th>Download</th>
                                    <th>Action</th>			
                                </tr>
                            </thead>
                            <tbody>
                                <?php												
                                    $overview = "SELECT log_client.id as log_id, fullname, company, file, date from user join log_client on user.id=log_client.client_id where role <> 'superadmin'  ";
                                    $result = mysqli_query($conn, $overview);

                                    if (mysqli_num_rows($result) > 0) {
                                        // output data of each row
                                        $no = 1;
                                        while($row = mysqli_fetch_assoc($result)) {
                                            ?>
                                            <tr>
                                                <td class="text-center"><?= $no++ ?></td>
                                                <td ><?= $row['fullname'] ?></td>
                                                <td ><?= $row['company'] ?></td>
                                                <td ><?= $row['file'] ?></td>
                                                <td class="text-center"><?= $row['date'] ?></td>
                                                <td class="text-center"><a href="../uploads/<?= $row['file'] ?>" download="<?= $row['file'] ?>"><i class="icon-download4"></i></a></td>
                                                <td class="text-center">
                                                    <div class="list-icons">
                                                        <div class="dropdown">
                                                            <a href="#" class="list-icons-item" data-toggle="dropdown"><i class="icon-menu7"></i></a>
                                                            <div class="dropdown-menu dropdown-menu-right">                                                               
                                                                <a href="delete-file.php?id=<?= $row['log_id'] ?>" class="dropdown-item"><i class="icon-cross2 text-danger"></i> Delete</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
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
