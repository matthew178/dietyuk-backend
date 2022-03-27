@extends("layout2");

<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    {{-- <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script> --}}
    <title>Admin</title>
</head>

@section("isipage")
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row" id="main" >
                    <div class="col-sm-12 col-md-12 well" id="content">
                        <h1>Konfirmasi Penarikan Saldo</h1>
                        <div class="table-responsive" id="sailorTableArea">
                            <table id="sailorTable" class="table table-striped table-bordered" width="100%">
                                <thead>
                                    <tr>
                                        <th>Username</th>
                                        <th>Jumlah Penarikan</th>
                                        <th>Waktu</th>
                                        <th>Bank</th>
                                        <th>Nomor Rekening</th>
                                        <th>Atas Nama</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $jum = count($saldo);
                                    @endphp
                                    @for ($i = 0; $i < $jum; $i++)
                                        <tr>

                                                <td>{{$saldo[$i]->username}}</td>
                                                <td>Rp {{number_format($saldo[$i]->saldo,2,',','.')}}</td>
                                                <td>{{$saldo[$i]->waktu}}</td>
                                                <td>{{$saldo[$i]->bank}}</td>
                                                <td>{{$saldo[$i]->nomorrekening}}</td>
                                                <td>{{$saldo[$i]->atasnama}}</td>
                                            <form action="/public/konfirmasipenarikan" method="post">
                                                @csrf
                                                <input type="hidden" name="id" value="{{$saldo[$i]->id}}">
                                                <td ><input type="submit" value="Konfirmasi" class='btn btn-primary'></td>
                                            </form>
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
