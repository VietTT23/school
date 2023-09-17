@extends('layout.app')

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{ $title }}</h1>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main content -->
        <div class="card card-primary">

            <!-- /.card-header -->
            <!-- form start -->
            <form action="{{ route('admin.class.store') }}" method="post">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Class Name</label>
                        <input type="text" name="name" class="form-control" id="name" placeholder="Class Name">
                        <div style="color: brown">{{ $errors->first('name') }}</div>
                    </div>
                    <div class="form-group">
                        <label for="email">Status</label>
                        <select name="status" id="status" class="form-control">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </form>
        </div>
        <!-- /.content -->
    </div>

@endsection
