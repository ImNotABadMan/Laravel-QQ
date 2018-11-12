@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dashboard</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <div class="col-md-12 text-center">
                            <img src="{{ $user['avatar'] }}" alt="">
                        </div>
                        <div class="col-md-12 text-center">
                            <div class="col-md-12">
                                <span class="col-md-6">Nickname</span>
                                <span class="col-md-6">{{ $user['name'] }}</span>
                            </div>
                            <div class="col-md-12">
                                <span class="col-md-6 text-right">Gender</span>
                                <span class="col-md-6">{{ $user['gender'] }}</span>
                            </div>
                            <div class="col-md-12">
                                <span class="col-md-6 text-right">Province</span>
                                <span class="col-md-6">{{ $user['province'] }}</span>
                            </div>
                            <div class="col-md-12">
                                <span class="col-md-6 text-right">City</span>
                                <span class="col-md-6">{{ $user['city'] }}</span>
                            </div>
                            <div class="col-md-12">
                                <span class="col-md-6 text-right">Year</span>
                                <span class="col-md-6">{{ $user['year'] }}</span>
                            </div>
                            <div class="col-md-12">
                                <span class="col-md-6 text-right">黄钻会员：</span>
                                <span class="col-md-6">{{ $user['is_yellow_vip'] ? '是' : '否'  }}</span>
                            </div>
                        </div>
                        You are logged in!
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
