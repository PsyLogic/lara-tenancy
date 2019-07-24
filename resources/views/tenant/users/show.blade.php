@extends('tenant.layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        @include('tenant.layout.alert')
        <div class="col-md-4">
            <h4>Just for Demonstration purpose</h4>
            <div class="card profile-card-3">
                <div class="background-block">
                    <img src="https://images.pexels.com/photos/459225/pexels-photo-459225.jpeg?auto=compress&cs=tinysrgb&h=650&w=940"
                        alt="profile-sample1" class="background" />
                </div>
                <div class="profile-thumb-block">
                    <img src="https://i0.wp.com/www.winhelponline.com/blog/wp-content/uploads/2017/12/user.png?resize=256%2C256&quality=100&ssl=1"
                        alt="profile-image" class="profile" />
                </div>
                <div class="card-content">
                        <h2>{{$user->name}}<small>Designer</small></h3>
                        <div class="icon-block"><a href="#"><i class="fab fa-facebook"></i></a><a href="#"> <i class="fab fa-twitter"></i></a><a href="#"> <i class="fab fa-google-plus"></i></a></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
