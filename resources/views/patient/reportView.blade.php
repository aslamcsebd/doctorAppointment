@extends('layouts.app')
   @section('title') Single report @endsection
@section('content')
@include('includes.alertMessage')
<div class="content-wrapper p-3 view">
   <div class="row justify-content-center">
      <div class="col-md-10">
         <div class="card">
            <h6 class="card-header bg-success text-center py-2">Single report</h6>
            <div class="card-body">
               <table class="table table-bordered">                  
                  <tr>
                     <td colspan="2">
                        <div class="text-center">
                           <img src="{{asset('')}}/{{$report->photo ?? 'images/default.jpg'}}" class="img-thumbnail" alt="No Image found" width="100">
                           <br>
                           <span>{{$report->user->name}}</span>                         
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <td width="20%">
                        <label class="capitalize">Email</label>
                     </td>
                     <td>{{$report->user->email}}</td>
                  </tr>
                  <tr>
                     <td width="20%">
                        <label class="capitalize">Phone</label>
                     </td>
                     <td>{{$report->user->phone}}</td>
                  </tr>
                  <tr>
                     <td width="20%">
                        <label class="capitalize">Title</label>
                     </td>
                     <td>{{$report->title}}</td>
                  </tr>
               </table>             
            </div>
            <div class="card-footer row justify-content-center">
               <a href="{{ route('report.list') }}" class="btn btn-primary col-auto">
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