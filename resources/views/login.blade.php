@extends('master')
@section('content')
<div class="container custom-login">
    <div class="row">
        <div class="col-sm-4 col-sm-offset-4">
            <form>
            <div class="form-group">
                <label for="exampleInputEmail1">Email</label>
                <input type="email" class="form-control" placeholder="Email" id="exampleInputEmail1">
            </div>

            <div class="form-group">
                <label for="exampleInputpassword1">Password</label>
                <input type="password" class="form-control" placeholder="Password" id="exampleInputpassword1">
            </div>
            <button type="submit" class=btn btn-default>
                Submit
            </button>
            </form>

        </div>
    </div>
</div>
<!--
<label for="basic-url">Your vanity URL</label>
<div class="input-group">
  <span class="input-group-addon" id="basic-addon3">https://example.com/users/</span>
  <input type="text" class="form-control" id="basic-url" aria-describedby="basic-addon3">
</div> -->
@endsection
