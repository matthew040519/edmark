@extends('layout.layout')
@section('content')
<div class="page">
      <!-- Navbar -->
      @include('layout.header')
      <div class="page-wrapper">
        <!-- Page header -->
        <div class="page-header d-print-none">
          <div class="container-xl">
            <div class="row g-2 align-items-center">
              <div class="col">
                <!-- Page pre-title -->
                <div class="page-pretitle">
                  Overview
                </div>
                <h2 class="page-title">
                  Dashboard
                </h2>
              </div>
              <!-- Page title actions -->
              <!-- <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                  <span class="d-none d-sm-inline">
                    <a href="#" class="btn">
                      New view
                    </a>
                  </span>
                  <a href="#" class="btn btn-primary d-none d-sm-inline-block" data-bs-toggle="modal" data-bs-target="#modal-report">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                    Create new report
                  </a>
                  <a href="#" class="btn btn-primary d-sm-none btn-icon" data-bs-toggle="modal" data-bs-target="#modal-report" aria-label="Create new report">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                  </a>
                </div>
              </div> -->
            </div>
          </div>
        </div>
        <!-- Page body -->
        <div class="page-body">
          <div class="container-xl">
            <div class="row row-deck row-cards">
              <div class="col-sm-6">
                <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">Edmark Products</h3>
                  </div>
                  <div class="card-body">
                    <div id="carousel-captions" class="carousel slide" data-bs-ride="carousel">
                      <div class="carousel-inner">
                        @foreach($products as $product)
                        <div class="carousel-item active">
                          <img class="d-block w-100" alt="" height="500px" src="product_image/{{ $product->image }}">
                          <div class="carousel-caption-background d-none d-md-block"></div>
                          <div class="carousel-caption d-none d-md-block">
                            <h3>{{ $product->product_name }}</h3>
                            <p>{{ $product->product_details }}</p>
                          </div>
                        </div>
                        @endforeach
                        <!-- <div class="carousel-item">
                          <img class="d-block w-100" alt="" src="./static/photos/young-entrepreneur-working-from-a-modern-cafe-2.jpg">
                          <div class="carousel-caption-background d-none d-md-block"></div>
                          <div class="carousel-caption d-none d-md-block">
                            <h3>Slide label</h3>
                            <p>Nulla vitae elit libero, a pharetra augue mollis interdum.</p>
                          </div>
                        </div>
                        <div class="carousel-item">
                          <img class="d-block w-100" alt="" src="./static/photos/soft-photo-of-woman-on-the-bed-with-the-book-and-cup-of-coffee-in-hands.jpg">
                          <div class="carousel-caption-background d-none d-md-block"></div>
                          <div class="carousel-caption d-none d-md-block">
                            <h3>Slide label</h3>
                            <p>Nulla vitae elit libero, a pharetra augue mollis interdum.</p>
                          </div>
                        </div>
                        <div class="carousel-item">
                          <img class="d-block w-100" alt="" src="./static/photos/fairy-lights-at-the-beach-in-bulgaria.jpg">
                          <div class="carousel-caption-background d-none d-md-block"></div>
                          <div class="carousel-caption d-none d-md-block">
                            <h3>Slide label</h3>
                            <p>Nulla vitae elit libero, a pharetra augue mollis interdum.</p>
                          </div>
                        </div>
                        <div class="carousel-item">
                          <img class="d-block w-100" alt="" src="./static/photos/woman-working-on-laptop-at-home-office.jpg">
                          <div class="carousel-caption-background d-none d-md-block"></div>
                          <div class="carousel-caption d-none d-md-block">
                            <h3>Slide label</h3>
                            <p>Nulla vitae elit libero, a pharetra augue mollis interdum.</p>
                          </div>
                        </div> -->
                      </div>
                      <a class="carousel-control-prev" href="#carousel-captions" role="button" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                      </a>
                      <a class="carousel-control-next" href="#carousel-captions" role="button" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-6">
               <div class="card">
                      <div class="card-header">
                        <h3 class="card-title">Top users</h3>
                      </div>
                      <div class="card-body">
                        <div class="row g-3">
                          <div class="col-6">
                            <div class="row g-3 align-items-center">
                              <a href="#" class="col-auto">
                                <span class="avatar" style="background-image: url(./static/avatars/000m.jpg)">
                                  <span class="badge bg-red"></span></span>
                              </a>
                              <div class="col text-truncate">
                                <a href="#" class="text-reset d-block text-truncate">Paweł Kuna</a>
                                <div class="text-secondary text-truncate mt-n1">2 days ago</div>
                              </div>
                            </div>
                          </div>
                          <div class="col-6">
                            <div class="row g-3 align-items-center">
                              <a href="#" class="col-auto">
                                <span class="avatar">
                                  <span class="badge bg-x"></span>JL</span>
                              </a>
                              <div class="col text-truncate">
                                <a href="#" class="text-reset d-block text-truncate">Jeffie Lewzey</a>
                                <div class="text-secondary text-truncate mt-n1">3 days ago</div>
                              </div>
                            </div>
                          </div>
                          <div class="col-6">
                            <div class="row g-3 align-items-center">
                              <a href="#" class="col-auto">
                                <span class="avatar" style="background-image: url(./static/avatars/002m.jpg)"></span>
                              </a>
                              <div class="col text-truncate">
                                <a href="#" class="text-reset d-block text-truncate">Mallory Hulme</a>
                                <div class="text-secondary text-truncate mt-n1">today</div>
                              </div>
                            </div>
                          </div>
                          <div class="col-6">
                            <div class="row g-3 align-items-center">
                              <a href="#" class="col-auto">
                                <span class="avatar" style="background-image: url(./static/avatars/003m.jpg)">
                                  <span class="badge bg-green"></span></span>
                              </a>
                              <div class="col text-truncate">
                                <a href="#" class="text-reset d-block text-truncate">Dunn Slane</a>
                                <div class="text-secondary text-truncate mt-n1">6 days ago</div>
                              </div>
                            </div>
                          </div>
                          <div class="col-6">
                            <div class="row g-3 align-items-center">
                              <a href="#" class="col-auto">
                                <span class="avatar" style="background-image: url(./static/avatars/000f.jpg)">
                                  <span class="badge bg-red"></span></span>
                              </a>
                              <div class="col text-truncate">
                                <a href="#" class="text-reset d-block text-truncate">Emmy Levet</a>
                                <div class="text-secondary text-truncate mt-n1">3 days ago</div>
                              </div>
                            </div>
                          </div>
                          <div class="col-6">
                            <div class="row g-3 align-items-center">
                              <a href="#" class="col-auto">
                                <span class="avatar" style="background-image: url(./static/avatars/001f.jpg)">
                                  <span class="badge bg-yellow"></span></span>
                              </a>
                              <div class="col text-truncate">
                                <a href="#" class="text-reset d-block text-truncate">Maryjo Lebarree</a>
                                <div class="text-secondary text-truncate mt-n1">2 days ago</div>
                              </div>
                            </div>
                          </div>
                          <div class="col-6">
                            <div class="row g-3 align-items-center">
                              <a href="#" class="col-auto">
                                <span class="avatar">
                                  <span class="badge bg-x"></span>EP</span>
                              </a>
                              <div class="col text-truncate">
                                <a href="#" class="text-reset d-block text-truncate">Egan Poetz</a>
                                <div class="text-secondary text-truncate mt-n1">4 days ago</div>
                              </div>
                            </div>
                          </div>
                          <div class="col-6">
                            <div class="row g-3 align-items-center">
                              <a href="#" class="col-auto">
                                <span class="avatar" style="background-image: url(./static/avatars/002f.jpg)">
                                  <span class="badge bg-yellow"></span></span>
                              </a>
                              <div class="col text-truncate">
                                <a href="#" class="text-reset d-block text-truncate">Kellie Skingley</a>
                                <div class="text-secondary text-truncate mt-n1">6 days ago</div>
                              </div>
                            </div>
                          </div>
                          <div class="col-6">
                            <div class="row g-3 align-items-center">
                              <a href="#" class="col-auto">
                                <span class="avatar" style="background-image: url(./static/avatars/003f.jpg)">
                                  <span class="badge bg-x"></span></span>
                              </a>
                              <div class="col text-truncate">
                                <a href="#" class="text-reset d-block text-truncate">Christabel Charlwood</a>
                                <div class="text-secondary text-truncate mt-n1">today</div>
                              </div>
                            </div>
                          </div>
                          <div class="col-6">
                            <div class="row g-3 align-items-center">
                              <a href="#" class="col-auto">
                                <span class="avatar">
                                  <span class="badge bg-x"></span>HS</span>
                              </a>
                              <div class="col text-truncate">
                                <a href="#" class="text-reset d-block text-truncate">Haskel Shelper</a>
                                <div class="text-secondary text-truncate mt-n1">yesterday</div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
              </div>
            </div>
          </div>
        </div>
        @include('layout.footer')
      </div>
    </div>
   
@endsection