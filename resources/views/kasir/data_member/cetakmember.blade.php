<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->
<title>Go Fit</title>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
<div class="container">
   <h3 class="pb-3 mb-4 mt-3 font-italic border-bottom">
      Member Card Go Fit
      <a href="\member">
      <button class="btn btn-danger float-right">Back</button>
      </a>
   </h3>
   <div class="row">
      <div class="col-md-6" >
         <div class="card flex-md-row mb-4 shadow-sm h-md-250" style="width:700px">
            <div class="card-body d-flex flex-column align-items-start">
               <strong class="d-inline-block mb-2 text-primary">Card Member</strong>
               <h4>ID Member : {{$member->ID_MEMBER}}</h4>
               <h4>Nama      : {{$member->NAMA_MEMBER}}</h4>
               <h4>Alamat    : {{$member->ALAMAT_MEMBER}}</h4>
               <h4>No Telepon: {{$member->TELEPON_MEMBER}}</h4>
            </div>
            <img class="card-img-right flex-auto d-none d-lg-block" src="../img/cards.jpg" width="200">
         </div>
         <div>
            <button type="submit" class="btn btn-info" value="print" onclick="window.print()">Cetak Kartu</button>
         </div>
      </div>
   </div>
