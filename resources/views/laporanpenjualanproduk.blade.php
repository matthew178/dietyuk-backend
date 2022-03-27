@extends("layout2");

<!DOCTYPE html>
<html lang="en">
<head>
    {{-- <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script> --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
    // google.charts.load('current', {'packages':['corechart']});
    //   google.charts.setOnLoadCallback(drawChart);

    //   function drawChart() {
    //     var data = google.visualization.arrayToDataTable([
    //       ['Bulan', 'Jumlah Penjualan'],

    //     ]);

    //     var options = {
    //     //   title: 'Laporan Penjualan Paket Tahun {{$tahun}}',
    //       curveType: 'function',
    //       legend: { position: 'bottom' }
    //     };

    //     var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

    //     chart.draw(data, options);
    //   }
    // </script>
    <title>Admin</title>
</head>

@section("isipage")
    <h1>Laporan Penjualan Paket</h1>
    <input type="hidden" name="temp" value="{{$tahun}}" id="temp">
    <form action="/public/detaillaporan" method="post">
        <div class="bulan" style="font-size: 25px"><span>Bulan :</span>
            <select name="bulans" id="bulans" class="bulans" style="width:150px;">
                <option value="1">Januari</option>
                <option value="2">Februari</option>
                <option value="3">Maret</option>
                <option value="4">April</option>
                <option value="5">Mei</option>
                <option value="6">Juni</option>
                <option value="7">Juli</option>
                <option value="8">Agustus</option>
                <option value="9">September</option>
                <option value="10">Oktober</option>
                <option value="11">November</option>
                <option value="12">Desember</option>
            </select>
        </div>
    </form>
    <div class="tahun" style="font-size: 25px"><span>Tahun :</span>
        <select name="tahuns" id="tahuns" class="tahuns" style="width:100px;">
        @foreach ($datatahun as $val)
            <option value="{{$val->tahun}}" style="font-size: 25px">{{$val->tahun}}</option>
        @endforeach
        </select>
    </div>
    {{-- <div id="curve_chart" style="width: 1250px; height: 500px"></div> --}}
    {{-- <br><br><br> --}}

    <br>
    <h1>Transaksi Bulan <span id="tampilbulan">Januari</span> Tahun <span id="tampiltahun">{{$tahun}}</span></h1><br>
    <div class="tabeldetail">
        <div class="table-responsive" id="sailorTableArea">
            <table id="sailorTable" name="sailorTable" class="table table-striped table-bordered" width="100%">
                <thead><th>No. Pemesanan</th><th>Konsultan</th><th>Tanggal Pembelian</th><th>Total</th></thead>
            </table>
        </div>
    </div>
    <br><br><br><br><br><br><br><br><br><br>
@endsection

<script language='javascript'>
    $(document).ready(function(){
        var sekarang = new Date();
        var tb = "<thead><th>No. Pemesanan</th><th>Konsultan</th><th>Waktu Penjualan</th><th>Total</th><th>Keuntungan</th></thead><tbody>";
        $.ajax({
            type:'get',
            url:'{!!URL::to('detailbulanproduk')!!}',
            data:{'tahun':sekarang.getFullYear(), "bulan":sekarang.getMonth()+1},
            success:function(data){
                for(var i = 0; i < data.length; i++){
                    tb+="<tr><td>"+data[i].nopesanan+"</td><td>"+data[i].username+"</td><td>"+data[i].waktubeli+"</td><td>"+data[i].total+"</td><td>0</td>";
                    tb+="</tr>";
                }
                $("#sailorTable").html(tb);
            },
            error:function(err){
                console.log(err);
            }
        });
        $("#tahuns").on('change', function() {
            var tahun = $("#tahuns").val();
            var id = $(this).val();
            var bulan = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
            var jum = parseInt(id)-1;
            $('#tampiltahun').html(tahun);
            var tb = "<thead><th>Nama Paket</th><th>Konsultan</th><th>Tanggal Penjualan</th><th>Total</th><th>Keuntungan</th></thead><tbody>";
            $.ajax({
                type:'get',
                url:'{!!URL::to('detailbulanproduk')!!}',
                data:{'tahun':tahun, "bulan":id},
                success:function(data){
                    for(var i = 0; i < data.length; i++){
                        tb+="<tr><td>"+data[i].nama_paket+"</td><td>"+data[i].username+"</td><td>"+data[i].tanggalselesai+"</td><td>"+data[i].totalharga+"</td><td>0</td>";
                        tb+="</tr>";
                    }
                    $("#sailorTable").html(tb);
                },
                error:function(err){
                    console.log(err);
                }
            });
        });
        $('#bulans').on('change', function(){
            var tahun = $("#tahuns").val();
            var id = $(this).val();
            var bulan = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
            var jum = parseInt(id)-1;
            $('#tampilbulan').html(bulan[jum]);
            var tb = "<thead><th>Nama Paket</th><th>Konsultan</th><th>Tanggal Penjualan</th><th>Total</th><th>Keuntungan</th></thead><tbody>";
            $.ajax({
                type:'get',
                url:'{!!URL::to('detailbulanproduk')!!}',
                data:{'tahun':tahun, "bulan":id},
                success:function(data){
                    for(var i = 0; i < data.length; i++){
                        tb+="<tr><td>"+data[i].nama_paket+"</td><td>"+data[i].username+"</td><td>"+data[i].tanggalselesai+"</td><td>"+data[i].totalharga+"</td><td>0</td>";
                        tb+="</tr>";
                    }
                    $("#sailorTable").html(tb);
                },
                error:function(err){
                    console.log(err);
                }
            });
        });

        $('[data-toggle="tooltip"]').tooltip();
        $(".side-nav .collapse").on("hide.bs.collapse", function() {
            $(this).prev().find(".fa").eq(1).removeClass("fa-angle-right").addClass("fa-angle-down");
        });
        $('.side-nav .collapse').on("show.bs.collapse", function() {
            $(this).prev().find(".fa").eq(1).removeClass("fa-angle-down").addClass("fa-angle-right");
        });
    });
</script>
