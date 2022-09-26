@extends("layout2");

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.2.1/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.2.1/firebase-auth.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.2.1/firebase-firestore.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" type="text/css" rel="stylesheet">
    {{-- <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> --}}
    <title>Document</title>
</head>

@section("isipage")
<body>
    <br><br><br>
    <div class="container">
        <div class="messaging">
              <div class="inbox_msg">
                <div class="inbox_people">
                  <div class="headind_srch">
                    <div class="recent_heading">
                        <h4>Daftar Chat</h4>
                        <input type="hidden" id="channel" value="1_11">
                    </div>
                    {{-- <div class="srch_bar">
                      <div class="stylish-input-group">
                        <input type="text" class="search-bar"  placeholder="Search" >
                        <span class="input-group-addon">
                        <button type="button"> <i class="fa fa-search" aria-hidden="true"></i> </button>
                        </span> </div>
                    </div> --}}
                  </div>
                <div class="inbox_chat">
                  @php
                      $jum = count($members);
                  @endphp
                @for ($i = 0; $i < $jum; $i++)
                    @if ($members[$i]->username2 > 11)
                        @php
                            $channel = "11_".$members[$i]->username2;
                        @endphp
                    @else
                        @php
                            $channel = $members[$i]->username2."_11";
                        @endphp
                    @endif

                    <div class="chat_list" id="{{$channel}}" onclick="gantiChannel('{{$channel}}')">
                      <div class="chat_people">
                        <div class="chat_img"> <img src="https://dietyukyuk.com/public/gambar/{{$members[$i]->foto}}" alt="https://ptetutorials.com/images/user-profile.png"> </div>
                        <div class="chat_ib">
                          <h5>{{$members[$i]->username}}</h5>
                        </div>
                      </div>
                    </div>
                @endfor
                </div>
                </div>
                <div class="mesgs">
                  <div class="msg_history" id="historypesan">

                  </div>
                  <div class="type_msg">
                    <div class="input_msg_write">
                      <input type="text" class="write_msg" id="isichat" placeholder="Type a message" />
                      <button class="msg_send_btn" type="button" id="kirim" onclick="insertData()"><i class="fa fa-paper-plane-o" aria-hidden="true"></i></button>
                    </div>
                  </div>
                </div>
              </div>

            </div></div>
    <script id="mainScript">
        const firebaseConfig = {
            apiKey: "AIzaSyBQFfoAo8h428icA_rwfUcJ6Nyg6jIlXbw",
            authDomain: "dietyuk-3cc68.firebaseapp.com",
            databaseURL: "https://dietyuk-3cc68-default-rtdb.asia-southeast1.firebasedatabase.app",
            projectId: "dietyuk-3cc68",
            storageBucket: "dietyuk-3cc68.appspot.com",
            messagingSenderId: "753224120111",
            appId: "1:753224120111:web:5da6b0287705fb47fe13da",
            measurementId: "G-1ZBFY7NXTH"
        };

        firebase.initializeApp(firebaseConfig);

        const db = firebase.firestore();

        db.settings({timestampInSnapshots: true});

        var tmp = document.getElementById("channel").value;
        setInterval(() => {
            getDataFB();
        }, 2000);

        function gantiChannel(i){
            document.getElementById("channel").value = i;
            getDataFB();
        }

        function getDataFB(){
            var data = "";
            var tmp = document.getElementById("channel").value;
            db.collection(tmp).orderBy("tanggal").get().then(snapshot=>{
                snapshot.docs.forEach(doc=>{
                console.log(doc.data().tanggal);
                    if(doc.data().user1 == "11"){
                        data = data + '<div class="outgoing_msg"><div class="sent_msg"><p>'+doc.data().teks+'</p><span class="time_date">'+doc.data().tanggal+"</span></div></div>";
                    }
                    else{
                        data = data + '<div class="incoming_msg"><div class="incoming_msg_img"> <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil"> </div><div class="received_msg"><div class="received_withd_msg"><p>'+doc.data().teks+'</p><span class="time_date">'+doc.data().tanggal+"</span></div></div></div>";
                    }
                });
                document.getElementById("historypesan").innerHTML = data;
            });

        }

        function insertData(){
            var isichat = document.getElementById("isichat").value;
            var today = new Date();
            var bulan = today.getMonth()+1;
            if(bulan <= 9){
                bulan = "0"+bulan;
            }
            var hari = today.getDate();
            if(hari <= 9){
                hari = "0"+hari;
            }
            var date = today.getFullYear()+'-'+bulan+'-'+hari;
            var jam = today.getHours();
            if(jam <= 9){
                jam = "0"+jam;
            }
            var menit = today.getMinutes();
            if(menit <= 9){
                menit = "0"+menit;
            }
            var detik = today.getSeconds();
            if(detik <= 9){
                detik = "0"+detik;
            }
            var time = jam + ":" + menit + ":" + detik;
            console.log(time);
            var tanggal = date+' '+time;
            var i = document.getElementById("channel").value;
            var arrsplit = i.split("_");
            var user2 = arrsplit[0];
            if(user2 == "11"){
                user2 = arrsplit[1];
            }
            db.collection(i).add({
                foto : "",
                tanggal : tanggal,
                teks : isichat,
                user1 : "11",
                user2 : user2
            }).then(function(docRef) {
                console.log("Document written with ID", docRef.id);
            }).catch(function(error){
                console.log("Error adding document", error);
            });
            document.getElementById("isichat").value = "";
            getDataFB(i);
        }

    </script>
</body>
@endsection

</html>

<style>
    .container{max-width:1170px; margin:auto;}
img{ max-width:100%;}
.inbox_people {
  background: #f8f8f8 none repeat scroll 0 0;
  float: left;
  overflow: hidden;
  width: 40%; border-right:1px solid #c4c4c4;
}
.inbox_msg {
  border: 1px solid #c4c4c4;
  clear: both;
  overflow: hidden;
}
.top_spac{ margin: 20px 0 0;}


.recent_heading {float: left; width:40%;}
.srch_bar {
  display: inline-block;
  text-align: right;
  width: 60%;
}
.headind_srch{ padding:10px 29px 10px 20px; overflow:hidden; border-bottom:1px solid #c4c4c4;}

.recent_heading h4 {
  color: #05728f;
  font-size: 21px;
  margin: auto;
}
.srch_bar input{ border:1px solid #cdcdcd; border-width:0 0 1px 0; width:80%; padding:2px 0 4px 6px; background:none;}
.srch_bar .input-group-addon button {
  background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
  border: medium none;
  padding: 0;
  color: #707070;
  font-size: 18px;
}
.srch_bar .input-group-addon { margin: 0 0 0 -27px;}

.chat_ib h5{ font-size:15px; color:#464646; margin:0 0 8px 0;}
.chat_ib h5 span{ font-size:13px; float:right;}
.chat_ib p{ font-size:14px; color:#989898; margin:auto}
.chat_img {
  float: left;
  width: 11%;
}
.chat_ib {
  float: left;
  padding: 0 0 0 15px;
  width: 88%;
}

.chat_people{ overflow:hidden; clear:both;}
.chat_list {
  border-bottom: 1px solid #c4c4c4;
  margin: 0;
  padding: 18px 16px 10px;
}
.inbox_chat { height: 550px; overflow-y: scroll;}

.active_chat{ background:#ebebeb;}

.incoming_msg_img {
  display: inline-block;
  width: 6%;
}
.received_msg {
  display: inline-block;
  padding: 0 0 0 10px;
  vertical-align: top;
  width: 92%;
 }
 .received_withd_msg p {
  background: #ebebeb none repeat scroll 0 0;
  border-radius: 3px;
  color: #646464;
  font-size: 14px;
  margin: 0;
  padding: 5px 10px 5px 12px;
  width: 100%;
}
.time_date {
  color: #747474;
  display: block;
  font-size: 12px;
  margin: 8px 0 0;
}
.received_withd_msg { width: 57%;}
.mesgs {
  float: left;
  padding: 30px 15px 0 25px;
  width: 60%;
}

 .sent_msg p {
  background: #05728f none repeat scroll 0 0;
  border-radius: 3px;
  font-size: 14px;
  margin: 0; color:#fff;
  padding: 5px 10px 5px 12px;
  width:100%;
}
.outgoing_msg{ overflow:hidden; margin:26px 0 26px;}
.sent_msg {
  float: right;
  width: 46%;
}
.input_msg_write input {
  background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
  border: medium none;
  color: #4c4c4c;
  font-size: 15px;
  min-height: 48px;
  width: 100%;
}

.type_msg {border-top: 1px solid #c4c4c4;position: relative;}
.msg_send_btn {
  background: #05728f none repeat scroll 0 0;
  border: medium none;
  border-radius: 50%;
  color: #fff;
  cursor: pointer;
  font-size: 17px;
  height: 33px;
  position: absolute;
  right: 0;
  top: 11px;
  width: 33px;
}
.messaging { padding: 0 0 50px 0;}
.msg_history {
  height: 516px;
  overflow-y: auto;
}
</style>
