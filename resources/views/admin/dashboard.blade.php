@extends('admin.layout.main')

@section('title', 'Dashboard')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <h1>Selamat datang, {{ Auth::user()->nama }}</h1>
            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
@endsection