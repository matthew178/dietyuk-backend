@extends("layout2");

<!DOCTYPE html>
<html lang="en">
<head>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <title>Admin</title>
</head>

@section("isipage")
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row" id="main" >
                    <div class="col-sm-12 col-md-12 well" id="content">
                        <h1>Master Jenis Paket</h1>
                        <div class="table-responsive" id="sailorTableArea">
                            <table id="sailorTable" class="table table-striped table-bordered" width="100%">
                                <thead>
                                    <tr>
                                        <th>Kode Jenis Paket</th>
                                        <th>Nama Jenis Paket</th>
                                        <th>Deskripsi Jenis Paket</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $jum = count($jenis);
                                    @endphp
                                    @for ($i = 0; $i < $jum; $i++)
                                        <tr>
                                            <td>{{$jenis[$i]->idjenispaket}}</td>
                                            <td>{{$jenis[$i]->namajenispaket}}</td>
                                            <td style="text-align: justify">{{$jenis[$i]->deskripsijenis}}</td>
                                            <td><a href=""><button type="button" class="btn btn-primary">Edit</button></a></td>
                                        </tr>
                                    @endfor
                                </tbody>
                            </table>
                        </div><br><br><br>
                        <h1>Tambah Jenis Paket</h1>
                        <form action="/public/tambahjenispaket" method="post">
                            @csrf
                            <label for="namajenis">Nama Jenis Paket</label>
                            <input type="text" class="form-control" name="namajenis" id="namajenis"><br>
                            <label for="deskripsi">Deskripsi Jenis Paket</label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"></textarea><br>
                            Background : <input type="file" class="" name="background" id="background"><br><br>
                            <input type="submit" class="btn btn-primary" value="Tambah">
                        </form>
                    </div>
                </div>
            </div>
        </div>
@endsection

<script language='javascript'>
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
        $(".side-nav .collapse").on("hide.bs.collapse", function() {
            $(this).prev().find(".fa").eq(1).removeClass("fa-angle-right").addClass("fa-angle-down");
        });
        $('.side-nav .collapse').on("show.bs.collapse", function() {
            $(this).prev().find(".fa").eq(1).removeClass("fa-angle-down").addClass("fa-angle-right");
        });
    });
</script>
