@extends("layout2");

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>

    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <script src='https://code.jquery.com/jquery-3.5.1.js'></script>
    <script src='https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js'></script>
    <title>Document</title>
</head>

@section("isipage")
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row" id="main" >
                <div class="col-sm-12 col-md-12 well" id="content">
                    <h1>Daftar Pengaduan</h1><br>
                    {{-- <form action="/public/searchPaket" method="post" class="form-inline">
                        @csrf
                        <input type="text" class="form-control" id="cari" name="cari" placeholder="Cari Paket">
                        <input type="submit" class= "btn btn-primary" value="Cari">
                    </form><br><br> --}}
                    <div class="table-responsive" id="sailorTableArea">
                        <table id="sailorTable" class="table table-striped table-bordered" width="100%">
                            <thead>
                                <tr>
                                    <th>Pelapor</th>
                                    <th>Konsultan</th>
                                    <th>Keterangan</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $jum = count($data);
                                @endphp
                                @for ($i = 0; $i < $jum; $i++)
                                    <tr>
                                        <td>{{$data[$i]->pelapor}}</td>
                                        <td>{{$data[$i]->konsultan}}</td>
                                        <td>{{$data[$i]->keterangan}}</td>
                                        <td><a href="/public/blockkonsultan/{{$data[$i]->id}}"><button type="button" class="btn btn-primary">Block Konsultan</button></a><a href="/public/ubahStatusReport/{{$data[$i]->id}}"><button type="button" class="btn btn-danger">X</button></a></td>
                                    </tr>
                                @endfor
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

</html>

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
