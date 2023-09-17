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
                    <div class="col-sm-6" style="text-align: right">
                        <a href="{{ route('admin.subject.create') }}" class="btn btn-primary">Add new subject</a>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="card card-primary">
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form action="" method="get">
                        <div class="card-header">
                            <h3 class="card-title">Search</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-8">
                                    <input type="text" name="q" class="form-control" id="q" value="{{ $search }}" placeholder="search....">
                                    <p>Tìm kiếm theo tên, trạng thái, người tạo </p>
                                </div>
                                <div class="form-group col-md-3">
                                    <button class="btn btn-primary" type="submit">Search</button>
                                </div>

                            </div>

                        </div>
                        <!-- /.card-body -->
                    </form>
                </div>
                <div class="row">
                    <!-- /.col -->
                    <div class="col-md-12">
                        @include('_message')
                        <!-- /.card -->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Subject List (Total: {{ $subjects->total() }})</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body p-0">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Name</th>
                                        <th>Type</th>
                                        <th>Status</th>
                                        <th>Created By</th>
                                        <th>Time Create</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($subjects as $subject)
                                        <tr>
                                            <td>{{ $subject->id }}</td>
                                            <td>{{ $subject->name }}</td>
                                            <td>{{ $subject->type }}</td>
                                            <td>{{ $subject->status }}</td>
                                            <td>{{ $subject->create_by_user }}</td>
                                            <td>{{ $subject->created_at->diffForHumans() }}</td>
                                            <td>
                                                <div class="container-fluid">
                                                    <div class="row mb-2">
                                                        <div class="col-sm-2">
                                                            <a href="{{ route('admin.subject.edit', ['id'=>$subject->id]) }}" class="btn btn-primary">Edit</a>
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <form action="{{ route('admin.subject.delete', ['id'=>$subject->id]) }}" method="post">
                                                                @csrf
                                                                @method('put')
                                                                <button class="btn btn-danger">Delete</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>


                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <div style="padding: 10px; float: right">
                                    {!! $page !!}
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>

            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>

@endsection
