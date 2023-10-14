@extends('layouts.app')
   @section('title') Single report @endsection
@section('content')
@include('includes.alertMessage')
<div class="content-wrapper p-3 view">
   <div class="row justify-content-center">
      <div class="col-md-12">
         <div class="card">
            <h6 class="card-header bg-success text-center py-1">Add report</h6>
            <div class="card-body py-0">
               <table class="table table-bordered">                  
                  <tr>
                     <td colspan="2">
                        <div class="text-center">
                           <img src="{{asset('')}}/{{$appointment->patient->photo ?? 'images/default.jpg'}}" class="img-thumbnail" alt="No Image found" width="100">
                           <br>
                           <span>{{$appointment->user2->name}}</span>                         
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <td width="20%">
                        <label class="capitalize">Email</label>
                     </td>
                     <td>{{$appointment->user2->email}}</td>
                  </tr>
                  <tr>
                     <td width="20%">
                        <label class="capitalize">Phone</label>
                     </td>
                     <td>{{$appointment->user2->phone}}</td>
                  </tr>
                  <tr>
                     <td width="20%">
                        <label class="capitalize">Gender</label>
                     </td>
                     <td>{{$appointment->patient->gender}}</td>
                  </tr>
                 
                    <form action="{{ route('admin_report_add') }}" method="post" enctype="multipart/form-data" class="row p-0 m-0">
                        @csrf
                        <input type="hidden" name="id" value="{{$appointment->id}}">                        
                        <tr>
                            <td width="20%">
                                <label class="capitalize">Report type</label>
                            </td>
                            <td>                              
                                <div class="radio-toolbar form-check form-check-inline">
                                    @foreach($reports as $report)
                                        <div class="radio px-2">
                                            <input type="radio" id="{{$report->id}}" name="title" value="{{$report->name}}" required>
                                            <label for="{{$report->id}}">{{$report->name}}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td width="25%">
                            <label for="date" class="capitalize">Add report</label>
                            </td>
                            <td class="row p-0 m-0">                                
                                <input type="file" class="form-control col-7 p-1" name="file" placeholder="Upload file" required/>                            
                                
                                <button type="submit" class="btn btn-success ml-2 col-auto">
                                <i class="fas fa-calendar-plus nav-icon"></i> &nbsp; Add report
                                </button>
                            </td>
                        </tr>                        
                    </form>
               </table>             
            </div>
            <div class="row">
               <a href="{{ route('all.appointment') }}" class="btn btn-primary col-auto m-2 ml-4">
                  <i class="fas fa-arrow-circle-left nav-icon"></i>   &nbsp;
                  Back previous page
               </a>
            </div>
         </div>
      </div>
   </div>
</div>

@endsection
@section('js')
@endsection