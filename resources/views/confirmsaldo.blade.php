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
                        <h1>Konfirmasi TopUp Saldo</h1>
                        <div class="table-responsive" id="sailorTableArea">
                            <table id="sailorTable" class="table table-striped table-bordered" width="100%">
                                <thead>
                                    <tr>
                                        <th>Username</th>
                                        <th>Jumlah Topup</th>
                                        <th>Waktu</th>
                                        <th>Bank</th>
                                        <th>Bukti Transfer</th>
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
                                                <td ><a href="/public/gambar/buktitransfer/{{$saldo[$i]->buktitransfer}}">Lihat</a></td>
                                            <form action="/public/konfirmasisaldo" method="post">
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
