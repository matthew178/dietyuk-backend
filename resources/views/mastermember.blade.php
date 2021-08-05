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
                        <h1>Master Member</h1><br>
                        <form action="/dietyuk/public/searchMember" method="post" class="form-inline">
                            @csrf
                            <input type="text" class="form-control" id="cari" name="cari" placeholder="Cari Member">
                            <input type="submit" class= "btn btn-primary" value="Cari">
                        </form><br>
                        <div class="table-responsive" id="sailorTableArea">
                            <table id="sailorTable" class="table table-striped table-bordered" width="100%">
                                <thead>
                                    <tr>
                                        <th>Username</th>
                                        <th>Nama</th>
                                        <th>Jenis Kelamin</th>
                                        <th>Nomor HP</th>
                                        {{-- <th>Tanggal Lahir</th> --}}
                                        <th>Role</th>
                                        <th>Saldo</th>
                                        <th>Rating</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $jum = count($member);
                                    @endphp
                                    @for ($i = 0; $i < $jum; $i++)
                                        <tr>
                                            <td>
                                               <span style="font-size: 14px;">Username : </span><span style="font-size: 13px; ">{{$member[$i]->username}}</span>
                                                <br>
                                                <span style="font-size: 13px;">Email : </span><span style="font-size: 13px; color:red;">{{$member[$i]->email}}</span>
                                            </td>
                                            <td>{{$member[$i]->nama}}</td>
                                            <td>{{$member[$i]->jeniskelamin}}</td>
                                            <td>{{$member[$i]->nomorhp}}</td>
                                            {{-- <td>{{$member[$i]->tanggallahir}}</td> --}}
                                            <td>{{$member[$i]->role}}</td>
                                            <td>{{"Rp.".$member[$i]->saldo}}</td>
                                            <td>{{$member[$i]->rating}} <span><img src="{{asset('bfull.png')}}" style="height: 20px; width:20px;"></span></td>
                                            @if ($member[$i]->status == "Aktif")
                                                <td style="color: green">{{$member[$i]->status}}</td>
                                            @else
                                                @if ($member[$i]->status == "Tidak Aktif")
                                                    <td style="color: red">Block</td>
                                                @else
                                                    <td style="color: blue">Pending</td>
                                                @endif
                                            @endif
                                            @if ($member[$i]->status == "Aktif")
                                                <td><a href="/dietyuk/public/block/{{$member[$i]->id}}"><button type="button" class="btn btn-primary">Block</button></a></td>
                                            @else
                                                @if ($member[$i]->status == "Tidak Aktif")
                                                    <td><a href="/dietyuk/public/aktifkan/{{$member[$i]->id}}"><button type="button" class="btn btn-primary">Aktifkan</button></a></td>
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
