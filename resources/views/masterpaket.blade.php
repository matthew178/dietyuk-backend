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
                        <h1>Master Paket</h1><br>
                        <form action="/public/searchPaket" method="post" class="form-inline">
                            @csrf
                            <input type="text" class="form-control" id="cari" name="cari" placeholder="Cari Paket">
                            <input type="submit" class= "btn btn-primary" value="Cari">
                        </form><br><br>
                        <div class="table-responsive" id="sailorTableArea">
                            <table id="sailorTable" class="table table-striped table-bordered" width="100%">
                                <thead>
                                    <tr>
                                        <th>Nama Paket</th>
                                        <th>Rating Paket</th>
                                        <th>Konsultan</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $jum = count($paket);
                                    @endphp
                                    @for ($i = 0; $i < $jum; $i++)
                                        <tr>
                                            <td>{{$paket[$i]->nama_paket}}</td>
                                            <td>{{$paket[$i]->rating}}</td>
                                            <td>{{$paket[$i]->nama}}</td>
                                            @if ($paket[$i]->status == 0)
                                                <td style="color: slategray">Tidak Aktif</td>
                                            @else
                                                @if ($paket[$i]->status == 1)
                                                    <td style="color: green">Aktif</td>
                                                @else
                                                    @if ($paket[$i]->status == 2)
                                                        <td style="color: red">Block</td>
                                                    @else
                                                        <td style="color: slategray">Belum Siap</td>
                                                    @endif
                                                @endif
                                            @endif
                                            @if ($paket[$i]->status == 1)
                                                <td><a href="/public/blockpaket/{{$paket[$i]->id_paket}}"><button type="button" class="btn btn-primary">Block</button></a></td>
                                            @else
                                                @if ($paket[$i]->status == 2)
                                                    <td><a href="/public/aktifkanpaket/{{$paket[$i]->id_paket}}"><button type="button" class="btn btn-primary">Aktifkan</button></a></td>
                                                @else
                                                <td></td>
                                                @endif
                                            @endif

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
