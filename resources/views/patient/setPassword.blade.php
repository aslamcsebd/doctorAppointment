@extends('layouts.app')
   @section('title') Password set @endsection
@section('content')
@include('includes.alertMessage')

<div class="content-wrapper p-3">
   <div class="row justify-content-center">
      <div class="col-md-8">
         <div class="card">
            
            <h6 class="card-header bg-warning text-center py-1">Patient information</h6>
            <form action="{{ route('setPasswordNow') }}" method="post" enctype="multipart/form-data">
               @csrf
               <div class="card-body">
                  <input type="hidden" name="id" value="{{ $patientInfo->id }}">
                  <div class="row">
                     <div class="form-group col-6">
                        <label for="name">Full name*</label>
                        <input type="text" class="form-control" id="name" value="{{ $patientInfo->name ?? '' }}" readonly>
                     </div>
                     <div class="form-group col-6">
                        <label for="email">Email*</label>
                        <input type="email" class="form-control" id="email" value="{{ $patientInfo->email ?? '' }}" autocomplete="name" readonly>
                     </div>
                  </div>

                  <div class="row">
                     <div class="form-group col-6">
                        <label for="password">Password*</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password" placeholder="Enter password" autocomplete="new-password" required>
                        @error('password')
                           <span class="invalid-feedback" role="alert">
                                 <strong>{{ $message }}</strong>
                           </span>
                        @enderror
                     </div>
                     <div class="form-group col-6">
                        <label for="password">Confirm Password*</label>
                        <input type="password" class="form-control" name="password_confirmation" id="password" placeholder="Confirm password" autocomplete="new-password" required>
                     </div>
                     <div class="form-group col-12">
                     <small class="form-text bg-secondary px-1 rounded font-italic">
                           Minimum 6 characters. Leave blank to assign auto-generated password.
                        </small>
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

