@extends('layouts.app')
   @section('title') Patient info @endsection
@section('content')
@include('includes.alertMessage')

<div class="content-wrapper p-3">
   <div class="row justify-content-center">
      <div class="col-md-12">
         <div class="card">
            
            <h6 class="card-header bg-info text-center py-1">Patient information (ID: {{$patientInfo->patient_id}})</h6>
            <form action="{{ route('updatePatientInfo') }}" method="post" enctype="multipart/form-data">
               @csrf
               <div class="card-body">
                    <input type="hidden" name="id" value="{{ $patientInfo->id }}">
                    <input type="hidden" name="user_id" value="{{ $patientInfo->user_id }}">

                  <div class="row">
                     <div class="form-group col-4">
                        <label for="name">Full name*</label>
                        <input type="text" class="form-control" name="name" id="name"  value="{{ $patientInfo->user->name ?? '' }}" placeholder="Enter name" readonly>
                     </div>
                     <div class="form-group col-4">
                        <label for="email">Email*</label>
                        <input type="email" class="form-control" name="email" id="email" value="{{ $patientInfo->user->email ?? '' }}" placeholder="Enter email" autocomplete="name" readonly>
                     </div>
                     <div class="form-group col-4">
                        <label for="phone">Mobile number*</label>
                        <input type="number" class="form-control" name="phone" id="phone" value="{{ $nullOr = $patientInfo->user->phone ?? '' }}" placeholder="Enter phone" {{ $nullOr ? 'readonly' : '' }} required>
                     </div>
                  </div>

                  <div class="row">
                     <div class="form-group col-4">
                        <label for="gender">Gender</label>
                        <select class="form-control" name="gender" id="gender">
                           <option value="">Select gender</option>
                           <option value="Male" {{$patientInfo->gender == 'Male' ? 'selected' : ''}}>Male</option>
                           <option value="Female" {{$patientInfo->gender == 'Female' ? 'selected' : ''}}>Female</option>
                           <option value="Custom" {{$patientInfo->gender == 'Custom' ? 'selected' : ''}}>Custom</option>
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
                                    <option value="{{$group}}" {{$patientInfo->blood == $group ? 'selected' : ''}}>{{$group}}</option>
                                @endforeach
                            </select>
                        </div>
                     <div class="form-group col-4">
                        <label for="dob">Date of birth</label>
                        <input type="{{$patientInfo->dob==null ? 'date' : 'text'}}" class="form-control" name="dob" value="{{ date('d-M-Y', strtotime($nullOr = $patientInfo->dob)) ?? '' }}" {{ $nullOr ? 'readonly' : '' }} id="dob" placeholder="Day-Month-Year"/>
                     </div>  
                  </div>

                  <div class="row">
                    <div class="col-8">
                        <div class="row p-0 m-0 border">
                            <div class="form-group col-3">
                               <div class="px-4 pt-2">
                                   <img src="{{asset('')}}/{{$patientInfo->photo ?? 'images/default.jpg'}}" class="img-thumbnail" alt="No Image found" width="60">
                               </div>
                           </div>  
                            <div class="form-group col-9">
                               <label for="photo">Photo</label>
                               <input type="hidden" name="oldPhoto" value="{{ $patientInfo->photo ?? '' }}">
                               <input type="file" class="form-control p-1" name="photo"/>
                               <small class="form-text bg-secondary px-1 rounded font-italic">
                                  <i>Image format: jpeg, png, jpg, gif, svg. Maximum size : 2 MB.</i>
                               </small>
                            </div>
                        </div>
                    </div>

                     <div class="form-group col-4">
                        @php
                            $sources = array('Facebook', 'Instagram', 'Youtube', 'Google', 'Other',);
                        @endphp
                        <label for="source">Source of information</label>
                        <select class="form-control" name="source" id="source">
                           <option value="">Select source</option>
                           @foreach($sources as $source)
                               <option value="{{$source}}" {{$patientInfo->source == $source ? 'selected' : ''}}>{{$source}}</option>
                           @endforeach
                        </select>
                     </div>
                  </div>   

                  <div class="row">
                     <div class="form-group col-12">
                        <label for="address">Address*</label>
                        <textarea type="text" class="form-control summernote required" name="address" id="address" >{{ $patientInfo->address ?? '' }}</textarea>
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
