<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

        <nav class="navbar navbar-default" role="navigation">
    	  <div class="container">
		    <!-- Brand and toggle get grouped for better mobile display -->
		    <div class="navbar-header">

		      <div class="navbar-brand navbar-brand-centered">Detail Konsultan</div>
		    </div>


		  </div><!-- /.container-fluid -->
		</nav>
<div class="query-container">
   <table>
       <table>
           <tbody>
               <tr>
                   <td colspan='2'>Biodata Konsultan</td>
               </tr>
               <tr>
                   <td>Nama</td>
                   <td>{{$member[0]->nama}}</td>
               </tr>
               <tr>
                   <td>Email</td>
                   <td>{{$member[0]->email}}</td>
               </tr>
               <tr>
                   <td>Jenis Kelamin</td>
                   <td>{{$member[0]->jeniskelamin}}</td>
               </tr>
               <tr>
                   <td>Nomor HP</td>
                   <td>{{$member[0]->nomorhp}}</td>
               </tr>
               <tr>
                   <td>Tanggal Lahir</td>
                   <td>{{$member[0]->tanggallahir}}</td>
               </tr>
           </tbody>
       </table>
       <br />
    <center>
        <form action="/dietyuk/public/terima" method="post">
        @csrf
            <input type="hidden" name="username" value="{{$member[0]->id}}">
            <input type="submit" class="btn btn-primary" value="Terima">
        </form>
        <form action="/dietyuk/public/tolak" method="post">
            @csrf
            <input type="hidden" name="username" value="{{$member[0]->id}}">
            <input type="submit" class="btn btn-danger" value="Tolak">
        </form></center>
</div>

<style>
    body{
    margin-top:0px;
}


    .navbar-brand-centered {
        display: block;
        width: auto;
        text-align: center;
        margin-top:0;
        padding: 0px !important;

    }
    .navbar>.container .navbar-brand-centered,
    .navbar>.container-fluid .navbar-brand-centered {
        margin-left: -80px;
    }


.stepwizard-step p {
    margin-top: 3px;
    font-size: 12px;

}

.stepwizard-row {
    display: table-row;
}

.stepwizard {
    display: table;
    width: 100%;
    position: relative;

}

.stepwizard-step button[disabled] {
    opacity: 1 !important;
    filter: alpha(opacity=100) !important;

}

.stepwizard-row:before {
    top: 14px;
    bottom: 0;
    position: absolute;
    content: " ";
    width: 100%;
    height: 1px;
    background-color: #ccc;
    z-order: 0;

}

.stepwizard-step {
    display: table-cell;
    text-align: center;
    position: relative;
}

.btn-circle {
  width: 30px;
  height: 30px;
  text-align: center;
  padding: 6px 0;
  font-size: 12px;
  line-height: 1.428571429;
  border-radius: 15px;
}


.funkyradio div {
  clear: both;
  overflow: hidden;
}

.funkyradio label {
  width: 100%;
  border-radius: 3px;
  border: 1px solid #D1D3D4;
  font-weight: normal;

}

.funkyradio input[type="radio"]:empty,
.funkyradio input[type="checkbox"]:empty {
  display: none;
}

.funkyradio input[type="radio"]:empty ~ label,
.funkyradio input[type="checkbox"]:empty ~ label {
  position: relative;
  line-height: 2.5em;
  text-indent: 1em;

  cursor: pointer;
  -webkit-user-select: none;
     -moz-user-select: none;
      -ms-user-select: none;
          user-select: none;
}

.funkyradio input[type="radio"]:empty ~ label:before,
.funkyradio input[type="checkbox"]:empty ~ label:before {
  position: absolute;
  display: block;
  top: 0;
  bottom: 0;
  left: 0;
  content: '';
  /*width: 2.5em;*/
  /*background: #D1D3D4;*/
  border-radius: 3px 0 0 3px;
}

.funkyradio input[type="radio"]:hover:not(:checked) ~ label,
.funkyradio input[type="checkbox"]:hover:not(:checked) ~ label {
  color: #888;
}

.funkyradio input[type="radio"]:hover:not(:checked) ~ label:before,
.funkyradio input[type="checkbox"]:hover:not(:checked) ~ label:before {
  content: ' ';
  text-indent: .9em;
  color: #C2C2C2;
}

.funkyradio input[type="radio"]:checked ~ label,
.funkyradio input[type="checkbox"]:checked ~ label {
  color: #000;
}

.funkyradio input[type="radio"]:checked ~ label,
.funkyradio input[type="checkbox"]:checked ~ label {
  content: ' ';
  text-indent: .9em;
  color: #fff;
  background-color: #ccc;
}

.funkyradio input[type="radio"]:focus ~ label,
.funkyradio input[type="checkbox"]:focus ~ label {
  box-shadow: 0 0 0 3px #999;
}

.funkyradio-default input[type="radio"]:checked ~ label,
.funkyradio-default input[type="checkbox"]:checked ~ label {
  color: #333;
  background-color: #ccc;
}

.funkyradio-primary input[type="radio"]:checked ~ label,
.funkyradio-primary input[type="checkbox"]:checked ~ label {
  color: #fff;
  background-color: rgba(126, 148, 69,.5);
}

.funkyradio-success input[type="radio"]:checked ~ label,
.funkyradio-success input[type="checkbox"]:checked ~ label {
  color: #fff;
  background-color: #5cb85c;
}

.funkyradio-danger input[type="radio"]:checked ~ label,
.funkyradio-danger input[type="checkbox"]:checked ~ label {
  color: #fff;
  background-color: #d9534f;
}

.funkyradio-warning input[type="radio"]:checked ~ label,
.funkyradio-warning input[type="checkbox"]:checked ~ label {
  color: #fff;
  background-color: #f0ad4e;
}

.funkyradio-info input[type="radio"]:checked ~ label,
.funkyradio-info input[type="checkbox"]:checked ~ label {
  color: #fff;
  background-color: #5bc0de;
}
.stepwizard-row .btn {
    padding: 5px;
}
.btn {
    box-shadow: 0 1px 6px 0 rgba(32, 33, 36, .28);
}
.btn-success {
    background-color: #7e9445 !important;
    border-color: #7e9445 !important;
}
.nextBtn {
    background-color: #548235 !important;
    border-color: #444 !important;
        padding: 5px 30px !important;
    font-size: 14px !important;
    letter-spacing: 1px;
}
.nextBtn:focus, .btn-success.focus, .btn-success:focus {
   box-shadow:  0 0 0 0.2rem rgba(126,148,69,.5);
}
.btn-primary:not(:disabled):not(.disabled).active:focus, .btn-primary:not(:disabled):not(.disabled):active:focus, .show>.btn-primary.dropdown-toggle:focus,
.btn-success:not(:disabled):not(.disabled).active:focus, .btn-success:not(:disabled):not(.disabled):active:focus, .show>.btn-success.dropdown-toggle:focus {
    box-shadow:  0 0 0 0.2rem rgba(126,148,69,.5);
}
.form-control:focus {
    border-color: #7e9445 !important;
    box-shadow: none !important;
}
h4 {
    font-size: 15px !important;
}
.query-container {
    width: 500px;
    margin: 0 auto;
    border: 1px solid #D1D3D4;
    padding: 35px;
}
.btn.disabled, .btn[disabled], fieldset[disabled] .btn {
    opacity: 1 !important;
}
.ok-btn {
    width: 100%;
    background: #7e9445;
    border: 1px solid #000;
    font-size: 13px;
    padding: 4px 0;
    color: #fff;
    margin: 30px 0;
}
td {
        width: 1%;
    padding: 3px 5px !important;
    font-size: 14px;
    border: 1px solid #fff;
}
tr:nth-child(odd) {background: #f2f2f2}
tr:nth-child(even) {background: #e9ebf5}
@media only screen and (max-width: 550px) {
    .query-container {
    width: 80%;
    margin: 0 auto;
    border: 1px solid #D1D3D4;
    padding: 35px;
}
}
</style>

<script>
    $(document).ready(function () {

var navListItems = $('div.setup-panel div a'),
        allWells = $('.setup-content'),
        allNextBtn = $('.nextBtn');

allWells.hide();

navListItems.click(function (e) {
    e.preventDefault();
    var $target = $($(this).attr('href')),
            $item = $(this);

    if (!$item.hasClass('disabled')) {
        navListItems.removeClass('btn-success').addClass('btn-default');
        $item.addClass('btn-success');
        allWells.hide();
        $target.show();
        $target.find('input:eq(0)').focus();
    }
});

allNextBtn.click(function(){
    var curStep = $(this).closest(".setup-content"),
        curStepBtn = curStep.attr("id"),
        nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a"),
        curInputs = curStep.find("input[type='text'],input[type='radio'],input[type='email'],input[type='number'],input[type='url']"),
        isValid = true;

    $(".form-group").removeClass("has-error");
    for(var i=0; i<curInputs.length; i++){
        if (!curInputs[i].validity.valid){
            isValid = false;
            $(curInputs[i]).closest(".form-group").addClass("has-error");
        }
    }

    if (isValid)
        nextStepWizard.removeAttr('disabled').trigger('click');
});

$('div.setup-panel div a.btn-success').trigger('click');

$('#gotoConsent').click(function(){
    $('#step-4').show();
})
});
</script>
