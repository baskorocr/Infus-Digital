<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
</head>
<body class="z">

		<nav class="navbar navbar-expand-lg navbar-light bg-light">
		<div class="container">
			<a class="navbar-brand" href="#">Navbar</a>
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav me-auto mb-2 mb-lg-0">
				<li class="nav-item">
				<a class="nav-link active" aria-current="page" href="{{route('updates')}}">Update data</a>
				</li>
				
			</ul>
			<a class="btn btn-primary" href="{{route('login')}}" role="button">login</a>
			</div>
		</div>
		</nav>
    
			<div class="container mainDevice">

					<!-- Page Heading -->
					<div class="d-sm-flex align-items-center justify-content-between mb-4 p">
						<h1 class="h3 mb-0 ">Daftar Perangkat Terhubung</h1>
						<a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
								class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
					</div>
					
					
					<!-- Content Row -->
					@for($i = 0; $i < count($data); $i++)
						@if($data[$i]['status'] == 1)
						<div>
							<div>
								<h6>nama  : {{$data[$i]['nama']}} </h6>
								<h6>ruang : {{$data[$i]['ruang']}} </h6>
							</div>
							@for($p = count($value)-1; $p>=0; $p--)
							@if($value[$p]['idPasien'] == $data[$i]['id'])
							<div class="row mt-2">
							
							<!-- Earnings (Monthly) Card Example -->
							<div class="col-xl-3 col-md-6 mb-4">
								<div class="card border-left-success shadow h-100 py-2">
									<div class="card-body">
										<div class="row no-gutters align-items-center">
											<div class="col mr-2">
												<div class="text-xs font-weight-bold text-success text-uppercase mb-1">
													TPM</div>
												<div class="h5 mb-0 font-weight-bold text-gray-800">{{$value[$p]['tpm']}}</div>
											</div>
											<div class="col-auto">
												<i class="fas fa-thumbtack fa-2x text-gray-300"></i>
											</div>
										</div>
									</div>
								</div>
							</div>

							<!-- Earnings (Monthly) Card Example -->
							<div class="col-xl-3 col-md-6 mb-4">
								<div class="card border-left-info shadow h-100 py-2">
									<div class="card-body">
										<div class="row no-gutters align-items-center">
											<div class="col mr-2">
												<div class="text-xs font-weight-bold text-info text-uppercase mb-1">Kapasitas
												</div>
												<div class="row no-gutters align-items-center">
													<div class="col-auto">
														<div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{$value[$p]['kapasitas']}} ML</div>
													</div>
													
												</div>
											</div>
											<div class="col-auto">
												<i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
											</div>
										</div>
									</div>
								</div>
							</div>

							<!-- Pending Requests Card Example -->
							<div class="col-xl-3 col-md-6 mb-4">
								<div class="card border-left-warning shadow h-100 py-2">
									<div class="card-body">
										<div class="row no-gutters align-items-center">
											<div class="col mr-2">
												<div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
													Prediksi</div>
												<div class="h5 mb-0 font-weight-bold text-gray-800">{{$value[$p]['prediksi']}} Jam</div>
											</div>
											<div class="col-auto">
												<i class="fas fa-clock fa-2x text-gray-300"></i>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
								@break
							@endif
							@endfor
							
						</div>
						@else
							
						@endif
					@endfor
					
					


			</div>

			<!-- Bootstrap core JavaScript-->
			<script src="vendor/jquery/jquery.min.js"></script>
            <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

            <!-- Core plugin JavaScript-->
            <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

            <!-- Custom scripts for all pages-->
            <script src="js/sb-admin-2.min.js"></script>

            <!-- Page level plugins -->
            <script src="vendor/chart.js/Chart.min.js"></script>

            <!-- Page level custom scripts -->
            <script src="js/demo/chart-area-demo.js"></script>
            <script src="js/demo/chart-pie-demo.js"></script>
</body>
</html>