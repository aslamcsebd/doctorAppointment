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
                     <th>Name</th>
                     <th>Title</th>
                     <th>Date</th>
                     <th>File</th>
                     <th>Action</th>
                  </thead>
                  <tbody>
                     @foreach($reports as $report)
                        <tr>
                           <td width="30">{{$loop->iteration}}</td>
                           <td>
                              <img src="{{asset('')}}/{{$report->photo ?? 'images/default.jpg'}}" class="img-thumbnail" alt="No Image found" width="60">
                              <br>
                              <span class="singerName">{!!$report->user->name!!}</span>
                           </td>                        
                           <td>{!!$report->title!!}</td>
                           <td>
                                {!!$report->date!!} <br>
                                ({{\Carbon\Carbon::parse($report->date)->diff(\Carbon\Carbon::now())->format('%y years %m months')}} ago)
                           </td>                          
                           <td>{!!$report->file!!}</td>                          

                           <td width="auto">
                              <div class="btn-group">
                                    <a href="{{ url('report-view', [$report->id]) }}" class="btn btn-sm btn-info py-1">View</a>
                              </div>
                           </td>
                        </tr>
                     @endforeach
                  </tbody>
               </table>
            </div>                   
         </div>
      </div>
   </div>
</div>

@endsection

@section('js')
@endsection
