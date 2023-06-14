@extends('layouts.master')

@section('title', 'Tambah Permissio')

@section('content')
    <form action="{{ route('admin.permission.store') }}" method="post" id="createData">
        <div class="container-fluid">
            <div class="row pt-30">
                @foreach ($routeList as $key => $route)
                    @csrf
                    <div class="col-4 p-1">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="mb-2">{{ $key }}</h5>
                                @foreach ($route as $r)
                                    <div>
                                        <input @disabled(in_array($r['uniqueCode'], $permission)) @checked(in_array($r['uniqueCode'], $permission)) type="checkbox"
                                            name="permissions[]" value="{{ $r['uniqueCode'] }}" class="form-check-input"
                                            id="{{ $r['uniqueCode'] }}">
                                        <label for="{{ $r['uniqueCode'] }}">{{ $r['uniqueCode'] }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <button class="main-btn primary-btn btn-hover btn-sm" id="#submit">Submit</button>
        </div>
    </form>
@endsection