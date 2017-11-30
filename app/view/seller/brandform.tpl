<!DOCTYPE html>
<html lang="en" data-textdirection="ltr" class="loading">
  <head>
   {include file="header.tpl"}
  </head>
  <body data-open="click" data-menu="vertical-menu" data-col="2-columns" class="vertical-layout vertical-menu 2-columns  fixed-navbar">

    <!-- navbar-fixed-top-->
  {include file="navbartop.tpl"}
    <!-- ////////////////////////////////////////////////////////////////////////////-->


    <!-- main menu-->
   {include file="navbar.tpl"}
    <!-- / main menu-->

    <div class="app-content content container-fluid">
      <div class="content-wrapper">
        <div class="content-header row">
          <div class="content-header-left col-md-6 col-xs-12 mb-1">
            <h2 class="content-header-title">Seller Forms</h2>
          </div>
          <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-xs-12">
            <div class="breadcrumb-wrapper col-xs-12">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a>
                </li>
                <li class="breadcrumb-item"><a href="#">Form Layouts</a>
                </li>
                <li class="breadcrumb-item active"><a href="#">Basic Forms</a>
                </li>
              </ol>
            </div>
          </div>
        </div>
        <div class="content-body"><!-- Basic form layout section start -->
<section id="basic-form-layouts">
	


<!-- 
	<div class="row match-height">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title" id="basic-layout-form-center">Event Registration</h4>
					<a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
					<div class="heading-elements">
						<ul class="list-inline mb-0">
							<li><a data-action="collapse"><i class="icon-minus4"></i></a></li>
							<li><a data-action="reload"><i class="icon-reload"></i></a></li>
							<li><a data-action="expand"><i class="icon-expand2"></i></a></li>
							<li><a data-action="close"><i class="icon-cross2"></i></a></li>
						</ul>
					</div>
				</div>
				<div class="card-body collapse in">
					<div class="card-block">

						<div class="card-text">
							<p>This example shows a way to center your form in the card. Here we have used <code>col-md-6 offset-md-3</code> classes to center the form in a full width card. User can always change those classes according to width and offset requirements. This example also uses form action buttons in the center bottom position of the card.</p>
						</div>

						<form class="form">
							<div class="row">
								<div class="col-md-6 offset-md-3">
									<div class="form-body">
										<div class="form-group">
											<label for="eventInput1">Full Name</label>
											<input type="text" id="eventInput1" class="form-control" placeholder="name" name="fullname">
										</div>

										<div class="form-group">
											<label for="eventInput2">Title</label>
											<input type="text" id="eventInput2" class="form-control" placeholder="title" name="title">
										</div>

										<div class="form-group">
											<label for="eventInput3">Company</label>
											<input type="text" id="eventInput3" class="form-control" placeholder="company" name="company">
										</div>

										<div class="form-group">
											<label for="eventInput4">Email</label>
											<input type="email" id="eventInput4" class="form-control" placeholder="email" name="email">
										</div>

										<div class="form-group">
											<label for="eventInput5">Contact Number</label>
											<input type="tel" id="eventInput5" class="form-control" name="contact" placeholder="contact number">
										</div>

										<div class="form-group">
											<label>Existing Customer</label>
											<div class="input-group">
												<label class="display-inline-block custom-control custom-radio ml-1">
													<input type="radio" name="customer1" class="custom-control-input">
													<span class="custom-control-indicator"></span>
													<span class="custom-control-description ml-0">Yes</span>
												</label>
												<label class="display-inline-block custom-control custom-radio">
													<input type="radio" name="customer1" checked class="custom-control-input">
													<span class="custom-control-indicator"></span>
													<span class="custom-control-description ml-0">No</span>
												</label>
											</div>
										</div>

									</div>
								</div>
							</div>

							<div class="form-actions center">
								<button type="button" class="btn btn-warning mr-1">
									<i class="icon-cross2"></i> Cancel
								</button>
								<button type="submit" class="btn btn-primary">
									<i class="icon-check2"></i> Save
								</button>
							</div>
						</form>	

					</div>
				</div>
			</div>
		</div>
	</div>
 -->

	<div class="row">
		<div class="col-md-6 offset-md-3">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title" id="basic-layout-card-center">Seller Registration</h4>
					<a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
					<div class="heading-elements">
						<ul class="list-inline mb-0">
							<li><a data-action="collapse"><i class="icon-minus4"></i></a></li>
							<li><a data-action="reload"><i class="icon-reload"></i></a></li>
							<li><a data-action="expand"><i class="icon-expand2"></i></a></li>
							<li><a data-action="close"><i class="icon-cross2"></i></a></li>
						</ul>
					</div>
				</div>
				<div class="card-body collapse in">
					<div class="card-block">
						<div class="card-text">
							<!-- <p></p> -->
						</div>
						<form class="form" action="createbrand" method="POST">
							<div class="form-body">

								<div class="form-group">
									<label for="eventRegInput1">Brand/Label Name</label>
									<input type="text" id="eventRegInput1" class="form-control" placeholder="eg. Nike" name="name">
								</div>

								<div class="form-group">
									<label for="eventRegInput2">Username</label>
									<input type="text" id="eventRegInput2" class="form-control" placeholder="eg. nikeofficial" name="username">
								</div>

								<div class="form-group">
									<label for="eventRegInput3">Company</label>
									<input type="text" id="eventRegInput3" class="form-control" placeholder="company" name="company">
								</div>

								<div class="form-group">
									<label for="eventRegInput3">Website</label>
									<input type="text" id="eventRegInput3" class="form-control" placeholder="website" name="website">
								</div>

								<div class="form-group">
									<label for="eventRegInput4">Email</label>
									<input type="email" id="eventRegInput4" class="form-control" placeholder="email" name="email">
								</div>

								<div class="form-group">
									<label for="eventRegInput5">Contact Number</label>
									<input type="tel" id="eventRegInput5" class="form-control" name="contact" placeholder="contact number" maxlength="10">
								</div>

								<div class="form-group">
									<label>Type</label>
									<div class="input-group">
										<label class="display-inline-block custom-control custom-radio ml-1">
											<input type="radio" name="type" value="1" checked class="custom-control-input">
											<span class="custom-control-indicator"></span>
											<span class="custom-control-description ml-0">Brand</span>
										</label>
										<label class="display-inline-block custom-control custom-radio">
											<input type="radio" name="type" value="0" class="custom-control-input">
											<span class="custom-control-indicator"></span>
											<span class="custom-control-description ml-0">Label</span>
										</label>
									</div>
								</div>
							</div>

							<div class="form-actions center">
								<button type="reset" class="btn btn-warning mr-1">
									<i class="icon-cross2"></i> Cancel
								</button>
								<button type="submit" class="btn btn-primary">
									<i class="icon-check2"></i> Save
								</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- // Basic form layout section end -->
        </div>
      </div>
    </div>
    <!-- ////////////////////////////////////////////////////////////////////////////-->

{include file="footer.tpl"}
  </body>
</html>
