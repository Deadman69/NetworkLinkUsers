@extends('layout.default')
@section('title') Login @endsection

@section('top-css')
   <style>
       body {
           background-color: #f2f2f2;
           font-family: Arial, sans-serif;
       }
       form {
           background-color: #fff;
           border-radius: 5px;
           box-shadow: 0px 0px 5px #ccc;
           padding: 20px;
           margin: 20px auto;
           max-width: 400px;
       }
       input[type="text"], input[type="password"] {
           display: block;
           margin-bottom: 10px;
           padding: 10px;
           width: 100%;
           border: 1px solid #ccc;
           border-radius: 5px;
           box-sizing: border-box;
           font-size: 16px;
           color: #555;
       }
       input[type="submit"] {
           background-color: #4CAF50;
           border: none;
           color: #fff;
           cursor: pointer;
           font-size: 16px;
           padding: 10px;
           width: 100%;
           border-radius: 5px;
       }
       input[type="submit"]:hover {
           background-color: #3e8e41;
       }
       h1 {
           text-align: center;
       }
   </style>
@endsection

@section('content')
    <form method="POST" action="{{ route('login.post') }}">
        @csrf
        <h1>Login</h1>
        <input type="text" name="username" placeholder="Username">
        <input type="password" name="password" placeholder="Password">
        <input type="submit" value="Login">
        @if ($errors->has('password'))
            <span class="text-danger text-left">{{ $errors->first('password') }}</span>
        @endif
    </form>
@endsection

@section('bottom-scripts')

@endsection
