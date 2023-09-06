@extends('layout.loginlayout')
@section('content')
<div class="page page-center">
      <div class="container container-tight py-4">
        <div class="text-center mb-4">
          <a href="." class="navbar-brand navbar-brand-autodark">
            <img src="data:image/jpeg;base64,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" width="110" height="32" alt="Tabler" class="navbar-brand-image">
          </a>
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
          <!-- <div class="hr-text">or</div>
          <div class="card-body">
            <div class="row">
              <div class="col"><a href="#" class="btn w-100">
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon text-github" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 19c-4.3 1.4 -4.3 -2.5 -6 -3m12 5v-3.5c0 -1 .1 -1.4 -.5 -2c2.8 -.3 5.5 -1.4 5.5 -6a4.6 4.6 0 0 0 -1.3 -3.2a4.2 4.2 0 0 0 -.1 -3.2s-1.1 -.3 -3.5 1.3a12.3 12.3 0 0 0 -6.2 0c-2.4 -1.6 -3.5 -1.3 -3.5 -1.3a4.2 4.2 0 0 0 -.1 3.2a4.6 4.6 0 0 0 -1.3 3.2c0 4.6 2.7 5.7 5.5 6c-.6 .6 -.6 1.2 -.5 2v3.5" /></svg>
                  Login with Github
                </a></div>
              <div class="col"><a href="#" class="btn w-100">
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon text-twitter" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M22 4.01c-1 .49 -1.98 .689 -3 .99c-1.121 -1.265 -2.783 -1.335 -4.38 -.737s-2.643 2.06 -2.62 3.737v1c-3.245 .083 -6.135 -1.395 -8 -4c0 0 -4.182 7.433 4 11c-1.872 1.247 -3.739 2.088 -6 2c3.308 1.803 6.913 2.423 10.034 1.517c3.58 -1.04 6.522 -3.723 7.651 -7.742a13.84 13.84 0 0 0 .497 -3.753c0 -.249 1.51 -2.772 1.818 -4.013z" /></svg>
                  Login with Twitter
                </a></div>
            </div>
          </div> -->
        </div>
        <!-- <div class="text-center text-secondary mt-3">
          Don't have account yet? <a href="./sign-up.html" tabindex="-1">Sign up</a>
        </div> -->
      </div>
    </div>
    @endsection