@extends('layouts.app')
   @section('title') Patient-list @endsection
@section('content')
@include('includes.alertMessage')

<div class="content-wrapper p-3">
   <div class="row justify-content-center">
      <div class="col-md-12">        
         <div class="card border border-danger">
            
            {{-- Create new patient --}}
            @include('modal.createPatientTop')

            <h6 class="card-header bg-success text-center py-1 mx-1">Patient list</h6>
            <div class="card-body p-1">
               <table class="table table-bordered">
                  <thead class="bg-info">
                     <th>Sl</th>
                     <th>Patient ID</th>
                     <th>Name</th>
                     <th>Mobile</th>
                     <th>Email</th>
                     <th>Age</th>
                     <th>Activation</th>
                     <th>Action</th>
                  </thead>
                  <tbody>
                     @foreach($patients as $patient)
                        <tr>
                           <td width="30">{{$loop->iteration}}</td>
                           <td>{!!$patient->patient_id!!}</td>
                           <td>
                              <img src="{{asset('')}}/{{$patient->photo ?? 'images/default.jpg'}}" class="img-thumbnail" alt="No Image found" width="60">
                              <br>
                              <span>{!!$patient->user->name!!}</span>
                           </td>                        
                           <td>{!!$patient->user->phone!!}</td>
                           <td>{!!$patient->user->email!!}</td>
                           <td>
                              {{\Carbon\Carbon::parse($patient->dob)->diff(\Carbon\Carbon::now())->format(' %y years ')}}
                           </td>
                           <td>
                              <input type="checkbox" class="js-switch status"
                                 data-model="patients" 
                                 data-field="status"
                                 data-id="{{ $patient->id }}" 
                                 data-tab="tabName"
                                 {{ $patient->status == 1 ? 'checked' : '' }}
                              />
                           </td>
                           <td width="auto">
                              <div class="btn-group">
                                 @if(isset($new_booking))
                                    <a href="#" class="btn btn-sm btn-outline-info py-1">New booking</a>
                                 @else
                                    <a href="{{ url('patientView', [$patient->id])}}" class="btn btn-sm btn-outline-info py-1">View</a>
                                    <a href="{{ url('itemDelete', ['patients', $patient->id, 'tabName'])}}" class="btn btn-sm btn-danger py-1" onclick="return confirm('Are you want to delete this?')">Delete</a>
                                 @endif
                              </div>
                           </td>
                        </tr>
                     @endforeach
                  </tbody>
               </table>
            </div>   
            
            {{-- Create new patient --}}
            @include('modal.createPatientButtom')

         </div>
      </div>
   </div>
</div>

@endsection

@section('js')
@endsection
