@extends('master')
@section('content')
<div class="container">
   <div class="row">
       <div class="col-sm-6">
       </div>
       <div class="col-sm-6">
           <a href="/">Go Back</a>
       <h2>{{$userProfile['name']}}</h2>
       <h5>{{$userProfile['email']}}</h5>

    </div>
   </div>
</div>    
@endsection
