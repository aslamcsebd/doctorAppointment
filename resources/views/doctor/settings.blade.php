@extends('layouts.app')
   @section('title') Update doctor info @endsection
@section('content')
@include('includes.alertMessage')

<div class="content-wrapper p-3">
   <div class="row justify-content-center">
      <div class="col-md-12">
         <div class="card">
            
            <h6 class="card-header bg-info text-center py-1">Patient information (ID: {{$doctorInfo->doctor_id}})</h6>
            <form action="{{ route('updateDoctorInfo') }}" method="post" enctype="multipart/form-data">
               @csrf
               <div class="card-body">
                    <input type="hidden" name="id" value="{{ $doctorInfo->id }}">

                  <div class="row">
                     <div class="form-group col-4">
                        <label for="name">Full name*</label>
                        <input type="text" class="form-control" name="name" id="name"  value="{{ $doctorInfo->user->name ?? '' }}" placeholder="Enter name" readonly>
                     </div>
                     <div class="form-group col-4">
                        <label for="email">Email*</label>
                        <input type="email" class="form-control" name="email" id="email" value="{{ $doctorInfo->user->email ?? '' }}" placeholder="Enter email" autocomplete="name" readonly>
                     </div>
                     <div class="form-group col-4">
                        <label for="phone">Mobile number*</label>
                        <input type="number" class="form-control" name="phone" id="phone" value="{{ $doctorInfo->user->phone ?? '' }}" placeholder="Enter phone" readonly>
                     </div>
                  </div>

                  <div class="row">
                     <div class="form-group col-4">
                        <label for="gender">Gender</label>
                        <select class="form-control" name="gender" id="gender">
                           <option value="">Select gender</option>
                           <option value="Male" {{$doctorInfo->gender == 'Male' ? 'selected' : ''}}>Male</option>
                           <option value="Female" {{$doctorInfo->gender == 'Female' ? 'selected' : ''}}>Female</option>
                           <option value="Custom" {{$doctorInfo->gender == 'Custom' ? 'selected' : ''}}>Custom</option>
                        </select>
                     </div>
                     <div class="form-group col-4">
                        <label for="blood">Blood group</label>
                        <select class="form-control" name="blood" id="blood">
                           <option value="">Select group</option>
                           <option value="O +ve" {{$doctorInfo->blood == 'O +ve' ? 'selected' : ''}}>O +ve</option>
                           <option value="O -ve" {{$doctorInfo->blood == 'O -ve' ? 'selected' : ''}}>O -ve</option>
                           <option value="A +ve" {{$doctorInfo->blood == 'A +ve' ? 'selected' : ''}}>A +ve</option>
                           <option value="A -ve" {{$doctorInfo->blood == 'A -ve' ? 'selected' : ''}}>A -ve</option>
                           <option value="B +ve" {{$doctorInfo->blood == 'B +ve' ? 'selected' : ''}}>B +ve</option>
                           <option value="B -ve" {{$doctorInfo->blood == 'B -ve' ? 'selected' : ''}}>B -ve</option>
                           <option value="AB +ve" {{$doctorInfo->blood == 'AB +ve' ? 'selected' : ''}}>AB +ve</option>
                           <option value="AB -ve" {{$doctorInfo->blood == 'AB -ve' ? 'selected' : ''}}>AB -ve</option>
                           <option value="Unknown" {{$doctorInfo->blood == 'Unknown' ? 'selected' : ''}}>Unknown</option>
                        </select>
                     </div>
                     <div class="form-group col-4">
                        <label for="dob">Date of birth</label>
                        <input type="text" class="form-control datepicker" name="dob" value="{{ date('d-m-Y', strtotime($doctorInfo->dob)) ?? '' }}" id="dob" placeholder="Day-Month-Year"/>
                     </div>  
                  </div>

                  <div class="row p-0 m-0 border">
                     <div class="form-group col-2">
                        <div class="px-4 pt-2">
                            <img src="{{asset('')}}/{{$doctorInfo->photo ?? 'images/default.jpg'}}" class="img-thumbnail" alt="No Image found" width="60">
                        </div>
                    </div>  
                     <div class="form-group col-10">
                        <label for="photo">Photo</label>
                        <input type="hidden" name="oldPhoto" value="{{ $doctorInfo->photo ?? '' }}">
                        <input type="file" class="form-control p-1" name="photo"/>
                        <small class="form-text bg-secondary px-1 rounded font-italic">
                           <i>Image format: jpeg, png, jpg, gif, svg. Maximum size : 2 MB.</i>
                        </small>
                     </div>
                  </div>   

                  <div class="row">
                     <div class="form-group col-12">
                        <label for="qualification">Qualification/Specialization*</label>
                        <textarea type="text" class="form-control summernote required" name="qualification" id="qualification" placeholder="Enter qualification">
                            {{ $doctorInfo->qualification ?? '' }}
                        </textarea>
                     </div>
                  </div>

                  <div class="row">
                     <div class="form-group col-12">
                        <label for="service">Services offered*</label>
                        <textarea type="text" class="form-control summernote required" name="service" id="service" placeholder="Enter service">
                            {{ $doctorInfo->service ?? '' }}
                        </textarea>
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
