@extends("layout2");

<!DOCTYPE html>
<html lang="en">
<head>
    <script src='https://code.jquery.com/jquery-3.5.1.js'></script>
    <script src='https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js'></script>
    <link href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <title>Admin</title>
</head>

@section("isipage")
    <h1>Laporan Penjualan Produk</h1>
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

    <br>
    <h1>Transaksi Bulan <span id="tampilbulan">Januari</span> Tahun <span id="tampiltahun">{{$tahun}}</span></h1><br>
    <div class="tabeldetail">
        <div class="table-responsive" id="sailorTableArea">
            <table id="sailorTable" name="sailorTable" class="table table-striped table-bordered" width="100%">
                <thead><th>No. Pemesanan</th><th>Tanggal Pembelian</th><th>Total</th><th>Keuntungan</th></thead>
            </table>
        </div>
    </div>
    <div><h1>Total Keuntungan : <span id="totkeuntungan">Rp. 0</span></h1></div>
    <br><br><br><br><br><br><br><br><br><br>
@endsection

<script language='javascript'>
    $(document).ready(function(){
        $('#sailorTable').DataTable();
        var sekarang = new Date();
        var tb = "<thead><th>No. Pemesanan</th><th>Tanggal Pembelian</th><th>Total</th><th>Keuntungan</th></thead><tbody>";
        $.ajax({
            type:'get',
            url:`{!!URL::to('detailbulanproduk')!!}/${sekarang.getFullYear()}/${sekarang.getMonth()+1}`,
            // data:{'tahun':sekarang.getFullYear(), "bulan":sekarang.getMonth()+1},
            success:function(data){
                var untung = 0;
                for(var i = 0; i < data.length; i++){
                    untung = untung + (data[i].total*0.02);
                    var num = numeral(data[i].total).format('0,0');
                    var fmt = numeral((data[i].total*0.02)).format('0,0');
                    tb+="<tr><td>#"+data[i].nopesanan+"</td><td>"+data[i].waktubeli+"</td><td>Rp. "+num+"</td><td>Rp. "+fmt+"</td>";
                    tb+="</tr>";
                }
                var numfmt = numeral(untung).format('0,0');
                $("#sailorTable").html(tb);
                $("#totkeuntungan").html("Rp. " +numfmt);
                console.log("ini tb : " + tb);
                console.log("ini data " + data);
            },
            error:function(err){
                console.log(err);
            }
        });
        $("#tahuns").on('change', function() {
            var tahun = $("#tahuns").val();
            var id = $("#bulans").val();
            var bulan = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
            var jum = parseInt(id)-1;
            $('#tampiltahun').html(tahun);
            var tb = "<thead><th>No. Pemesanan</th><th>Tanggal Pembelian</th><th>Total</th><th>Keuntungan</th></thead><tbody>";
            $.ajax({
                type:'get',
                url:`{!!URL::to('detailbulanproduk')!!}/${tahun}/${id}`,
                // data:{'tahun':sekarang.getFullYear(), "bulan":sekarang.getMonth()+1},
                success:function(data){
                    var untung = 0;
                    for(var i = 0; i < data.length; i++){
                        untung = untung + (data[i].total*0.02);
                        var num = numeral(data[i].total).format('0,0');
                        var fmt = numeral((data[i].total*0.02)).format('0,0');
                        tb+="<tr><td>#"+data[i].nopesanan+"</td><td>"+data[i].waktubeli+"</td><td>Rp. "+num+"</td><td>Rp. "+fmt+"</td>";
                        tb+="</tr>";
                    }
                    var numfmt = numeral(untung).format('0,0');
                    $("#sailorTable").html(tb);
                    $("#totkeuntungan").html("Rp. " +numfmt);
                    console.log("ini tb : " + tb);
                    console.log("ini data " + data);
                    console.log(`{!!URL::to('detailbulanproduk')!!}/${sekarang.getFullYear()}/${sekarang.getMonth()+1}`);
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
            var tb = "<thead><th>No. Pemesanan</th><th>Tanggal Pembelian</th><th>Total</th><th>Keuntungan</th></thead><tbody>";
            $.ajax({
                type:'get',
                url:`{!!URL::to('detailbulanproduk')!!}/${tahun}/${id}`,
                // data:{'tahun':sekarang.getFullYear(), "bulan":sekarang.getMonth()+1},
                success:function(data){
                    var untung = 0;
                    for(var i = 0; i < data.length; i++){
                        untung = untung + (data[i].total*0.02);
                        var num = numeral(data[i].total).format('0,0');
                        var fmt = numeral((data[i].total*0.02)).format('0,0');
                        tb+="<tr><td>#"+data[i].nopesanan+"</td><td>"+data[i].waktubeli+"</td><td>Rp. "+num+"</td><td>Rp. "+fmt+"</td>";
                        tb+="</tr>";
                    }
                    var numfmt = numeral(untung).format('0,0');
                    $("#sailorTable").html(tb);
                    $("#totkeuntungan").html("Rp. " +numfmt);
                    console.log("ini tb : " + tb);
                    console.log("ini data " + data);
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
