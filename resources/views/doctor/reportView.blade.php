@extends('layouts.app')
   @section('title') Report list @endsection
@section('content')
@include('includes.alertMessage')

<div class="content-wrapper p-3">
   <div class="row justify-content-center">
      <div class="col-md-12">        
         <div class="card">
            <div class="card-body p-1">
               <table class="table table-bordered">
                  <thead class="bg-info">
                     <th>Sl</th>
                     <th>Title</th>
                     <th>Date</th>
                     <th>File</th>
                  </thead>
                  <tbody>
                     @foreach($reports as $report)
                        <tr>
                           <td width="30">{{$loop->iteration}}</td>
                           <td>
                              <span>{!!$report->title!!}</span>
                           </td>                        
                           <td>{!!$report->date!!}</td>
                           <td>
                              <a href="{{asset('')}}/{{$report->file}}" class="btn btn-large pull-right" target="_blank" download="">
                                 <i class="fas fa-download pr-2"></i>Download
                              </a>
                            </td>
                        </tr>
                     @endforeach
                  </tbody>
               </table>

               <a href="{{ route('patient.list') }}" class="btn btn-primary col-auto mt-2">
                  <i class="fas fa-arrow-circle-left nav-icon"></i> &nbsp;
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
