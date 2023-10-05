@extends('layout.loginlayout')
@section('content')
<div class="page page-center">
      <div class="container container-normal py-4">
        <div class="row align-items-center g-4">
          <div class="col-lg">
            <div class="container-tight">
              <div class="text-center mb-4">
                <h2 style="color: green">JO HEALTH & WELLNESS CONSULTANCY SERVICES</h2>
              </div>
              @if(session('status'))
            <div class="alert alert-danger alert-dismissible" role="alert">
                      <div class="d-flex">
                        <div>
                          <!-- Download SVG icon from http://tabler-icons.io/i/check -->
                          <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-cancel" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
   <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
   <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"></path>
   <path d="M6 21v-2a4 4 0 0 1 4 -4h3.5"></path>
   <path d="M19 19m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0"></path>
   <path d="M17 21l4 -4"></path>
</svg> 
                        </div>
                        <div style="margin-left: 10px;">
                          {{ session('status') }}
                        </div>
                      </div>
                      <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                    </div>
            @endif
              <div class="card card-md">
                <div class="card-body">
                    <h2 class="h2 text-center mb-4">Login to your account</h2>
                    <form action="{{ route('loginuser') }}" method="POST" autocomplete="off" novalidate>
                      {{ csrf_field() }}
                      <div class="mb-3">
                        <label class="form-label">Email address</label>
                        <input type="email" name="email" class="form-control" placeholder="your@email.com" autocomplete="off">
                      </div>
                      <div class="mb-2">
                        <label class="form-label">
                          Password
                          <!-- <span class="form-label-description">
                            <a href="./forgot-password.html">I forgot password</a>
                          </span> -->
                        </label>
                        <div class="input-group input-group-flat">
                          <input type="password" name="password" class="form-control"  placeholder="Your password"  autocomplete="off">
                          <span class="input-group-text">
                            <a href="#" class="link-secondary" title="Show password" data-bs-toggle="tooltip"><!-- Download SVG icon from http://tabler-icons.io/i/eye -->
                              <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" /></svg>
                            </a>
                          </span>
                        </div>
                      </div>
                     <!--  <div class="mb-2">
                        <label class="form-check">
                          <input type="checkbox" class="form-check-input"/>
                          <span class="form-check-label">Remember me on this device</span>
                        </label>
                      </div> -->
                      <div class="form-footer">
                        <button type="submit" class="btn btn-primary w-100">Sign in</button>
                      </div>
                    </form>
                  </div>
              </div>
              <div class="text-center text-secondary mt-3">
                Don't have account yet? <a href="/register" tabindex="-1">Sign up</a>
              </div>
            </div>
          </div>
          <div class="col-lg d-none d-lg-block">
            <img src="./static/illustrations/undraw_secure_login_pdn4.svg" height="300" class="d-block mx-auto" alt="">
          </div>
        </div>
      </div>
    </div>
    @endsection