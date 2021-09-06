<html>
<title>SPOTIFAI | Registro</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="registro.css">
<style>
body,h1,h2,h3,h4,h5,h6 {font-family: "Lato", sans-serif;}
body, html {
  height: 100%;
  color: #313131;
  line-height: 1.8;
}


.bgimg-1, .bgimg-2, .bgimg-3 {
  background-attachment: fixed;
  background-position: center;
  background-repeat: no-repeat;
  background-size: cover;
}


.bgimg-1 {
  background-image: url("logo.jpg");
  min-height: 100%;
}


.bgimg-2 {
  background-image: url("logo.jpg");
  min-height: 400px;
}


.bgimg-3 {
  background-image: url("logo.jpg");
  min-height: 400px;
}

.w3-wide {letter-spacing: 10px;}
.w3-hover-opacity {cursor: pointer;}


@media only screen and (max-device-width: 1600px) {
  .bgimg-1, .bgimg-2, .bgimg-3 {
    background-attachment: scroll;
    min-height: 300px;
  }
}
</style>

<body>

<div class="w3-top">
  <div class="w3-bar" id="myNavbar">
    <a class="w3-bar-item w3-button w3-hover-black w3-hide-medium w3-hide-large w3-right" href="javascript:void(0);" onclick="toggleFunction()" title="Toggle Navigation Menu">
      <i class="fa fa-bars"></i>
    </a>
	<a href="trabfinal.html" class="w3-bar-item w3-button w3-hidden-small"> VOLTAR</a>
  </div>
</div>

<div class="bgimg-1 w3-display-container w3-opacity-min" id="inicio">
  <div class="w3-display-middle" style="white-space:nowrap;">
    <span class="w3-center w3-padding-large w3-black w3-xlarge w3-wide w3-animate-opacity"> LOGIN<span class="w3-hide-small"> </span> </span>
  </div>
</div>
<br>
<form action="trabfinal.html">
  <div class="container">
	<div class="form-group">
    <label for="email"><b></b></label>
	<div class="col-md-6">
    <input type="text" placeholder="Insira seu email" name="email" required>
	</div>
	</div>
	<div class="form-group">
                                    
    <div class="col-md-6">
    <input type="password" placeholder="Insira sua senha" name="psw" required><?php
    // Preenche o nome no campo modelo com um valor "value"
    echo (isset($album) && ($album != null || $album != "")) ? $album : '';

    ?>
    </div>
    </div>
    
    <div class="clearfix">
      <button type="button" class="cancelbtn">Cancelar</button>
      <button type="submit" class="signupbtn">Entrar</button>
    </div>
  </div>
</form>
