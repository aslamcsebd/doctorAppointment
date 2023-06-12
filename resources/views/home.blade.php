@extends('layouts.app')

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

               <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 col-12">
                  <div class="small-box bg-info">
                     <div class="inner text-center">
                        <p>Demo</p>
                     </div>
                     <div class="icon">
                        <i class="ion ion-bag"></i>
                     </div>
                     <a href="{{ url('/') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                  </div>
               </div>
            </div>           
         </div>
      </section>
   </div> 
@endsection