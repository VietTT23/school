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
            <form action="{{ route('admin.update', ['id'=>$admins->id]) }}" method="post">
                @csrf
                @method('put')
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" class="form-control" id="name" value="{{ old('name', $admins->name)  }}" placeholder="Name">
                        <div style="color: brown">{{ $errors->first('name') }}</div>
                    </div>
                    <div class="form-group">
                        <label for="email">Email address</label>
                        <input type="email" name="email" class="form-control" id="email" value="{{ $admins->email }}" placeholder="Email">
                        <div style="color: brown">{{ $errors->first('email') }}</div>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" class="form-control" id="password" placeholder="Password">
                        <p>Nếu muốn đổi mật khẩu, hãy nhập mật khẩu mới</p>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
        <!-- /.content -->
    </div>

@endsection
