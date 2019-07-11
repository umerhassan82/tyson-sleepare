<html>
    <head>
		<?php session_start(); ?>
        <title>Tyson Showroom | SleePare</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
        <link href="images/favicon.png" rel="shortcut icon">
        <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600,700,800,900" rel="stylesheet">       
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i" rel="stylesheet">
        <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('css/style.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('css/contextLoader.min.css') }}" rel="stylesheet" type="text/css">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link href="http://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
        <link href="{{ asset('css/font-awesome.css') }}" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <script src="{{ asset('js/jquery.min.js') }}"></script>
		<script src="{{ asset('js/tether.min.js') }}"  crossorigin="anonymous"></script>
        <script src="{{ asset('js/bootstrap.min.js') }}"  crossorigin="anonymous"></script>
		<script type="text/javascript" src="{{ asset('js/contextLoader.min.js') }}"></script>
		<script src="{{ asset('js/gijgo.min.js') }}" type="text/javascript"></script>
    	<link href="{{ asset('css/gijgo.min.css') }}" rel="stylesheet" type="text/css" />
        <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
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
					<a href="http://tyson.sleepare.com/" id="logo">SleepAre</a>
				</div>
			</div>
		</header>

		<div class="store-tab storeProducts">
			<div class="store-prod-companies container">
				<div class="row text-center">
					
					@foreach($brands as $brand)
						<div class="col">
							<div class="store-single-product d-table">                                    
								<div class="store-single-prod-wrapper d-table-cell align-middle text-center">
									<a href="javascript:;" class="product-btn {{ $brand->css_class }}">
										<img class="img-fluid" src="{{ $brand->image }}" alt="{{ $brand->name }}" title="{{ $brand->name }}" />
									</a>
								</div>
							</div>
						</div>
					@endforeach

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
									<div class="col-md-12 col-sm-12">
										<label>Want to purchase on</label><br />
										<input name="date" id="purDate" class="datepicker" type="text" />
									</div>
									<div class="col-md-12 col-sm-12">
										<div class="form-btn-block">
											<button type="submit" id="btnSubmit" class="submit-btn">Submit</button>
											<a href="javascript:;" class="submit-btn purcahse-btn" id="purchaseBtn">Purchase</a>
										</div>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="col-md-12 col-sm-12">
										<label>Comments</label><br />
										<textarea name="comments" id="commentsCust" rows="30" cols="50"></textarea>
										<a href="javascript:;" data-rel="Derrick" class="submit-btn btnGray btnLogin btnEmp">Derrick</a>
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

										@foreach($brands as $brand)
											<div class="{{ $brand->css_class }}s innerProds" style="display:none;">
												@foreach($brand->products as $product)
													<div class="product-item">
														@if(!empty($product->image))
															<img src="{{ $product->image }}" class="img-fluid pull-left" />
														@endif
														<p>{{ $product->name }}</p>
													</div>
													<div class="product-itemSub">
														
														@foreach($product->sizes as $size)
															<div class="product-item">
																@if(isset($size["name"]))
																	<a href="javascript:;" class="prodUrl {{ $product->css_class }}" data-code="{{ $size['code'] }}" data-name="{{ $product->name }}" data-disc="{{ $size['amount'] }}" data-url="{{ $product->slug }}" data-size="{{ $size['name'] }}" rel="{{ $product->affiliate_link }}">
																		<p>{{ $size["name"] }}</p>
																	</a>
																@endif
															</div>
														@endforeach
													</div>
												@endforeach
											</div>
										@endforeach
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
		<div class="modal firmness-model" id="myModalFirm">
			<div class="col-md-12 product-popup">
				<div class="modal-content panel panel-default">
					<div class="modal-header panel-heading"><button type="button" class="close close-popup" data-dismiss="modal">&times;</button></div>
					<div class="panel-body">
						<div class="row">
							<div class="col-md-12">
								<div id="popup">
									<div class="pane" id="popup-content">
										<div class="saatvaFrims innerProdsFirm" style="display:none;">
											<div class="product-item"><a href="javascript:;" data-ref="saatva" class="firmUrl" rel="Plush Soft"><p>Plush Soft</p></a></div>
											<div class="product-item"><a href="javascript:;" data-ref="saatva" class="firmUrl" rel="Luxury Firm"><p>Luxury Firm</p></a></div>
											<div class="product-item"><a href="javascript:;" data-ref="saatva" class="firmUrl" rel="Firm"><p>Firm</p></a></div>
										</div>
										<div class="loomFirms innerProdsFirm" style="display:none;">
											<div class="product-item"><a href="javascript:;" data-ref="loom-leaf" class="firmUrl" rel="Relaxed Firm"><p>Relaxed Firm</p></a></div>
											<div class="product-item"><a href="javascript:;" data-ref="loom-leaf" class="firmUrl" rel="Firm"><p>Firm</p></a></div>
										</div>
										<div class="winkFirms innerProdsFirm" style="display:none;">
											<div class="product-item"><a href="javascript:;" data-ref="winkbeds" class="firmUrl" rel="Softer"><p>Softer</p></a></div>
											<div class="product-item"><a href="javascript:;" data-ref="winkbeds" class="firmUrl" rel="Luxury Firm"><p>Luxury Firm</p></a></div>
											<div class="product-item"><a href="javascript:;" data-ref="winkbeds" class="firmUrl" rel="Firmer"><p>Firmer</p></a></div>
											<div class="product-item"><a href="javascript:;" data-ref="winkbeds" class="firmUrl" rel="Plus"><p>Plus</p></a></div>
											<div class="product-item"><a href="javascript:;" data-ref="winkbeds" class="firmUrl" rel="Extra Firm"><p>Extra Firm</p></a></div>
										</div>
										<div class="museFirms innerProdsFirm" style="display:none;">
											<div class="product-item"><a href="javascript:;" data-ref="muse" class="firmUrl" rel="Soft"><p>Soft</p></a></div>
											<div class="product-item"><a href="javascript:;" data-ref="muse" class="firmUrl" rel="Medium"><p>Medium</p></a></div>
											<div class="product-item"><a href="javascript:;" data-ref="muse" class="firmUrl" rel="Firm"><p>Firm</p></a></div>
										</div>
										<div class="tomorrowFirms innerProdsFirm" style="display:none;">
											<div class="product-item"><a href="javascript:;" data-ref="tomorrow-hybrid" class="firmUrl" rel="Medium-Firm"><p>Medium-Firm</p></a></div>
										</div>
										<div class="nestHybridFirms innerProdsFirm" style="display:none;">
											<div class="product-item"><a href="javascript:;" data-ref="nest-bedding-hybrid-latex" class="firmUrl" rel="Medium"><p>Medium</p></a></div>
										</div>
										<div class="nestSigFirms innerProdsFirm" style="display:none;">
											<div class="product-item"><a href="javascript:;" data-ref="nest-bedding-alexander-hybrid" class="firmUrl" rel="Medium"><p>Medium</p></a></div>
										</div>
										<div class="brookAurFirms innerProdsFirm" style="display:none;">
											<div class="product-item"><a href="javascript:;" data-ref="brooklyn-bedding-aurora" class="firmUrl" rel="Soft"><p>Soft</p></a></div>
											<div class="product-item"><a href="javascript:;" data-ref="brooklyn-bedding-aurora" class="firmUrl" rel="Medium"><p>Medium</p></a></div>
											<div class="product-item"><a href="javascript:;" data-ref="brooklyn-bedding-aurora" class="firmUrl" rel="Firm"><p>Firm</p></a></div>
										</div>
										<div class="brookSigFirms innerProdsFirm" style="display:none;">
											<div class="product-item"><a href="javascript:;" data-ref="brooklyn-bedding-signature-hybrid" class="firmUrl" rel="Soft"><p>Soft</p></a></div>
											<div class="product-item"><a href="javascript:;" data-ref="brooklyn-bedding-signature-hybrid" class="firmUrl" rel="Medium"><p>Medium</p></a></div>
											<div class="product-item"><a href="javascript:;" data-ref="brooklyn-bedding-signature-hybrid" class="firmUrl" rel="Firm"><p>Firm</p></a></div>
										</div>
										<div class="brookblFirms innerProdsFirm" style="display:none;">
											<div class="product-item"><a href="javascript:;" data-ref="brooklyn-bedding-bloom-hybrid" class="firmUrl" rel="Soft"><p>Soft</p></a></div>
											<div class="product-item"><a href="javascript:;" data-ref="brooklyn-bedding-bloom-hybrid" class="firmUrl" rel="Medium"><p>Medium</p></a></div>
											<div class="product-item"><a href="javascript:;" data-ref="brooklyn-bedding-bloom-hybrid" class="firmUrl" rel="Firm"><p>Firm</p></a></div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div> <!-- / Cancel Popup Box ends here -->
		<form id="sheetFrm" action="http://newyork.sleepare.com/google-sheet.php" method="post" class="contact-form" style="display:none;">
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
					$('.innerProds').hide();
					$('.btnsSec').hide();
					if($(this).hasClass('saatvaProd')){
						$('.saatvaProds').show();
						return false;
					}
					if($(this).hasClass('purpleProd')){
						$('.purpleProds').show();
						return false;
					}
					if($(this).hasClass('casperProd')){
						$('.casperProds').show();
						return false;
					}
					if($(this).hasClass('leesaProd')){
						$('.leesaProds').show();
						return false;
					}
					if($(this).hasClass('laylaProd')){
						$('.laylaProds').show();
						return false;
					}
					if($(this).hasClass('dreamProd')){
						$('.dreamProds').show();
						return false;
					}
					if($(this).hasClass('awaraProd')){
						$('.awaraProds').show();
						return false;
					}
					if($(this).hasClass('levelProd')){
						$('.levelProds').show();
						return false;
					}
					if($(this).hasClass('avocadProd')){
						$('.avocadProds').show();
						return false;
					}
					if($(this).hasClass('sapiraProd')){
						$('.sapiraProds').show();
						return false;
					}
					if($(this).hasClass('airProd')){
						$('.airProds').show();
						return false;
					}
					if($(this).hasClass('museProd')){
						$('.museProds').show();
						return false;
					}
					if($(this).hasClass('winkProd')){
						$('.winkProds').show();
						return false;
					}
					if($(this).hasClass('spindProd')){
						$('.spindProds').show();
						return false;
					}
					if($(this).hasClass('nectarProd')){
						$('.nectarProds').show();
						return false;
					}
					if($(this).hasClass('loomProd')){
						$('.loomProds').show();
						return false;
					}
					if($(this).hasClass('tomorrowProd')){
						$('.tomorrowProds').show();
						return false;
					}
					if($(this).hasClass('puffyProd')){
						$('.puffyProds').show();
						return false;
					}
					if($(this).hasClass('zenProd')){
						$('.zenProds').show();
						return false;
					}
					if($(this).hasClass('nestBeddingProd')){
						$('.nestBeddingProds').show();
						return false;
					}
					if($(this).hasClass('brookProd')){
						$('.brookProds').show();
						return false;
					}
					if($(this).hasClass('helixProd')){
						$('.helixProds').show();
						return false;
					}
					if($(this).hasClass('ecosaProd')){
						$('.ecosaProds').show();
						return false;
					}
					if($(this).hasClass('bearProd')){
						$('.bearProds').show();
						return false;
					}
					if($(this).hasClass('casperProd')){
						$('.casperProds').show();
						return false;
					}
					if($(this).hasClass('bigfigProd')){
						$('.bigfigProds').show();
						return false;
					}
					if($(this).hasClass('brentProd')){
						$('.brentProds').show();
						return false;
					}
					if($(this).hasClass('luftProd')){
						$('.luftProds').show();
						return false;
					}
				});
				$(document).off('click', '.prodUrl').on('click', '.prodUrl', function(){
					var prodName	= $(this).attr('data-name');
					var prodSize	= $(this).attr('data-size');
					var prodUrl		= $(this).attr('rel');
					var urlProd		= $(this).attr('data-url');
					var prodDisc	= $(this).attr('data-disc');
					var discCode	= $(this).attr('data-code');
					$('.btnsSec .product-itemSub').append('<div class="product-item '+urlProd+'" rel="'+prodDisc+'" data-code="'+discCode+'" data-url="'+prodUrl+'" data-name="'+prodName+'" data-size="'+prodSize+'" data-urlorg="'+urlProd+'"><p>'+prodName+' ('+prodSize+')</p></div>');
					$('.btnsSec .product-itemSub').append('<input type="hidden" name="" class="urlComp" value="'+urlProd+'">');
					$('.innerProds').hide();
					$('.btnsSec').show();
					if($(this).hasClass('firmBtn'))
					{
						$('#myModalFirm').modal('show');
						$('.modal-backdrop').remove();
						$('.innerProdsFirm').hide();
						if($(this).hasClass('saatvaFrim')){
							$('.saatvaFrims').show();
							return false;
						}
						if($(this).hasClass('loomFirm')){
							$('.loomFirms').show();
							return false;
						}
						if($(this).hasClass('winkFirm')){
							$('.winkFirms').show();
							return false;
						}
						if($(this).hasClass('museFirm')){
							$('.museFirms').show();
							return false;
						}
						if($(this).hasClass('tomorrowFirm')){
							$('.tomorrowFirms').show();
							return false;
						}
						if($(this).hasClass('nestHybridFirm')){
							$('.nestHybridFirms').show();
							return false;
						}
						if($(this).hasClass('nestSigFirm')){
							$('.nestSigFirms').show();
							return false;
						}
						if($(this).hasClass('brookAurFirm')){
							$('.brookAurFirms').show();
							return false;
						}
						if($(this).hasClass('brookSigFirm')){
							$('.brookSigFirms').show();
							return false;
						}
						if($(this).hasClass('brookblFirm')){
							$('.brookblFirms').show();
							return false;
						}
					}
					return false;
				});
				$(document).off('click', '.firmUrl').on('click', '.firmUrl', function(){
					$('#myModalFirm').modal('hide');
					var myClass = $(this).attr('data-ref');
					$('.btnsSec .product-itemSub .'+myClass).attr('data-firm', $(this).attr('rel'));
					$('.btnsSec .product-itemSub .'+myClass+' p').append('('+$(this).attr('rel')+')');
					return false;
				});
				$(document).off('click', '.addAnother').on('click', '.addAnother', function(){
					$('#myModal').modal('hide');
					return false;
				});
				$(document).off('click', '.nextStep').on('click', '.nextStep', function(){
					$('#myModal').modal('hide');
					$('.storeProducts').hide();
					$('.storeForm').show();
					return false;
				});
				$(document).off('click', '.btnEmp').on('click', '.btnEmp', function(){
					$('.btnEmp').removeClass('btnRed');
					$(this).addClass('btnRed');
					return false;
				});
				$(document).off('click', '#btnSubmit').on('click', '#btnSubmit', function(){
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
							url			: '/checkmail',
							data 		: {custemail:$('#emailCust').val()},
							beforeSend	: function() {
								//contextLoader.addLoader('.storeFrm');
								//return false;
							},
							success		: function(data) {
								if(data === "Bad"){
									$('#emailCust').after('<p style="color:red; font-style:italic;">Invalid Email Address</p>');
									return false;
								}else{
									$.ajax({
										type		: 'POST',
										url			: '/sendmail',
										data 		: {prodData:dataArr, compUrls:urlArr, custname: $('#nameCust').val(), custemail:$('#emailCust').val(), custphone: $('#numCust').val(), custcom: $('#commentsCust').val(), keyword: $('#keyCust').val(), empID: $('.btnRed').attr('data-rel'), purdate: $('#purDate').val()},
										beforeSend	: function() {
											contextLoader.addLoader('.storeFrm');
											//return false;
										},
										success		: function(data) {
											//console.log(data);
											if(data === "Submit Sheet"){
												$('#sheetFrm').submit();
											}else
												$('.storeFrm').html(data);
											return false;
										},
									});
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
							url			: '/checkmail',
							data 		: {custemail:$('#emailCust').val()},
							beforeSend	: function() {
								//contextLoader.addLoader('.storeFrm');
								//return false;
							},
							success		: function(data) {
								if(data === "Bad"){
									$('#emailCust').after('<p style="color:red; font-style:italic;">Invalid Email Address</p>');
									return false;
								}else{
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