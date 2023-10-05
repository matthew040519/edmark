<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900&display=swap" rel="stylesheet">

    <title>Edmark</title>

    <!-- Bootstrap core CSS -->
    <link href="landing/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<!--

TemplateMo 546 Sixteen Clothing

https://templatemo.com/tm-546-sixteen-clothing

-->

    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="landing/assets/css/fontawesome.css">
    <link rel="stylesheet" href="landing/assets/css/templatemo-sixteen.css">
    <link rel="stylesheet" href="landing/assets/css/owl.css">

  </head>

  <body>

    <!-- ***** Preloader Start ***** -->
    <div id="preloader">
        <div class="jumper">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>  
    <!-- ***** Preloader End ***** -->

    <!-- Header -->
    <header class="" style="background-color: white;">
      <nav class="navbar navbar-expand-lg">
        <div class="container">
          <h4 style="color: green">JO HEALTH & WELLNESS CONSULTANCY SERVICES</h4>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
              <li class="nav-item ">
                <a class="nav-link" href="/" style="color: black;">Home
                  
                </a>
              </li> 
              <li class="nav-item active">
                <a class="nav-link" href="/landing-products" style="color: black;">Our Products
                <span class="sr-only">(current)</span></a>
              </li>
              <!-- <li class="nav-item">
                <a class="nav-link" href="/landing-about" style="color: black;">About Us</a>
              </li> -->
              <li class="nav-item">
                <a class="nav-link" href="/login" style="color: black;">Login</a>
              </li>
            </ul>
          </div>
        </div>
      </nav>
    </header>

    <!-- Page Content -->
    <div class="page-heading products-heading header-text">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="text-content">
              <h4>new arrivals</h4>
              <h2>Edmark products</h2>
            </div>
          </div>
        </div>
      </div>
    </div>

    
    <div class="products">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="filters">
              <ul>
                  <li class="active" data-filter="*">All Products</li>
                  <!-- <li data-filter=".des">Featured</li>
                  <li data-filter=".dev">Flash Deals</li>
                  <li data-filter=".gra">Last Minute</li> -->
              </ul>
            </div>
          </div>
          <div class="col-md-12">
            <div class="filters-content">
                <div class="row grid">
                  @foreach($products as $product)
                    <div class="col-lg-4 col-md-4 all des">
                      <div class="product-item">
                        <a href="#"><img style="height: 300px" src="product_image/{{ $product->image }}" alt=""></a>
                        <div class="down-content">
                          <a href="#"><h4>{{ $product->product_name }}</h4></a>
                          <!-- <h6>&#8369; {{ $product->price }}</h6> -->
                          <p>{{ $product->product_details }}</p>
                          <!-- <ul class="stars">
                            <li><i class="fa fa-star"></i></li>
                            <li><i class="fa fa-star"></i></li>
                            <li><i class="fa fa-star"></i></li>
                            <li><i class="fa fa-star"></i></li>
                            <li><i class="fa fa-star"></i></li>
                          </ul> -->
                          <span>Price: &#8369; {{ number_format($product->price, 2) }}</span>
                        </div>
                      </div>
                    </div>
                  @endforeach
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    
    <footer>
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="inner-content">
              <p>Copyright &copy; 2023 Edmark</p>
            </div>
          </div>
        </div>
      </div>
    </footer>


    <!-- Bootstrap core JavaScript -->
    <script src="landing/vendor/jquery/jquery.min.js"></script>
    <script src="landing/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>


    <!-- Additional Scripts -->
    <script src="landing/assets/js/custom.js"></script>
    <script src="landing/assets/js/owl.js"></script>
    <script src="landing/assets/js/slick.js"></script>
    <script src="landing/assets/js/isotope.js"></script>
    <script src="landing/assets/js/accordions.js"></script>


    <script language = "text/Javascript"> 
      cleared[0] = cleared[1] = cleared[2] = 0; //set a cleared flag for each field
      function clearField(t){                   //declaring the array outside of the
      if(! cleared[t.id]){                      // function makes it static and global
          cleared[t.id] = 1;  // you could use true and false, but that's more typing
          t.value='';         // with more chance of typos
          t.style.color='#fff';
          }
      }
    </script>


  </body>

</html>
