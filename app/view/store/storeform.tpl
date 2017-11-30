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

	<div class="row">
		<div class="col-md-6 offset-md-3">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title" id="basic-layout-card-center">Store Registration</h4>
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
							<p>Manager : {$smarty.session.manager}&nbsp;&nbsp;&nbsp;&nbsp;Email : {$manager->email}</p>
						</div>
						<form class="form" action="createstore" method="POST">
							<div class="form-body">

								<div class="form-group">
									<label>Type </label>
									<div class="input-group">
										<label class="display-inline-block custom-control custom-radio ml-1">
											<input type="radio" name="type" title="Exclusive Brand Outlet" value="ebo" checked class="custom-control-input">
											<span class="custom-control-indicator"></span>
											<span class="custom-control-description ml-0">EBO</span>
										</label>
										<label class="display-inline-block custom-control custom-radio">
											<input type="radio" name="type" title="Multi Brand Outlet" value="mbo" class="custom-control-input">
											<span class="custom-control-indicator"></span>
											<span class="custom-control-description ml-0">MBO</span>
										</label>
										<label class="display-inline-block custom-control custom-radio">
											<input type="radio" name="type" title="Shop-in-Shop" value="sis" class="custom-control-input">
											<span class="custom-control-indicator"></span>
											<span class="custom-control-description ml-0">SIS</span>
										</label>
									</div>
								</div>

								<div class="form-group">
									<label for="eventRegInput1">Store Name</label>
									<input type="text" id="eventRegInput1" class="form-control" placeholder="eg. Nike Store" name="name">
								</div>

								<div class="form-group">
									<label for="projectinput8">Address</label>
									<textarea id="projectinput8" rows="5" class="form-control" name="address" placeholder="Address"></textarea>
								</div>

								<div class="form-group">
									<label for="eventRegInput2">City</label>
									<input type="text" id="eventRegInput2" class="form-control" placeholder="eg. Noida" name="city">
								</div>

								<div class="form-group">
									<label for="eventRegInput3">State</label>
									<input type="text" id="eventRegInput3" class="form-control" placeholder="State" name="state">
								</div>

								<div class="form-group">
									<label for="eventRegInput3">Country</label>
									<input type="text" id="eventRegInput3" class="form-control" placeholder="Country" name="country">
								</div>

								<div class="form-group">
									<label for="eventRegInput3">Pincode</label>
									<input type="text" id="eventRegInput3" class="form-control" placeholder="Pincode" name="pincode">
								</div>

								<div class="form-group">
									<label for="projectinput8">Description</label>
									<textarea id="projectinput8" rows="5" class="form-control" name="description" placeholder="Description"></textarea>
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
									<label for="eventRegInput5">Website</label>
									<input type="text" id="eventRegInput5" class="form-control" name="website" placeholder="Website" >
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
