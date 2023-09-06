@extends('layout.layout')
@section('content')
<div class="page">
	@include('layout.header')
 <div class="page-wrapper">
        <!-- Page header -->
        <div class="page-header d-print-none">
          <div class="container-xl">
            <div class="row g-2 align-items-center">
              <div class="col">
                <h2 class="page-title">
                  Account Settings
                </h2>
              </div>
            </div>
          </div>
        </div>
        <!-- Page body -->
        <div class="page-body">
          <div class="container-xl">
            @if(session('status'))
            <div class="alert alert-success alert-dismissible" role="alert">
                      <div class="d-flex">
                        <div>
                          <!-- Download SVG icon from http://tabler-icons.io/i/check -->
                          <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10" /></svg>
                        </div>
                        <div>
                          {{ session('status') }}
                        </div>
                      </div>
                      <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                    </div>
            @endif
            <div class="card">
              <div class="row g-0">
                <div class="col-12 col-md-3 border-end">
                  <div class="card-body">
                    <h4 class="subheader">Business settings</h4>
                    <div class="list-group list-group-transparent">
                      <a href="./settings.html" class="list-group-item list-group-item-action d-flex align-items-center active">My Account</a>
                      <!-- <a href="#" class="list-group-item list-group-item-action d-flex align-items-center">My Notifications</a>
                      <a href="#" class="list-group-item list-group-item-action d-flex align-items-center">Connected Apps</a>
                      <a href="./settings-plan.html" class="list-group-item list-group-item-action d-flex align-items-center">Plans</a>
                      <a href="#" class="list-group-item list-group-item-action d-flex align-items-center">Billing & Invoices</a> -->
                    </div>
                    <!-- <h4 class="subheader mt-4">Experience</h4>
                    <div class="list-group list-group-transparent">
                      <a href="#" class="list-group-item list-group-item-action">Give Feedback</a>
                    </div> -->
                  </div>
                </div>
                
                <div class="col-12 col-md-9 d-flex flex-column">
                  <div class="card-body">
                    <h2 class="mb-4">My Account</h2>
                    <h3 class="card-title">Profile Details</h3>
                    <form method="POST" action="{{ route('updatesettings') }}" enctype="multipart/form-data">
                      {{ csrf_field() }}
                    <div class="row align-items-center">
                      @if($user->image == NULL)
                      <div class="col-auto"><span class="avatar avatar-xl" style="background-image: url('https://i.pinimg.com/originals/f1/0f/f7/f10ff70a7155e5ab666bcdd1b45b726d.jpg')"></span>
                      </div>
                      @else
                      <div class="col-auto"><span class="avatar avatar-xl" style="background-image: url(profile_picture/{{ $user->image }})"></span>
                      </div>
                      @endif
                      <div class="col-auto">
                        <!-- <a href="#" class="btn">
                          Change avatar
                        </a> -->
                        <input type="file" class="form-control" name="image">
                      </div>
                      <!-- <div class="col-auto"><a href="#" class="btn btn-ghost-danger">
                          Delete avatar
                        </a></div> -->
                    </div>
                    <input type="hidden" value="{{ $user->id }}" name="id">
                    <h3 class="card-title mt-4"></h3>
                    <div class="row g-3">
                      <div class="col-md">
                        <div class="form-label">First Name</div>
                        <input type="text" class="form-control" name="firstname" value="{{ $user->firstname }}">
                      </div>
                      <div class="col-md">
                        <div class="form-label">Middle Name</div>
                        <input type="text" class="form-control" name="middlename" value="{{ $user->middlename }}">
                      </div>
                      <div class="col-md">
                        <div class="form-label">Last Name</div>
                        <input type="text" class="form-control" name="lastname" value="{{ $user->lastname }}">
                      </div>
                    </div>
                    <div class="row g-3 mt-2">
                      <div class="col-md">
                        <div class="form-label">Email</div>
                        <input type="email" class="form-control" readonly="" name="email" value="{{ $user->email }}">
                      </div>
                      <div class="col-md">
                        <div class="form-label">Contact Number</div>
                        <input type="text" class="form-control" name="contact_number" value="{{ $user->contact_number }}">
                      </div>
                      <div class="col-md">
                        <div class="form-label">Birthdate</div>
                        <input type="date" class="form-control" name="bday" value="{{ $user->bday }}">
                      </div>
                    </div>
                    <div class="row g-3 mt-2">
                      <div class="col-md-12">
                        <div class="form-label">Password</div>
                        <input type="password" name="password" class="form-control">
                      </div>
                    </div>
                    <div class="row g-3 mt-2">
                      <div class="col-md-12">
                        <div class="form-label">Address</div>
                        <textarea class="form-control" name="address" rows="4">{{ $user->address }}</textarea>
                      </div>
                    </div>
                  </div>
                  <div class="card-footer bg-transparent mt-auto">
                    <div class="btn-list justify-content-end">
                     <!--  <a href="#" class="btn">
                        Cancel
                      </a> -->
                      <!-- <a href="#" class="btn btn-primary">
                        Submit
                      </a> -->
                      <input type="submit" class="btn btn-primary" value="Update" name="">
                    </div>
                  </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
       	@include('layout.footer')
      </div>
     </div>
@endsection