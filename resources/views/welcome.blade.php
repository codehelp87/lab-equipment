<!DOCTYPE html>
<html>
    <head>
        <title>Scientist A medical Category Flat Bootstrap Responsive Website Template | Home :: w3layouts</title>
        <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet" type="text/css" media="all" />
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="{{ asset('js/jquery.min.js') }}"></script>
        <!-- Custom Theme files -->
        <!--theme-style-->
        <link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
        <!--//theme-style-->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="keywords" content="Scientist Responsive web template" />
        <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
    </head>
    <body>
        <!--header-->
        <div class="header">
            <div class="container">
                <div class="logo">
                    <h1><a href="{{ url('/login') }}">
                        Scientist
                    </a></h1>
                </div>
                <div class="top-nav">
                    <span class="menu"><img src="{{ asset('images/menu.png') }}" alt=""> </span>
                    <ul>
                        <li class="active"><a href="{{ url('/login') }}">Home</a></li>
                        @if (Route::has('login'))
                        
                        <li><a href="{{ url('/login') }}">Login</a></li>
                        <li><a href="{{ url('/register') }}">Register</a></li>
                        
                        @endif
                    </ul>
                    <div class="clearfix"> </div>
                    <!--script-->
                    <script>
                    $("span.menu").click(function(){
                        $(".top-nav ul").slideToggle(500, function() {

                        });
                    });
                    </script>
                </div>
                <div class="clearfix"> </div>
            </div>
            <!---->
        </div>
        <div class="content">
            <div class="container">
                <!--content-top-->
                <div class="content-top">
                    <div class="content-top1">
                        <div class=" col-md-4 grid-top">
                            <div class="top-grid">
                                <i class="glyphicon glyphicon-book"></i>
                                <div class="caption">
                                    <h3>Contrary to popular</h3>
                                    <p> Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45</p>
                                </div>
                            </div>
                        </div>
                        <div class=" col-md-4 grid-top">
                            <div class="top-grid top">
                                <i class="glyphicon glyphicon-time home1 "></i>
                                <div class="caption">
                                    <h3>It is a long established</h3>
                                    <p> Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45</p>
                                </div>
                            </div>
                        </div>
                        <div class=" col-md-4 grid-top">
                            <div class="top-grid">
                                <i class="glyphicon glyphicon-edit "></i>
                                <div class="caption">
                                    <h3>It is a long established</h3>
                                    <p> Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45</p>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"> </div>
                    </div>
                </div>
                <!--//content-top-->
                <!--cpntent-mid-->
                <div class="content-middle">
                    <div class="col-md-7 content-mid">
                        <a href="single.html"><img class="img-responsive" src="{{ asset('images/md.jpg') }}" alt=""></a>
                    </div>
                    <div class="col-md-5 content-mid1">
                        <i class="glyphicon glyphicon-filter"> </i>
                        <h2>Lorem Ipsum is not simply</h2>
                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries,
                        but also the leap into electronic typesetting, remaining essentially </p>
                        <a href="single.html"><i class="glyphicon glyphicon-circle-arrow-right"> </i></a>
                    </div>
                    <div class="clearfix"> </div>
                </div>
                <!--//content-mid-->
                <!--content-left-->
                <div class="content-left">
                    <div class="col-md-4 content-left-top">
                        <a href="single.html"><img class="img-responsive" src="{{ asset('images/md1.jpg') }}" alt=""></a>
                        <div class=" content-left-bottom">
                            <h4><i class="glyphicon glyphicon-ok"></i><a href="single.html">Lorem Ipsum is not simply</a></h4>
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy</p>
                        </div>
                    </div>
                    <div class="col-md-4 content-left-top">
                        <a href="single.html"><img class="img-responsive" src="{{ asset('images/md3.jpg') }}" alt=""></a>
                        <div class=" content-left-bottom">
                            <h4><i class="glyphicon glyphicon-ok"></i><a href="#">Lorem Ipsum is not simply</a></h4>
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy</p>
                        </div>
                    </div>
                    <div class="col-md-4 content-left-top">
                        <a href="single.html"><img class="img-responsive" src="{{ asset('images/md2.jpg') }}" alt=""></a>
                        <div class=" content-left-bottom">
                            <h4><i class="glyphicon glyphicon-ok"></i><a href="#">Lorem Ipsum is not simply</a></h4>
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy</p>
                        </div>
                    </div>
                    <div class="clearfix"> </div>
                </div>
                <!--//content-left-->
            </div>
            <!--content-right-->
            <div class="content-right">
                <div class="col-md-6 content-right-top">
                    <h3>Lorem Ipsum is simply dummy</h3>
                    <ul>
                        <li><a href="#"><i class="glyphicon glyphicon-cog"> </i>It is a long established fact that a reader will be distracted</a></li>
                        <li><a href="#"><i class="glyphicon glyphicon-cog"> </i>Contrary to popular belief, Lorem Ipsum is not simply random text.</a></li>
                        <li><a href="#"><i class="glyphicon glyphicon-cog"> </i>The standard chunk of Lorem Ipsum used since the 1500s is.</a></li>
                        <li><a href="#"><i class="glyphicon glyphicon-cog"> </i>There are many variations of passages of Lorem Ipsum available</a></li>
                        <li><a href="#"><i class="glyphicon glyphicon-cog"> </i>Sed ut perspiciatis unde omnis iste natus error sit voluptatem</a></li>
                        <li><a href="#"><i class="glyphicon glyphicon-cog"> </i>It is a long established fact that a reader will be distracted</a></li>
                        <li><a href="#"><i class="glyphicon glyphicon-cog"> </i>Contrary to popular belief, Lorem Ipsum is not simply random text.</a></li>
                        
                    </ul>
                </div>
                <div class="col-md-6 content-right-top col1">
                    <h3>Lorem Ipsum is simply dummy</h3>
                    <ul>
                        <li><a href="#"><i class="glyphicon glyphicon-cog"> </i>It is a long established fact that a reader will be distracted</a></li>
                        <li><a href="#"><i class="glyphicon glyphicon-cog"> </i>Contrary to popular belief, Lorem Ipsum is not simply random text.</a></li>
                        <li><a href="#"><i class="glyphicon glyphicon-cog"> </i>The standard chunk of Lorem Ipsum used since the 1500s is.</a></li>
                        <li><a href="#"><i class="glyphicon glyphicon-cog"> </i>There are many variations of passages of Lorem Ipsum available</a></li>
                        <li><a href="#"><i class="glyphicon glyphicon-cog"> </i>Sed ut perspiciatis unde omnis iste natus error sit voluptatem</a></li>
                        <li><a href="#"><i class="glyphicon glyphicon-cog"> </i>It is a long established fact that a reader will be distracted</a></li>
                        <li><a href="#"><i class="glyphicon glyphicon-cog"> </i>Contrary to popular belief, Lorem Ipsum is not simply random text.</a></li>
                        
                    </ul>
                </div>
                <div class="clearfix"> </div>
            </div>
            <!--//content-right-->
            <!--content-bottom-->
            <div class="content-bottom">
                <div class="container">
                    <h4>Events</h4>
                    <div class="col-md-6 content-bottom-top">
                        <span>30<small>Jan</small></span>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam</p>
                        <a href="single.html" class="hvr-icon-wobble-horizontal">Read More</a>
                    </div>
                    <div class="col-md-6 content-bottom-top">
                        <span>15<small>mar</small></span>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam</p>
                        <a href="single.html" class="hvr-icon-wobble-horizontal">Read More</a>
                    </div>
                    <div class="clearfix"> </div>
                </div>
            </div>
            <!--//content-bottom-->
            <!--address-->
            <div class="address">
                <div class="container">
                    <div class=" address-more">
                        <h3>Address</h3>
                        <div class="col-md-4 address-grid">
                            <i class="glyphicon glyphicon-map-marker"></i>
                            <div class="address1">
                                <p>Lorem ipsum dolor</p>
                                <p>TL 19034-88974</p>
                            </div>
                            <div class="clearfix"> </div>
                        </div>
                        <div class="col-md-4 address-grid ">
                            <i class="glyphicon glyphicon-phone"></i>
                            <div class="address1">
                                <p>+885699655</p>
                            </div>
                            <div class="clearfix"> </div>
                        </div>
                        <div class="col-md-4 address-grid ">
                            <i class="glyphicon glyphicon-envelope"></i>
                            <div class="address1">
                                <p><a href="mailto:@example.com"> @example.com</a></p>
                            </div>
                            <div class="clearfix"> </div>
                        </div>
                        <div class="clearfix"> </div>
                    </div>
                </div>
            </div>
            <!--//address-->
        </div>
        <!--footer-->
        <div class="footer">
            <div class="container">
                <div class="col-md-4 footer-top">
                    <h3><a href="/login">scientist</a></h3>
                </div>
                <div class="col-md-4 footer-top1">
                    <ul class="social">
                        <li><a href="#"><i> </i></a></li>
                        <li><a href="#"><i class="dribble"> </i></a></li>
                        <li><a href="#"><i class="facebook"> </i></a></li>
                    </ul>
                </div>
                <div class="col-md-4 footer-top2">
                    <p >© 2016 Scientist. All rights reserved | Design by <a href="http://w3layouts.com/" target="_blank">W3layouts</a> </p>
                </div>
                <div class="clearfix"> </div>
            </div>
        </div>
    </body>
</html>