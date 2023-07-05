@extends('layouts.app')
@section('title') Hospital @endsection

@section('content')   
   <div class="content-wrapper">
      <div class="content-header">
         <div class="container-fluid">
            <div class="row mb-2">
               <div class="col-sm-6"><h1 class="m-0 text-dark">Dashboard</h1></div>
               <div class="col-sm-6">
                  <ol class="breadcrumb float-sm-right">
                     <li class="breadcrumb-item"><a href="#">Home</a></li>
                     <li class="breadcrumb-item active">Dashboard</li>
                  </ol>
               </div>
            </div>
         </div>   
      </div>

      <section class="content">
         <div class="container-fluid">
            <div class="row">
               @if(Auth::user()->role==1)

                  <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 col-12">
                     <div class="small-box bg-info">
                        <div class="inner text-center">
                           <h3>{{$doctors->count() ?? '0'}}</h3> 
                           <span>
                              <i class="fas fa-user-md mr-2"></i>
                              All doctor
                           </span>
                        </div>                        
                        <a href="{{ route('doctor.list') }}" class="small-box-footer">
                           More info
                           <i class="fas fa-arrow-circle-right"></i>
                        </a>
                     </div>
                  </div>

                  <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 col-12">
                     <div class="small-box bg-primary">
                        <div class="inner text-center">
                           <table class="table table-bordered">
                              <tbody>
                                 <tr class="bg-primary">
                                    <td>Floor</td>
                                    <td>Cabin</td>
                                    <td>Ward</td>
                                 </tr>
                                 <tr class="bg-primary">
                                    <td>{{$floors->count() ?? '0'}}</td>
                                    <td>{{$cabins->count() ?? '0'}}</td>
                                    <td>{{$wards->count() ?? '0'}}</td>
                                 </tr>
                              </tbody>
                           </table>
                        </div>                        
                        <a href="{{ route('room') }}" class="small-box-footer">
                           More info
                           <i class="fas fa-arrow-circle-right"></i>
                        </a>
                     </div>
                  </div>

               @endif               
            </div>           
         </div>
      </section>
   </div> 
@endsection