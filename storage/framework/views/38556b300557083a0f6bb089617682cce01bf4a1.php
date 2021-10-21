<html>
    <head>
		<?php session_start(); ?>
        <title>Tyson Showroom | SleePare</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
        <link href="images/favicon.png" rel="shortcut icon">
        <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600,700,800,900" rel="stylesheet">       
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i" rel="stylesheet">
        <link href="<?php echo e(asset('css/bootstrap.css'), false); ?>" rel="stylesheet" type="text/css">
        <link href="<?php echo e(asset('css/style.css'), false); ?>" rel="stylesheet" type="text/css">
        <link href="<?php echo e(asset('css/contextLoader.min.css'), false); ?>" rel="stylesheet" type="text/css">
        <meta name="csrf-token" content="<?php echo e(csrf_token(), false); ?>">
        <link href="http://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
        <link href="<?php echo e(asset('css/font-awesome.css'), false); ?>" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <script src="<?php echo e(asset('js/jquery.min.js'), false); ?>"></script>
		<script src="<?php echo e(asset('js/tether.min.js'), false); ?>"  crossorigin="anonymous"></script>
        <script src="<?php echo e(asset('js/bootstrap.min.js'), false); ?>"  crossorigin="anonymous"></script>
		<script type="text/javascript" src="<?php echo e(asset('js/contextLoader.min.js'), false); ?>"></script>
		<script src="<?php echo e(asset('js/gijgo.min.js'), false); ?>" type="text/javascript"></script>
    	<link href="<?php echo e(asset('css/gijgo.min.css'), false); ?>" rel="stylesheet" type="text/css" />
        <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>;
$.ajaxSetup({
headers: {
'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
}
});
        </script>
		<style>
			.contact-form input, .contact-form textarea {
				padding: 5px 10px !important;
				height: 45px !important;
				margin-bottom: 20px !important;
			}
        </style>
	</head>
	<body>
		<header>
			<div class="container header">
				<div class="row">
					<div class="col-lg-8 mt-4">
						<nav class="navbar navbar-expand-md navbar-dark">
							<div class="collapse navbar-collapse" id="navbarsExampleDefault">
								<?php echo $top_menu->asUl(array('class' => 'navbar-nav mr-auto')); ?>

							</div>
						</nav>
					</div>
					<a href="https://tyson.sleepare.com/" id="logo">SleepAre</a>
				</div>
			</div>
		</header>

		<div class="store-tab storeProducts">
			<div class="store-prod-companies container">
				<div class="row text-center">
					
					<?php $__currentLoopData = $brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<div class="col">
							<div class="store-single-product d-table">                                    
								<div class="store-single-prod-wrapper d-table-cell align-middle text-center">
									<a href="javascript:;" class="product-btn <?php echo e($brand->css_class, false); ?>" data-name="<?php echo e($brand->name, false); ?>">
										<img class="img-fluid" src="<?php echo e($brand->image, false); ?>" alt="<?php echo e($brand->name, false); ?>" title="<?php echo e($brand->name, false); ?>" />
									</a>
								</div>
							</div>
						</div>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

				</div>
			</div>
		</div>
		<!------- Store Tab Form ------->
		<div class="store-tab storeFrm">
			<div class="row form-section" style="padding-top: 30px;">
				<div class="container">
					<div class="contact-form">                              
						<form method="" class="contact-form">
							<div class="row">
								<div class="col-sm-6">
									<div class="col-md-12 col-sm-12">
										<label>Name</label><br />
										<input name="name" id="nameCust" type="text" />
									</div>
									<div class="col-md-12 col-sm-12">
										<label>Email</label><br />
										<input name="email" id="emailCust" type="email" />
									</div>
									<div class="col-md-12 col-sm-12">
										<label>Number</label><br />
										<input name="number" id="numCust" type="text" />
									</div>
									<div class="col-md-12 col-sm-12">
										<label>How did you find us? <span style="font-size: 11px;">(If you used Google, which keyword you searched for)</span></label><br />
										<input name="keyword" id="keyCust" type="text" />
									</div>
									<!-- <div class="col-md-12 col-sm-12">
										<label>Want to purchase on</label><br />
										<input name="date" id="purDate" class="datepicker" type="text" />
									</div> -->
									<div class="col-md-12 col-sm-12">
										<div class="form-btn-block">
											<button type="submit" id="btnSubmit" class="submit-btn">Submit</button>
											<!-- <a href="javascript:;" class="submit-btn purcahse-btn" id="purchaseBtn">Purchase</a> -->
										</div>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="col-md-12 col-sm-12">
										<label>Comments</label><br />
										<textarea name="comments" id="commentsCust" rows="30" cols="50"></textarea>
										<!-- <a href="javascript:;" data-rel="genero" class="submit-btn btnGray btnLogin btnEmp">Genero</a> -->
										<a href="javascript:;" data-rel="dustin" class="submit-btn btnGray btnLogin btnEmp">Dustin</a>
										<a href="javascript:;" data-rel="Arlette" class="submit-btn btnGray btnLogin btnEmp">Arlette</a>
										<a href="javascript:;" data-rel="Tanner" class="submit-btn btnGray btnLogin btnEmp">Tanner</a>
									</div>  
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<!------- Store Tab Form ------->
        <!-- Product Popup Box -->
		<div class="modal product-model" id="myModal">
			<div class="col-md-12 product-popup">
				<div class="modal-content panel panel-default">
					<div class="modal-header panel-heading"><button type="button" class="close close-popup" data-dismiss="modal">&times;</button></div>
					<div class="panel-body">
						<div class="row">
							<div class="col-md-12">
								<div id="popup">
									<div class="pane" id="popup-content">
										<div class="btnsSec" style="display:none;">
											<div class="product-item"><p>Selected Products</p></div>
											<div class="product-itemSub"></div>
											<a href="javascript:;" class="addAnother submit-btn">Add another product</a>
											<a href="javascript:;" class="nextStep submit-btn">Next</a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div> <!-- / Cancel Popup Box ends here -->
		<div class="modal" id="myModalCustomer">
			<div class="col-md-12">
				<div class="modal-content panel panel-default">
					<div class="modal-header panel-heading"><button type="button" class="close close-popup" data-dismiss="modal">&times;</button></div>
					<div class="panel-body">
						<section class="gray-section">
							<div class="container">
								<div class="row">
									<div class="gray-top-head text-center col-lg-12 "><h2>Would you like to learn more about the mattress you just picked?</h2></div>
								</div>
								<div class="row mt-4 mb-4">
									<div class="gray-box col-lg-2 col-md-3 col-xs-6">
										<a data-name="Comfort Rating" data-name="" href="javascript:;" class="custLike"><div class="gray-box-wrapper">
											<div class="box-img d-table"><div class="d-table-cell align-middle text-center"><img src="https://res.cloudinary.com/dspvkz45d/image/upload/v1570890998/box-icon1.png" class="img-fluid" /></div></div>
											<div class="box-title text-center">Comfort Rating</div>
										</div></a>
									</div>
									<div class="gray-box col-lg-2 col-md-3 col-xs-6">
										<a data-name="Shipping" href="javascript:;" class="custLike"><div class="gray-box-wrapper">
											<div class="box-img d-table"><div class="d-table-cell align-middle text-center"><img src="https://res.cloudinary.com/dspvkz45d/image/upload/v1570890998/box-icon2.png" class="img-fluid" /></div></div>
											<div class="box-title text-center">Shipping</div>
										</div></a>
									</div>
									<div class="gray-box col-lg-2 col-md-3 col-xs-6">
										<a data-name="Durability" href="javascript:;" class="custLike"><div class="gray-box-wrapper">
											<div class="box-img d-table"><div class="d-table-cell align-middle text-center"><img src="https://res.cloudinary.com/dspvkz45d/image/upload/v1570890998/box-icon3.png" class="img-fluid" /></div></div>
											<div class="box-title text-center">Durability</div>
										</div></a>
									</div>
									<div class="gray-box col-lg-2 col-md-3 col-xs-6">
										<a data-name="Material Quality" href="javascript:;" class="custLike"><div class="gray-box-wrapper">
											<div class="box-img d-table"><div class="d-table-cell align-middle text-center"><img src="https://res.cloudinary.com/dspvkz45d/image/upload/v1570890998/box-icon4.png" class="img-fluid" /></div></div>
											<div class="box-title text-center">Material Quality</div>
										</div></a>
									</div>
									<div class="gray-box col-lg-2 col-md-3 col-xs-6">
										<a data-name="Temprature Regulation" href="javascript:;" class="custLike"><div class="gray-box-wrapper">
											<div class="box-img d-table"><div class="d-table-cell align-middle text-center"><img src="https://res.cloudinary.com/dspvkz45d/image/upload/v1570890998/box-icon5.png" class="img-fluid" /></div></div>
											<div class="box-title text-center">Temprature Regulation</div>
										</div></a>
									</div>
									<div class="gray-box col-lg-2 col-md-3 col-xs-6">
										<a data-name="Customer Service" href="javascript:;" class="custLike"><div class="gray-box-wrapper">
											<div class="box-img d-table"><div class="d-table-cell align-middle text-center"><img src="https://res.cloudinary.com/dspvkz45d/image/upload/v1570890998/box-icon6.png" class="img-fluid" /></div></div>
											<div class="box-title text-center">Customer Service</div>
										</div></a>
									</div>
									<div class="gray-box col-lg-2 col-md-3 col-xs-6">
										<a data-name="Off Gassing" href="javascript:;" class="custLike"><div class="gray-box-wrapper">
											<div class="box-img d-table"><div class="d-table-cell align-middle text-center"><img src="https://res.cloudinary.com/dspvkz45d/image/upload/v1570890998/box-icon7.png" class="img-fluid" /></div></div>
											<div class="box-title text-center">Off Gassing</div>
										</div></a>
									</div>
									<div class="gray-box col-lg-2 col-md-3 col-xs-6">
										<a data-name="Side Sleeping" href="javascript:;" class="custLike"><div class="gray-box-wrapper">
											<div class="box-img d-table"><div class="d-table-cell align-middle text-center"><img src="https://res.cloudinary.com/dspvkz45d/image/upload/v1570890998/box-icon8.png" class="img-fluid" /></div></div>
											<div class="box-title text-center">Side Sleeping</div>
										</div></a>
									</div>
									<div class="gray-box col-lg-2 col-md-3 col-xs-6">
										<a data-name="Neck Pain" href="javascript:;" class="custLike"><div class="gray-box-wrapper">
											<div class="box-img d-table"><div class="d-table-cell align-middle text-center"><img src="https://res.cloudinary.com/dspvkz45d/image/upload/v1570890998/box-icon9.png" class="img-fluid" /></div></div>
											<div class="box-title text-center">Neck Pain</div>
										</div></a>
									</div>
									<div class="gray-box col-lg-2 col-md-3 col-xs-6">
										<a data-name="Joint Relief" href="javascript:;" class="custLike"><div class="gray-box-wrapper">
											<div class="box-img d-table"><div class="d-table-cell align-middle text-center"><img src="https://res.cloudinary.com/dspvkz45d/image/upload/v1570890998/box-icon10.png" class="img-fluid" /></div></div>
											<div class="box-title text-center">Joint Relief</div>
										</div></a>
									</div>
									<div class="gray-box col-lg-2 col-md-3 col-xs-6">
										<a data-name="Back Pain Relief" href="javascript:;" class="custLike"><div class="gray-box-wrapper">
											<div class="box-img d-table"><div class="d-table-cell align-middle text-center"><img src="https://res.cloudinary.com/dspvkz45d/image/upload/v1570890998/box-icon11.png" class="img-fluid" /></div></div>
											<div class="box-title text-center">Back Pain Relief</div>
										</div></a>
									</div>
									<div class="gray-box col-lg-2 col-md-3 col-xs-6">
										<a data-name="Value" href="javascript:;" class="custLike"><div class="gray-box-wrapper">
											<div class="box-img d-table"><div class="d-table-cell align-middle text-center"><img src="https://res.cloudinary.com/dspvkz45d/image/upload/v1570890998/box-icon12.png" class="img-fluid" /></div></div>
											<div class="box-title text-center">Value</div>
										</div></a>
									</div>
									<div class="gray-box col-lg-2 col-md-3 col-xs-6">
										<a data-name="Fast Break-in Period" href="javascript:;" class="custLike"><div class="gray-box-wrapper">
											<div class="box-img d-table"><div class="d-table-cell align-middle text-center"><img src="https://res.cloudinary.com/dspvkz45d/image/upload/v1570890998/box-icon13.png" class="img-fluid" /></div></div>
											<div class="box-title text-center">Fast Break-in Period</div>
										</div></a>
									</div>
									<div class="gray-box col-lg-2 col-md-3 col-xs-6">
										<a data-name="Premature Sagging" href="javascript:;" class="custLike"><div class="gray-box-wrapper">
											<div class="box-img d-table"><div class="d-table-cell align-middle text-center"><img src="https://res.cloudinary.com/dspvkz45d/image/upload/v1570890998/box-icon14.png" class="img-fluid" /></div></div>
											<div class="box-title text-center">Premature Sagging</div>
										</div></a>
									</div>
									<div class="gray-box col-lg-2 col-md-3 col-xs-6">
										<a data-name="Motion Isolation" href="javascript:;" class="custLike"><div class="gray-box-wrapper">
											<div class="box-img d-table"><div class="d-table-cell align-middle text-center"><img src="https://res.cloudinary.com/dspvkz45d/image/upload/v1570890998/box-icon15.png" class="img-fluid" /></div></div>
											<div class="box-title text-center">Motion Isolation</div>
										</div></a>
									</div>
									<div class="gray-box col-lg-2 col-md-3 col-xs-6">
										<a data-name="Frame" href="javascript:;" class="custLike"><div class="gray-box-wrapper">
											<div class="box-img d-table"><div class="d-table-cell align-middle text-center"><img src="https://res.cloudinary.com/dspvkz45d/image/upload/v1570890998/box-icon16.png" class="img-fluid" /></div></div>
											<div class="box-title text-center">Frame</div>
										</div></a>
									</div>
									<div class="gray-box col-lg-2 col-md-3 col-xs-6">
										<a data-name="Shoulder Support" href="javascript:;" class="custLike"><div class="gray-box-wrapper">
											<div class="box-img d-table"><div class="d-table-cell align-middle text-center"><img src="https://res.cloudinary.com/dspvkz45d/image/upload/v1570890998/box-icon17.png" class="img-fluid" /></div></div>
											<div class="box-title text-center">Shoulder Support</div>
										</div></a>
									</div>
									<div class="gray-box col-lg-2 col-md-3 col-xs-6">
										<a data-name="Support" href="javascript:;" class="custLike"><div class="gray-box-wrapper">
											<div class="box-img d-table"><div class="d-table-cell align-middle text-center"><img src="https://res.cloudinary.com/dspvkz45d/image/upload/v1570890998/box-icon18.png" class="img-fluid" /></div></div>
											<div class="box-title text-center">Support</div>
										</div></a>
									</div>
								</div>
								<div class="mt-5 text-center">
									<a href="javascript:;" class="skip-btn career-apply-btn">Skip</a>
									<a href="javascript:;" style="display:none;" class="skip-btn career-apply-btn custLikeNext">Next</a>
								</div>
							</div>
						</section>
					</div>
				</div>
			</div>
		</div>
		<form id="sheetFrm" action="https://boston.sleepare.com/google-sheet.php" method="post" class="contact-form" style="display:none;">
			<input type="hidden" name="from" id="fromEmail">
			<input type="hidden" name="to" id="toEmailUser">
			<input type="hidden" name="message_email" id="messageTxt">
 			<input type="hidden" name="name_user" id="nameTxt">
        </form>
		<script type="text/javascript">
			$('.datepicker').datepicker({
				uiLibrary: 'bootstrap4'
			});
			$(document).ready(function() {
				$(document).off('click', '.product-btn').on('click', '.product-btn', function(){
					$('#myModal').modal('show');
					$('.modal-backdrop').remove();
					$('.btnsSec').show();
					var prodName	= $(this).attr('data-name');
					$('.btnsSec .product-itemSub').append('<div class="product-item" data-name="'+prodName+'"><p>'+prodName+'</p></div>');
				});
				
				$(document).off('click', '.addAnother').on('click', '.addAnother', function(){
					$('#myModal').modal('hide');
					return false;
				});
				$(document).off('click', '.nextStep').on('click', '.nextStep', function(){
					$('#myModal').modal('hide');
					$('#myModalCustomer').modal('show');
					$('.modal-backdrop').remove();
					$('.storeProducts').hide();
					$('.storeForm').show();
					return false;
				});
				$(document).off('click', '.custLike').on('click', '.custLike', function(){
					$('.custLikeNext').show();
					var myVal = $('#popUpImg').val();
					if($(this).hasClass('active')){
						$(this).removeClass('active');
						//alert(myVal);
						var newVal = myVal.replace($(this).attr('data-name')+', ', '');
						newVal = myVal.replace(', '+$(this).attr('data-name'), '');
						newVal = myVal.replace($(this).attr('data-name'), '');
						$('#popUpImg').val(newVal);
						return false;
					}else{
						$(this).addClass('active');
						if(myVal != '')
							$('#popUpImg').val(myVal+', '+$(this).attr('data-name'));
						else
							$('#popUpImg').val($(this).attr('data-name'));
					}
					return false;
				});
				$(document).off('click', '.custLikeNext').on('click', '.custLikeNext', function(){
					$('#myModalCustomer').modal('hide');
					$('.modal-backdrop').remove();
					return false;
				});
				$(document).off('click', '.skip-btn').on('click', '.skip-btn', function(){
					$('#myModalCustomer').modal('hide');
					$('.modal-backdrop').remove();
					return false;
				});
				$(document).off('click', '.btnEmp').on('click', '.btnEmp', function(){
					$('.btnEmp').removeClass('btnRed');
					$(this).addClass('btnRed');
					return false;
				});
				$(document).off('click', '#btnSubmit').on('click', '#btnSubmit', function(event){
					event.preventDefault();
					if($('#nameCust').val() === ""){
						alert('Please insert Name');
						return false;
					}
					if($('#keyCust').val() === ""){
						alert('Please insert How did you find us');
						return false;
					}
					var sEmail = $('#emailCust').val();
					if (sEmail === "") {
						alert('Please enter valid email address');
						return false;
					}
					if (validateEmail(sEmail)) {
						var myDivs	= $('.btnsSec .product-itemSub .product-item').length;
						dataArr		= [];
						$('.btnsSec .product-itemSub .product-item').each(function() {
							dataArr.push({
								prodname: $(this).attr('data-name'),
							});
						});
						$("#fromEmail").val($('.btnRed').attr('data-rel'));
						$("#toEmailUser").val($('#emailCust').val());
						$("#nameTxt").val($('#nameCust').val());
						$("#messageTxt").val(JSON.stringify(dataArr));
						$.ajax({
							type		: 'POST',
							url			: '/sendmail',
							data 		: {prodData:dataArr, custname: $('#nameCust').val(), custemail:$('#emailCust').val(), custphone: $('#numCust').val(), custcom: $('#commentsCust').val(), keyword: $('#keyCust').val(), empID: $('.btnRed').attr('data-rel'), custLike: $('#popUpImg').val()},
							beforeSend	: function() {
								contextLoader.addLoader('.storeFrm');
								//return false;
							},
							success		: function(data) {
								console.log(data);
								if(data === "Submit Sheet"){
									$('#sheetFrm').submit();
								}else
									$('.storeFrm').html(data);
								return false;
							},
						});
						return false;
					}
					else {
						alert('Invalid Email Address');
						e.preventDefault();
						return false;
					}
				});
				$(document).off('click', '#purchaseBtn').on('click', '#purchaseBtn', function(){
					if($('#nameCust').val() === ""){
						alert('Please insert Name');
						return false;
					}
					if($('#keyCust').val() === ""){
						alert('Please insert How did you find us');
						return false;
					}
					var sEmail = $('#emailCust').val();
					if (sEmail === "") {
						alert('Please enter valid email address');
						return false;
					}
					if (validateEmail(sEmail)) {
						var myDivs	= $('.btnsSec .product-itemSub .product-item').length;
						urlArr		= [];
						dataArr		= [];
						$('.urlComp').each(function() {
							urlArr.push($(this).val());
						});
						$('.btnsSec .product-itemSub .product-item').each(function() {
							dataArr.push({
								discamount: $(this).attr('rel'),
								disccode: $(this).attr('data-code'),
								produrl: $(this).attr('data-url'),
								prodorgurl: $(this).attr('data-urlorg'),
								prodname: $(this).attr('data-name'),
								prodsize: $(this).attr('data-size'),
								prodfirm: $(this).attr('data-firm')
							});
						});
						$("#fromEmail").val($('.btnRed').attr('data-rel'));
						$("#toEmailUser").val($('#emailCust').val());
						$("#nameTxt").val($('#nameCust').val());
						$("#messageTxt").val(JSON.stringify(dataArr));
						$.ajax({
							type		: 'POST',
							url			: '/purchase',
							data 		: {prodData:dataArr, compUrls:urlArr, custname: $('#nameCust').val(), custemail:$('#emailCust').val(), custphone: $('#numCust').val(), custcom: $('#commentsCust').val(), keyword: $('#keyCust').val(), empID: $('.btnRed').attr('data-rel')},
							beforeSend	: function() {
								contextLoader.addLoader('.storeFrm');
								//return false;
							},
							success		: function(data) {
							if (data.indexOf("https://") >= 0){
									window.location = data;
								}
								//console.log(data);
								if(data === "Submit Sheet"){
									$('#sheetFrm').submit();
								}
								return false;
							},
						});
						return false;
					}
					else {
						alert('Invalid Email Address');
						e.preventDefault();
						return false;
					}
				});
			});
			
			function validateEmail(sEmail) {
				var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
				if (filter.test(sEmail)) {
					return true;
				}
				else {
					return false;
				}
			}
		</script>
	</body>
</html>