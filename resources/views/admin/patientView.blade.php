@extends('layouts.app')
   @section('title') Single patient @endsection
@section('content')
@include('includes.alertMessage')
<div class="content-wrapper p-3 view">
   <div class="row justify-content-center">
      <div class="col-md-12">
         <div class="card">
            <h6 class="card-header bg-success text-center py-2">Single patient</h6>
            <div class="card-body">
               <table class="table table-bordered">                  
                  <tr>
                     <td colspan="2">
                        <div class="text-center">
                           <img src="{{asset('')}}/{{$patient->photo ?? 'images/default.jpg'}}" class="img-thumbnail" alt="No Image found" width="100">
                           <br>
                           <span>{{$patient->user->name}}</span>                         
                        </div>
                     </td>
                  </tr>               
                  <tr>
                     <td width="20%">
                        <label class="capitalize">patient Id</label>
                     </td>
                     <td>{{$patient->patient_id}}</td>
                  </tr>
                  <tr>
                     <td width="20%">
                        <label class="capitalize">Email</label>
                     </td>
                     <td>{{$patient->user->email}}</td>
                  </tr>
                  <tr>
                     <td width="20%">
                        <label class="capitalize">Phone</label>
                     </td>
                     <td>{{$patient->user->phone}}</td>
                  </tr>
                  <tr>
                     <td width="20%">
                        <label class="capitalize">Gender</label>
                     </td>
                     <td>{{$patient->gender}}</td>
                  </tr>
                  <tr>
                     <td width="20%">
                        <label class="capitalize">Blood group</label>
                     </td>
                     <td>{{$patient->blood}}</td>
                  </tr>
                  <tr>
                     <td width="20%">
                        <label class="capitalize">Date of birth</label>
                     </td>
                     <td>{{$patient->dob}}</td>
                  </tr>
               </table>             
            </div>

            <div class="card-footer row justify-content-center">
               <a href="{{ route('patient.list') }}" class="btn btn-primary col-2">
                  <i class="fas fa-arrow-circle-left nav-icon"></i>   &nbsp;
                  Back
               </a>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection
@section('js')
@endsection