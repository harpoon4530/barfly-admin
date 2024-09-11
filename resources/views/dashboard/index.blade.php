@extends('layouts.app')
@section('content')

<head>
    <link rel="stylesheet" href="{{ asset('assets/plugins/chartist/css/chartist.min.css') }}">
    <!-- Custom Stylesheet -->
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet"/>
    <script src="{{ asset('assets/js/modernizr-3.6.0.min.js') }}"></script>
</head>

<body class="v-light horizontal-nav">
    <div id="preloader">
        <div class="loader">
            <svg class="circular" viewBox="25 25 50 50"><circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="3" stroke-miterlimit="10"/></svg>
        </div>
    </div>
        <!-- content body -->
        <div class="content-body">
            <div class="container">
                            <div class="dp-ft btn-group m-b-10">
                                <button type="button" class="btn btn-primary">All Bars</button>
                                 <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown"></button>
                                 <div class="dropdown-menu">
                                     <a class="dropdown-item" href="#">Avenue</a> 
                                     <a class="dropdown-item" href="#">Magic Carpet</a> 
                                     <a class="dropdown-item" href="#">Cuba Libre</a>
                                 </div>
                            </div>                  
                <div class="row page-titles">
                    <div class="col p-0">
                        <h1>Dashboard</h1>
                        <h3>Quick Stats</h3>                        
                    </div>                  
                </div>                                 
               <div class="row">
                    <div class="col-lg-3">
                        <div class="card">
                            <div class="stat-widget-one">
                                <div class="stat-content">
                                    <div class="stat-text">Total Bars</div>
                                    <div class="stat-digit"><i class="fa fa-glass"></i> 30</div>
                                </div>
     <!--                            <div class="progress">
                                    <div class="progress-bar progress-bar-success w-30pc" role="progressbar" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                                </div> -->
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="card">
                            <div class="stat-widget-one">
                                <div class="stat-content">
                                    <div class="stat-text">Total Users</div>
                                    <div class="stat-digit"><i class="fa fa-users"></i> 7800</div>
                                </div>
<!--                                 <div class="progress">
                                    <div class="progress-bar progress-bar-primary w-75pc" role="progressbar" aria-valuenow="78" aria-valuemin="0" aria-valuemax="100"></div>
                                </div> -->
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="card">
                            <div class="stat-widget-one">
                                <div class="stat-content">
                                    <div class="stat-text">Total Order</div>
                                    <div class="stat-digit"><i class="fa fa-beer"></i> 500</div>
                                </div>
<!--                                 <div class="progress">
                                    <div class="progress-bar progress-bar-warning w-70pc" role="progressbar" aria-valuenow="500" aria-valuemin="0" aria-valuemax="600"></div>
                                </div> -->
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="card">
                            <div class="stat-widget-one">
                                <div class="stat-content">
                                    <div class="stat-text">Total Sales</div>
                                    <div class="stat-digit"><i class="fa fa-usd"></i> 3400</div>
                                </div>
<!--                                 <div class="progress">
                                    <div class="progress-bar progress-bar-pink w-40pc" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                </div> -->
                            </div>
                        </div>
                    </div>                    
                    <!-- /# column -->
                </div>                
                <!-- row -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h2>Sales</h2>
                                <div id="simple-line-chart" class="ct-chart ct-golden-section"></div>
                            </div>
                        </div>
                    </div>                    
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <h2>Top Bars</h2>
                                <div class="progress-content">
                                    <div class="title">
                                         <h5>Magic Carpet</h5>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-primary w-50pc" role="progressbar" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>    
                                    <div class="value">
                                         <h5>50%</h5>                                
                                    </div>  
                                </div> 
                               <div class="progress-content">
                                    <div class="title">
                                         <h5>Cuba Libre</h5>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-primary w-30pc" role="progressbar" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>    
                                    <div class="value">
                                         <h5>30%</h5>                                
                                    </div>  
                                </div>                                                   
                                <div class="progress-content">
                                    <div class="title">
                                         <h5>Loof Bar</h5>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-primary w-20pc" role="progressbar" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>    
                                    <div class="value">
                                         <h5>20%</h5>                                
                                    </div>  
                                </div>  
                                <div class="progress-content">
                                    <div class="title">
                                         <h5>Manhattan</h5>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-primary w-10pc" role="progressbar" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>    
                                    <div class="value">
                                         <h5>10%</h5>                                
                                    </div>  
                                </div>                                
                               <div class="progress-content">
                                    <div class="title">
                                         <h5>Bar Stories</h5>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-primary w-5pc" role="progressbar" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>    
                                    <div class="value">
                                         <h5>05%</h5>                                
                                    </div>  
                                </div>  
                               <div class="progress-content">
                                    <div class="title">
                                         <h5>Jigger & Pony</h5>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-primary w-5pc" role="progressbar" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>    
                                    <div class="value">
                                         <h5>05%</h5>                                
                                    </div>  
                                </div>                                                                                                                              
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="age-range card-body">
                                <h2>Age Range</h2>
                                <div class="progress-content">
                                    <div class="title">
                                         <h5>18-24</h5>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-primary w-20pc" role="progressbar" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>    
                                    <div class="value">
                                         <h5>15%</h5>                                
                                    </div>  
                                </div> 
                                <div class="progress-content">
                                    <div class="title">
                                         <h5>25-34</h5>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-primary w-25pc" role="progressbar" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>    
                                    <div class="value">
                                         <h5>25%</h5>                                
                                    </div>  
                                </div> 
                                <div class="progress-content">
                                    <div class="title">
                                         <h5>35-44</h5>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-primary w-15pc" role="progressbar" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>    
                                    <div class="value">
                                         <h5>15%</h5>                                
                                    </div>  
                                </div> 
                                <div class="progress-content">
                                    <div class="title">
                                         <h5>45-54</h5>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-primary w-10pc" role="progressbar" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>    
                                    <div class="value">
                                         <h5>10%</h5>                                
                                    </div>  
                                </div> 
                                <div class="progress-content">
                                    <div class="title">
                                         <h5>55-64</h5>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-primary w-5pc" role="progressbar" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>    
                                    <div class="value">
                                         <h5>05%</h5>                                
                                    </div>  
                                </div>                                                                                                                 
                                <div class="progress-content">
                                    <div class="title">
                                         <h5>65+</h5>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-primary w-0pc" role="progressbar" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>    
                                    <div class="value">
                                         <h5>0%</h5>                                
                                    </div>  
                                </div>                                                                                                                     
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <h2>Top Brands</h2>
                                <div class="progress-content">
                                    <div class="title">
                                         <h5>Absolut vodka</h5>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-primary w-50pc" role="progressbar" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>    
                                    <div class="value">
                                         <h5>50%</h5>                                
                                    </div>  
                                </div> 
                               <div class="progress-content">
                                    <div class="title">
                                         <h5>Johnnie Walker Blue Label</h5>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-primary w-30pc" role="progressbar" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>    
                                    <div class="value">
                                         <h5>30%</h5>                                
                                    </div>  
                                </div>                                                   
                                <div class="progress-content">
                                    <div class="title">
                                         <h5>Jack Daniel's</h5>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-primary w-20pc" role="progressbar" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>    
                                    <div class="value">
                                         <h5>20%</h5>                                
                                    </div>  
                                </div>  
                                <div class="progress-content">
                                    <div class="title">
                                         <h5>Bombay Sapphire Gin </h5>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-primary w-10pc" role="progressbar" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>    
                                    <div class="value">
                                         <h5>10%</h5>                                
                                    </div>  
                                </div>                                
                               <div class="progress-content">
                                    <div class="title">
                                         <h5>Bombay Bramble 1L</h5>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-primary w-5pc" role="progressbar" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>    
                                    <div class="value">
                                         <h5>05%</h5>                                
                                    </div>  
                                </div>                                                                                                                                
                            </div>
                        </div>
                    </div>
                   <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <h2>Top Categories (Age/Gender)</h2>
                                    <div class="cd-ft">
                                        <div class="dropdown custom-dropdown">
                                            <button type="button" class="btn btn-sm btn-outline-primary" data-toggle="dropdown">All <i class="fa fa-angle-down m-l-5"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right">
                                              <a class="dropdown-item" href="#">Male</a>
                                              <a class="dropdown-item" href="#">Female</a>
                                            </div>
                                        </div>
                                    </div>                                
                                <div class="progress-content">
                                    <div class="title">
                                         <h5>Whiskey</h5>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-primary w-50pc" role="progressbar" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>    
                                    <div class="value">
                                         <h5>21 - 25</h5>                                
                                    </div>  
                                </div> 
                               <div class="progress-content">
                                    <div class="title">
                                         <h5>Beer</h5>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-primary w-30pc" role="progressbar" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>    
                                    <div class="value">
                                         <h5>26 - 30</h5>                                
                                    </div>  
                                </div>                                                   
                                <div class="progress-content">
                                    <div class="title">
                                         <h5>Rum</h5>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-primary w-20pc" role="progressbar" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>    
                                    <div class="value">
                                         <h5>31 - 35</h5>                                
                                    </div>  
                                </div>  
                                <div class="progress-content">
                                    <div class="title">
                                         <h5>Gin </h5>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-primary w-10pc" role="progressbar" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>    
                                    <div class="value">
                                         <h5>36 - 40</h5>                                
                                    </div>  
                                </div>                                
                               <div class="progress-content">
                                    <div class="title">
                                         <h5>Champagne</h5>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-primary w-5pc" role="progressbar" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>    
                                    <div class="value">
                                         <h5>41 - 45</h5>                                
                                    </div>  
                                </div>                                                                                                                   
                            </div>
                        </div>
                    </div>
                </div>         
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <h2>Top Brands (Age/Gender)</h2>
                                    <div class="cd-ft">
                                        <div class="dropdown custom-dropdown">
                                            <button type="button" class="btn btn-sm btn-outline-primary" data-toggle="dropdown">All <i class="fa fa-angle-down m-l-5"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right">
                                              <a class="dropdown-item" href="#">Male</a>
                                              <a class="dropdown-item" href="#">Female</a>
                                            </div>
                                        </div>
                                    </div>
                               <div class="progress-content">
                                    <div class="title">
                                         <h5>Johnnie Walker Blue Label</h5>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-primary w-30pc" role="progressbar" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>    
                                    <div class="value">
                                        <h5>21 - 25</h5>                                          
                                    </div>  
                                </div>
                                <div class="progress-content">
                                    <div class="title">
                                         <h5>Absolut vodka</h5>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-primary w-50pc" role="progressbar" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>    
                                    <div class="value">
                                         <h5>26 - 30</h5>                           
                                    </div>  
                                </div>                                              
                                <div class="progress-content">
                                    <div class="title">
                                         <h5>Jack Daniel's</h5>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-primary w-20pc" role="progressbar" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>    
                                    <div class="value">
                                         <h5>31 - 35</h5>                              
                                    </div>  
                                </div>                               
                               <div class="progress-content">
                                    <div class="title">
                                         <h5>Bombay Bramble 1L</h5>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-primary w-5pc" role="progressbar" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>    
                                    <div class="value">
                                         <h5>36 - 40</h5>                                 
                                    </div>  
                                </div>                                                                                                                              
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <h2>Platforms</h2>
                                <div id="flotPie2" class="flot-chart"></div>
                            </div>
                        </div>
                    </div>
                </div>                                
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <h2>Gender</h2>
                                <div id="flotPie1" class="flot-chart"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <h2>User Sign Up Flow</h2>
                                 <div id="flotArea1" class="flot-chart"></div>
                            </div>
                        </div>
                    </div>                    
                </div> 
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div>
                                    <h2>Top Users</h2>
                                </div>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Name</th>
                                                <th>Total Order</th>
                                                <th>Age</th>
                                                <th>Total Spend</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th>1</th>
                                                <td>Jaren Hammer</td>
                                                <td>50</td>
                                                <td>34</td>
                                                <td class="color-primary">$400</td>
                                            </tr>
                                            <tr>
                                                <th>2</th>
                                                <td>Kianna Pham</td>
                                                <td>20</td>
                                                <td>22</td>
                                                <td class="color-primary">$300</td>
                                            </tr>
                                            <tr>
                                                <th>3</th>
                                                <td>Jakobe Snell</td>
                                                <td>13</td>
                                                <td>30</td>
                                                <td class="color-primary">$180</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>                    
                </div>                               
            </div>
            <!-- #/ container -->
        </div>
        <!-- #/ content body -->

    </div>
    <!-- Common JS -->
    {{-- <script src="assets/plugins/common/common.min.js"></script> --}}
    <!-- Custom script -->
    <script src="assets/js/custom.min.js"></script>
    <script src="assets/plugins/chartist/js/chartist.min.js"></script>
    <script src="assets/plugins/chartist/js/chartist-plugin-tooltip.min.js"></script>
    <script src="assets/plugins/chartist/js/chartist.init.js"></script>   
    <script src="assets/plugins/flot/js/jquery.flot.min.js"></script>
    <script src="assets/plugins/flot/js/jquery.flot.pie.js"></script>
    <script src="assets/plugins/flot/js/jquery.flot.init.js"></script>
</body>

@endsection
