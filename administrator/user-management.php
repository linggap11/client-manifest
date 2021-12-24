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
							<h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Home</span> - User Management</h4>
							<a href="#" class="header-elements-toggle text-body d-lg-none"><i class="icon-more"></i></a>
						</div>
					</div>

					<div class="breadcrumb-line breadcrumb-line-light header-elements-lg-inline">
						<div class="d-flex">
							<div class="breadcrumb">
								<a href="index.html" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Home</a>
								<span class="breadcrumb-item active">User Management</span>
							</div>
                            
							<a href="#" class="header-elements-toggle text-body d-lg-none"><i class="icon-more"></i></a>
						</div>

						
					</div>
				</div>
				<!-- /page header -->

                <!-- Content area -->
				<div class="content">
                    <div class="card">	
                        <div style="margin: 10px; text-align: right;">
                            <button type="button" class="btn btn-teal" data-toggle="modal" data-target="#modal_form_upload"><i class="icon-user-plus mr-2"></i>Add Client</button>
                            
                        </div>
                        <div id="modal_form_upload" class="modal fade" tabindex="-1">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header bg-secondary text-white">
                                        <h5 class="modal-title">Add Client</h5>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <form action="add-client.php" method="POST" enctype="multipart/form-data">
                                    <div class="modal-body">	
                                        <div class="form-group">
                                            <label>Fullname</label>
                                            <div class="input-group">
                                                <span class="input-group-prepend">
                                                    <span class="input-group-text"><i class="icon-user"></i></span>
                                                </span>
                                                <input type="text" class="form-control" name="fullname" value="">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Company Name</label>
                                            <div class="input-group">
                                                <span class="input-group-prepend">
                                                    <span class="input-group-text"><i class="icon-office"></i></span>
                                                </span>
                                                <input type="text" class="form-control" name="company" value="">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label><Address></Address>Address</label>
                                            <div class="input-group">
                                                <span class="input-group-prepend">
                                                    <span class="input-group-text"><i class="icon-address-book3"></i></span>
                                                </span>
                                               <textarea class="form-control" name="address"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Username</label>
                                            <div class="input-group">
                                                <span class="input-group-prepend">
                                                    <span class="input-group-text"><i class="icon-users2"></i></span>
                                                </span>
                                                <input type="text" class="form-control" name="username" value="">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Password</label>
                                            <div class="input-group">
                                                <span class="input-group-prepend">
                                                    <span class="input-group-text"><i class="icon-lock2"></i></span>
                                                </span>
                                                <input type="password" name="new_password" class="form-control"  autocomplete="false" id="password" value="">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Confirm Password</label>
                                            <div class="input-group">
                                                <span class="input-group-prepend">
                                                    <span class="input-group-text"><i class="icon-lock2"></i></span>
                                                </span>
                                                <input type="password" name="confirm_password" class="form-control"  autocomplete="false"id="confirm_password" value="">
                                                
                                            </div>
                                            <span id='message'></span>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <div class="text-right">
                                            <button type="submit" class="btn btn-secondary">Add <i class="icon-paperplane ml-2"></i></button>
                                        </div>
                                        
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>
						<table class="table datatable-basic">
							<thead>
								<tr>
									<th>No.</th>
									<th>Fullname</th>
									<th>Username</th>
									<th>Company Name</th>
									<th>Role</th>
									<th class="text-center">Actions</th>
								</tr>
							</thead>
							<tbody>
                                <?php
                                    $sql = "SELECT * FROM user WHERE role <>'superadmin' ";
                                    $result = mysqli_query($conn, $sql);

                                    if (mysqli_num_rows($result) > 0) {
                                        // output data of each row
                                        $no=1;
                                        while($row = mysqli_fetch_assoc($result)) {
                                            ?>
                                            <tr>
                                                <td class="text-center">
                                                    <h6 class="mb-0"><?= $no++ ?></h6>
                                                </td>
                                                <td class="">
                                                    <h6 class="mb-0"><?= $row['fullname'] ?></h6>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">														
                                                        <div>
                                                            <a href="#" class="text-body font-weight-semibold letter-icon-title"><?= $row['username'] ?></a>															
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <a href="#" class="text-body">
                                                        <div class="font-weight-semibold"><?= $row['company'] ?></div>
                                                        
                                                    </a>
                                                </td>
                                                <td class="text-center">
                                                    <h6 class="mb-0"><?= $row['role'] ?></h6>
                                                </td>
                                                <td class="text-center">
                                                    <div class="list-icons">
                                                        <div class="dropdown">
                                                            <a href="#" class="list-icons-item" data-toggle="dropdown"><i class="icon-menu7"></i></a>
                                                            <div class="dropdown-menu dropdown-menu-right">                                                               
                                                                <a href="update-client.php?id=<?= $row['id'] ?>" class="dropdown-item"><i class="icon-pencil text-primary"></i> Edit</a>
                                                                <a href="delete-client.php?id=<?= $row['id'] ?>" class="dropdown-item"><i class="icon-cross2 text-danger"></i> Delete</a>
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
