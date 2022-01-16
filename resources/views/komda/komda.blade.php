@extends('layouts.index')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        </div>
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Komda</li>
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
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h5><i class="icon fas fa-check"></i> Success</h5>
                        {{ session('success') }}
                        
                    </div>
                @endif  
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Daftar Komda</h3>
                    </div>
                    <!-- /.card-header --> 
                    
                    <div class="card-body">
                        <a href="{{ route('komda.create') }}" style="position: absolute; z-index: 999;"><button class="btn btn-success"><i class="fa fa-plus"></i> Tambah Komda</button></a>
                        <table id="example2" class="table table-bordered table-hover" style="margin-top: -2%;">
                            <thead>
                                <tr>
                                <th>No. </th>
                                <th>Nama</th>
                                <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $no=0;
                                @endphp                            
                                @foreach ($komda as $komda)                                
                                <tr> 
                                    <td>{{ ++$no }}</td>  
                                    <td>{{ $komda->name }}</td> 
                                    <td>    
                                        <a href="{{ route('komda.edit', $komda->id) }}" class="btn btn-info btn-sm"> Edit </a>
                                        <form method="post" action="{{ route('komda.destroy', $komda->id) }}" class="d-inline" onsubmit="return confirm('Delete this komda permanently?')">       
                                            @method('delete')
                                            @csrf                 
                                            <input type="submit" value="Delete" class="btn btn-danger btn-sm">
                                        </form>                        
                                    </td>                    
                                </tr>               
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
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
<script>
$(document).ready( function () {
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
});
</script>
@endsection

