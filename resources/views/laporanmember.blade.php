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
    <h1>Laporan Konsultan Terlaris</h1><br><br>
    <div class="tabeldetail">
        <div class="table-responsive" id="sailorTableArea">
            <table id="sailorTable" name="sailorTable" class="table table-striped table-bordered" width="100%">
                <thead><th>Konsultan</th><th>Jumlah Paket Yang Terjual</th></thead>
                <tbody>
                     @php
                        $jum = count($data);
                    @endphp
                    @for ($i = 0; $i < $jum; $i++)
                        <tr>
                            <td>{{$data[$i]->username}}</td>
                            <td>{{$data[$i]->jumlah}}</td>
                        </tr>
                    @endfor
                </tbody>
            </table>
        </div>
    </div>
    <br><br><br><br><br><br><br><br><br><br>
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
