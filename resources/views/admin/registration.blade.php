@extends('layouts.app')
   @section('title') Doctor registration @endsection
@section('content')
@include('includes.alertMessage')

<div class="content-wrapper p-3">
   <div class="row justify-content-center">
      <div class="col-md-12">
         <div class="card">
            
            <h6 class="card-header bg-info text-center py-1">Doctor's registration form</h6>
            <form action="{{ route('doctor.create') }}" method="post" enctype="multipart/form-data">
               @csrf
               <div class="card-body">

                  <div class="row">
                     <div class="form-group col-4">
                        <label for="name">Full name*</label>
                        <input type="text" class="form-control" name="name" id="name"  value="{{ old('name') }}" placeholder="Enter name" required>
                     </div>
                     <div class="form-group col-4">
                        <label for="email">Email*</label>
                        <input type="email" class="form-control" name="email" id="email" value="{!! old('email') !!}" placeholder="Enter email" autocomplete="name" required>
                     </div>
                     <div class="form-group col-4">
                        <label for="phone">Mobile number*</label>
                        <input type="number" class="form-control" name="phone" id="phone" placeholder="Enter phone" required>
                     </div>
                  </div>

                  <div class="row">
                     <div class="form-group col-4">
                        <label for="gender">Gender</label>
                        <select class="form-control" name="gender" id="gender">
                           <option value="">Select gender</option>
                           <option value="Male">Male</option>
                           <option value="Female">Female</option>
                           <option value="Custom">Custom</option>
                        </select>
                     </div>
                     <div class="form-group col-4">
                        @php
                            $groups = array('O +ve', 'O -ve', 'A +ve', 'A -ve', 'B +ve', 'B -ve', 'AB +ve', 'AB -ve', 'Unknown');
                        @endphp
                        <label for="blood">Blood group</label>
                        <select class="form-control" name="blood" id="blood">
                           <option value="">Select group</option>
                            @foreach($groups as $group)
                                <option value="{{$group}}">{{$group}}</option>
                            @endforeach
                        </select>
                     </div>
                     <div class="form-group col-4">
                        <label for="dob">Date of birth</label>
                        <input type="text" class="form-control datepicker" name="dob" id="dob" placeholder="Day-Month-Year"/>
                     </div>  
                  </div>

                  <div class="row">
                     <div class="form-group col-6">
                        <label for="password">Password*</label>
                        <input type="text" class="form-control" name="password" id="password" placeholder="Enter password" value="123456"  autocomplete="new-password" required>
                        <small class="form-text bg-secondary px-1 rounded font-italic">
                           Minimum 6 characters. Leave blank to assign auto-generated password.
                        </small>
                     </div>
                     <div class="form-group col-6">
                        <label for="photo">Photo</label>
                        <input type="file" class="form-control p-1" name="photo"/>
                        <small class="form-text bg-secondary px-1 rounded font-italic">
                           <i>Image format: jpeg, png, jpg, gif, svg. Maximum size : 2 MB.</i>
                        </small>
                     </div>
                  </div>     
                  
                  <div class="row">
                     <div class="form-group col-12">
                        <label for="qualification">Qualification/Specialization*</label>
                        <textarea type="text" class="form-control summernote required" name="qualification" id="qualification" placeholder="Enter qualification"></textarea>
                     </div>
                  </div>

                  <div class="row">
                     <div class="form-group col-12">
                        <label for="service">Services offered*</label>
                        <textarea type="text" class="form-control summernote required" name="service" id="service" placeholder="Enter service"></textarea>
                     </div>
                  </div>

                  <div class="row justify-content-md-center mt-2">
                     <button type="submit" class="btn btn-success col-md-4">Save now</button>
                  </div>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>
@endsection

