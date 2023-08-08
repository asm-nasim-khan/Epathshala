@extends('master')
@section('content')
<div class="container">
   <div class="row">
       <div class="col-sm-6">
       </div>
       <div class="col-sm-6">
           <a href="/">Go Back</a>
       <h2>{{$profile['name']}}</h2>
       <h5>{{$profile['email']}}</h5>

       <form action="/addfriend" method="POST">
           @csrf
           <input type="hidden" name="email" value= {{ $profile['email'] }}>
       <button class="btn btn-primary">Add as Friend</button>
       </form>
       <br><br>
    </div>
   </div>
</div>    
@endsection
