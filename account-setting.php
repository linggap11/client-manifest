<?php 
	include('config/connection.php');
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
							<h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Home</span> - Account</h4>
							<a href="#" class="header-elements-toggle text-body d-lg-none"><i class="icon-more"></i></a>
						</div>
					</div>

					<div class="breadcrumb-line breadcrumb-line-light header-elements-lg-inline">
						<div class="d-flex">
							<div class="breadcrumb">
								<a href="index.html" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Home</a>
								<span class="breadcrumb-item active">Account</span>
							</div>

							<a href="#" class="header-elements-toggle text-body d-lg-none"><i class="icon-more"></i></a>
						</div>

						
					</div>
				</div>
				<!-- /page header -->


				<!-- Content area -->
				<div class="content">
					<div class="card">
                        <div class="card-header">
                            <h5>Setting Your Account</h5>
                        </div>
                        <div class="card-body">
                            <?php 
                                $user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM user WHERE id='$client_id'"));
                            ?>
                            <form action="update-account-setting.php" method="POST" enctype="multipart/form-data">
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-2">Username</label>
                                    <div class="col-lg-10">
                                        <input type="hidden" name="id" readonly value="<?= $user['id'] ?>">
                                        <input type="text" class="form-control" disabled value="<?= $user['username'] ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-2">Fullname</label>
                                    <div class="col-lg-10">
                                        <input type="text" name="fullname" class="form-control" value="<?= $user['fullname'] ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-2">Company Name</label>
                                    <div class="col-lg-10">
                                        <input type="text" class="form-control" name="company" autocomplete="false" value="<?= $user['company'] ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-2" >Address</label>
                                    <div class="col-lg-10">
                                        <textarea class="form-control" name="address" col=4><?= $user['address'] ?></textarea>
                                    </div>
                                </div>
                                <fieldset class="mb-3">
                                    <legend class="text-uppercase font-size-sm font-weight-bold">Change Password</legend>
                                    <div class="form-group row">
                                        <label class="col-form-label col-lg-2">Old Password</label>
                                        <div class="col-lg-10">
                                            <input type="password" name="old_password" class="form-control"  autocomplete="false" value="">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-form-label col-lg-2">New Password</label>
                                        <div class="col-lg-10">
                                            <input type="password" name="new_password" class="form-control"  autocomplete="false" id="password" value="">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-form-label col-lg-2">Confirm New Password</label>
                                        <div class="col-lg-10">
                                            <input type="password" name="confirm_password" class="form-control"  autocomplete="false"id="confirm_password" value="">
                                            <span id='message'></span>
                                        </div>
                                    </div>
                                </fieldset>
                                <div class="text-right">
									<button type="submit" class="btn btn-secondary">Save <i class="icon-paperplane ml-2"></i></button>
								</div>
                            </form>
                        </div>
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
