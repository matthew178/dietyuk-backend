<!DOCTYPE html>
<html lang="en">
<head>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>

    <title>Admin</title>
</head>
<body>
    <div id="throbber" style="display:none; min-height:120px;"></div>
    <div id="noty-holder"></div>
    <div id="wrapper">
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/public/admin">
                    <img src="{{asset('Dietyuk.png')}}" style="width:175px; height:50px" alt="LOGO">
                </a>
            </div>
            <ul class="nav navbar-right top-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Admin User <b class="fa fa-angle-down"></b></a>
                    <ul class="dropdown-menu">
                        {{-- <li><a href="#"><i class="fa fa-fw fa-cog"></i> Change Password</a></li>
                        <li class="divider"></li> --}}
                        <li><a href="/public/logoutadmin"><i class="fa fa-fw fa-power-off"></i> Logout</a></li>
                    </ul>
                </li>
            </ul>
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <li>
                        <a href="#" data-toggle="collapse" data-target="#submenu-1"><i class="fa fa-fw fa-list"></i> Master <i class="fa fa-fw fa-angle-down pull-right"></i></a>
                        <ul id="submenu-1" class="collapse">
                             <li><a href="/public/mastermember"><i class="fa fa-angle-double-right"></i> Master Member</a></li>
                            <li><a href="/public/masterpaket"><i class="fa fa-angle-double-right"></i> Master Paket</a></li>
                            <li><a href="/public/jenispaket"><i class="fa fa-angle-double-right"></i> Master Jenis Paket</a></li>
                            <li><a href="/public/jenisproduk"><i class="fa fa-angle-double-right"></i> Master Jenis Produk</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="#" data-toggle="collapse" data-target="#submenu-2"><i class="fa fa-fw fa-check"></i>  Konfirmasi <i class="fa fa-fw fa-angle-down pull-right"></i></a>
                        <ul id="submenu-2" class="collapse">
                            <li><a href="/public/confirmkonsultan"><i class="fa fa-angle-double-right"></i> Konfirmasi Konsultan</a></li>
                            {{-- <li><a href="/public/confirmsaldo"><i class="fa fa-angle-double-right"></i> Konfirmasi TopUp</a></li> --}}
                            <li><a href="/public/confirmpenarikan"><i class="fa fa-angle-double-right"></i> Konfirmasi Penarikan</a></li>
                        </ul>
                    </li>
                    {{-- <li>
                        <a href="#" data-toggle="collapse" data-target="#submenu-3"><i class="fa fa-fw fa-ban"></i>  Block <i class="fa fa-fw fa-angle-down pull-right"></i></a>
                        <ul id="submenu-3" class="collapse">
                            <li><a href="#"><i class="fa fa-angle-double-right"></i> Block Member</a></li>
                            <li><a href="#"><i class="fa fa-angle-double-right"></i> Block Paket</a></li>
                        </ul>
                    </li> --}}
                    <li>
                        <a href="#" data-toggle="collapse" data-target="#submenu-4"><i class="fa fa-fw fa-bar-chart"></i>  Laporan <i class="fa fa-fw fa-angle-down pull-right"></i></a>
                        <ul id="submenu-4" class="collapse">
                            <li><a href="/public/laporanpenjualanpaket"><i class="fa fa-angle-double-right"></i> Laporan Penjualan Paket</a></li>
                            <li><a href="/public/laporanpenjualanproduk"><i class="fa fa-angle-double-right"></i> Laporan Penjualan Produk</a></li>
                            <li><a href="/public/getCountKonsultan"><i class="fa fa-angle-double-right"></i> Laporan Konsultan Terlaris</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="/public/getReportKonsultanAdmin" data-toggle="collapse" data-target="#submenu-5"><i class="fa fa-exclamation-circle"></i>  Daftar Pengaduan</a>
                    </li>
                    <li>
                        <a href="/public/chat" data-toggle="collapse" data-target="#submenu-6"><i class="fa fa-commenting"></i> Pesan</a>
                    </li>
                </ul>
            </div>
        </nav>

        <div class="container" style="margin-left: 10px;">
            @yield("isipage")
        </div>

    </div>
</body>
</html>


<style>
@import url('https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css');
@media(min-width:768px) {
    body {
        margin-top: 50px;
    }
}

#wrapper {
    padding-left: 0;
}

#page-wrapper {
    width: 100%;
    padding: 0;
    background-color: #fff;
}

@media(min-width:768px) {
    #wrapper {
        padding-left: 225px;
    }

    #page-wrapper {
        padding: 22px 10px;
    }
}

/* Top Navigation */

.top-nav {
    padding: 0 15px;
}

.top-nav>li {
    display: inline-block;
    float: left;
}

.top-nav>li>a {
    padding-top: 20px;
    padding-bottom: 20px;
    line-height: 20px;
    color: #fff;
}

.top-nav>li>a:hover,
.top-nav>li>a:focus,
.top-nav>.open>a,
.top-nav>.open>a:hover,
.top-nav>.open>a:focus {
    color: #fff;
    background-color: #1a242f;
}

.top-nav>.open>.dropdown-menu {
    float: left;
    position: absolute;
    margin-top: 0;
    /*border: 1px solid rgba(0,0,0,.15);*/
    border-top-left-radius: 0;
    border-top-right-radius: 0;
    background-color: #fff;
    -webkit-box-shadow: 0 6px 12px rgba(0,0,0,.175);
    box-shadow: 0 6px 12px rgba(0,0,0,.175);
}

.top-nav>.open>.dropdown-menu>li>a {
    white-space: normal;
}

/* Side Navigation */

@media(min-width:768px) {
    .side-nav {
        position: fixed;
        top: 60px;
        left: 225px;
        width: 225px;
        margin-left: -225px;
        border: none;
        border-radius: 0;
        border-top: 1px rgba(0,0,0,.5) solid;
        overflow-y: auto;
        background-color: #222;
        /*background-color: #5A6B7D;*/
        bottom: 0;
        overflow-x: hidden;
        padding-bottom: 40px;
    }

    .side-nav>li>a {
        width: 225px;
        border-bottom: 1px rgba(0,0,0,.3) solid;
    }

    .side-nav li a:hover,
    .side-nav li a:focus {
        outline: none;
        background-color: #1a242f !important;
    }
}

.side-nav>li>ul {
    padding: 0;
    border-bottom: 1px rgba(0,0,0,.3) solid;
}

.side-nav>li>ul>li>a {
    display: block;
    padding: 10px 15px 10px 38px;
    text-decoration: none;
    /*color: #999;*/
    color: #fff;
}

.side-nav>li>ul>li>a:hover {
    color: #fff;
}

.navbar .nav > li > a > .label {
  -webkit-border-radius: 50%;
  -moz-border-radius: 50%;
  border-radius: 50%;
  position: absolute;
  top: 14px;
  right: 6px;
  font-size: 10px;
  font-weight: normal;
  min-width: 15px;
  min-height: 15px;
  line-height: 1.0em;
  text-align: center;
  padding: 2px;
}

.navbar .nav > li > a:hover > .label {
  top: 10px;
}

.navbar-brand {
    padding: 5px 15px;
}
</style>

<script language='javascript'>
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
        // $('.side-nav .collapse').on("show.bs.collapse", function() {
        //     $(this).prev().find(".fa").eq(1).removeClass("fa-angle-down").addClass("fa-angle-right");
        //     console.log("SANA");
        // });
        // $(".side-nav .collapse").on("hide.bs.collapse", function() {
        //     $(this).prev().find(".fa").eq(1).removeClass("fa-angle-right").addClass("fa-angle-down");
        //     console.log("SINI");
        // });
    });
</script>
