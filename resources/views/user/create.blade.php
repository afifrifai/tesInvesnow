@extends('layouts.index')

@section('content')
<section class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        </div>
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('user') }}">User</a></li>
            <li class="breadcrumb-item active">Add</li>
        </ol>
        </div>
    </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <!-- general form elements -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Tambah User</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form role="form" action="{{ route('user.create') }}" method="post">
                        @method('post')
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="name">Nama</label>
                                <input type="text" name="name" class="form-control  @error('name') is-invalid @enderror" id="name" placeholder="Masukkan Nama" value="{{ old('name') }}" required autofocus>
                                @error('name')
                                <div class="invalid-feedback" style="color:red">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="Maukkan Email" value="{{ old('email') }}" required>
                                @error('email')
                                <div class="invalid-feedback" style="color:red">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="role">Role</label>
                                <select class="role-option form-control @error('role') is-invalid @enderror" multiple="multiple" name="role[]">                                            
                                    @foreach ($role as $role) 
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                                @error('role')
                                <div class="invalid-feedback" style="color:red">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="komda">Komda</label>
                                <select class="komda-option form-control @error('komda') is-invalid @enderror" name="komda">                                            
                                    @foreach ($komda as $komda) 
                                        <option value="{{ $komda->id }}">{{ $komda->name }}</option>
                                    @endforeach
                                </select>
                                @error('komda')
                                <div class="invalid-feedback" style="color:red">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="Password" value="{{ old('password') }}" required>
                                @error('password')
                                <div class="invalid-feedback" style="color:red">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
    <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</section>
<!-- /.content -->

@push('scripts')
<script>
    $(".role-option").select2();
    // $(".komda-option").select2();
</script>
@endpush

@endsection