@extends("layout2");

<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>

    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <script src='https://code.jquery.com/jquery-3.5.1.js'></script>
    <script src='https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js'></script>
    <title>Admin</title>
</head>

@section("isipage")
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row" id="main" >
                    <div class="col-sm-12 col-md-12 well" id="content">
                        <h1>Master Jenis Produk</h1><br><br>
                        <div class="table-responsive" id="sailorTableArea">
                            <table id="sailorTable" class="table table-striped table-bordered" width="100%">
                                <thead>
                                    <tr>
                                        <th>Kode Kategori</th>
                                        <th>Jenis Kategori</th>
                                        {{-- <th>Action</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $jum = count($kategori);
                                    @endphp
                                    @for ($i = 0; $i < $jum; $i++)
                                        <tr>
                                            <td>{{$kategori[$i]->kodekategori}}</td>
                                            <td>{{$kategori[$i]->namakategori}}</td>
                                            {{-- <td><a href=""><button type="button" class="btn btn-primary">Edit</button></a></td> --}}
                                        </tr>
                                    @endfor
                                </tbody>
                            </table>
                        </div><br><br><br>
                        <h1>Tambah Jenis Produk</h1>
                        <form action="/public/tambahjenisproduk" method="post">
                            @csrf
                            <label for="jenis">Nama Jenis Produk</label>
                            <input type="text" class="form-control" id="jenis" name="jenis"><br>
                            <input type="submit" class="btn btn-primary" value="Tambah">
                        </form>
                    </div>
                </div>
            </div>
        </div>
@endsection

<script language='javascript'>
    $(document).ready(function(){
		$('#sailorTable').DataTable();
        $('[data-toggle="tooltip"]').tooltip();
        $(".side-nav .collapse").on("hide.bs.collapse", function() {
            $(this).prev().find(".fa").eq(1).removeClass("fa-angle-right").addClass("fa-angle-down");
        });
        $('.side-nav .collapse').on("show.bs.collapse", function() {
            $(this).prev().find(".fa").eq(1).removeClass("fa-angle-down").addClass("fa-angle-right");
        });
    });
</script>
