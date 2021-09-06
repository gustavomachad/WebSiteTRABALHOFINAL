<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = filter_input(INPUT_POST, 'id');
    $album = filter_input(INPUT_POST, 'album');
    $banda = filter_input(INPUT_POST, 'banda');
    $ano = filter_input(INPUT_POST, 'ano');
} else if (!isset($id)) {
// Se não se não foi setado nenhum valor para variável $id
    $id = (isset($_GET["id"]) && $_GET["id"] != null) ? $_GET["id"] : "";
}

// Cria a conexão com o banco de dados
try {
    $conexao = new PDO("mysql:host=localhost;dbname=trabfinal", "root");
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conexao->exec("set names utf8");
} catch (PDOException $erro) {
    echo "<p class=\"bg-danger\">Erro na conexão:" . $erro->getMessage() . "</p>";
}

// Bloco If que Salva os dados no Banco - atua como Create e Update
if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "save" && $album != "") {
    try {
        if ($id != "") {
            $stmt = $conexao->prepare("UPDATE albuns SET album=?, banda=?,ano=? WHERE id = ?");
            $stmt->bindParam(10, $id);
        } else {
            $stmt = $conexao->prepare("INSERT INTO albuns (album, banda, ano) VALUES (?, ?, ?)");
        }
        $stmt->bindParam(1, $album);
        $stmt->bindParam(2, $banda);
        $stmt->bindParam(3, $ano);
		
        if ($stmt->execute()) {
            if ($stmt->rowCount() > 0) {
                echo "<p class=\"bg-success\">Dados cadastrados com sucesso!</p>";
                $id = null;
                $album = null;
                $banda = null;
                $ano = null;
            } else {
                echo "<p class=\"bg-danger\">Erro ao tentar efetivar cadastro</p>";
            }
        } else {
            echo "<p class=\"bg-danger\">Erro: Não foi possível executar a declaração sql</p>";
        }
    } catch (PDOException $erro) {
        echo "<p class=\"bg-danger\">Erro: " . $erro->getMessage() . "</p>";
    }
}

// Bloco if que recupera as informações no formulário, etapa utilizada pelo Update
if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "upd" && $id != "") {
    try {
        $stmt = $conexao->prepare("SELECT * FROM albuns WHERE id = ?");
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $rs = $stmt->fetch(PDO::FETCH_OBJ);
            $id = $rs->id;
            $album = $rs->album;
            $banda = $rs->banda;
            $ano = $rs->ano;
        } else {
            echo "<p class=\"bg-danger\">Erro: Não foi possível executar a declaração sql</p>";
        }
    } catch (PDOException $erro) {
        echo "<p class=\"bg-danger\">Erro: " . $erro->getMessage() . "</p>";
    }
}

// Bloco if utilizado pela etapa Delete
if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "del" && $id != "") {
    try {
        $stmt = $conexao->prepare("DELETE FROM albuns WHERE id = ?");
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            echo "<p class=\"bg-success\">Registo foi excluído com êxito</p>";
            $id = null;
        } else {
            echo "<p class=\"bg-danger\">Erro: Não foi possível executar a declaração sql</p>";
        }
    } catch (PDOException $erro) {
        echo "<p class=\"bg-danger\">Erro: " . $erro->getMessage() . "</a>";
    }
}

?>

<html>
<title>SPOTIFAI | Albuns</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="cssfinal.css"/>
<style>
body,h1,h2,h3,h4,h5,h6 {font-family: "Lato", sans-serif;}
body, html {
  height: 50%;
  color: #313131;
  line-height: 1;
}

/* Create a Parallax Effect */
.bgimg-1, .bgimg-2, .bgimg-3 {
  background-attachment: fixed;
  background-position: center;
  background-repeat: no-repeat;
  background-size: cover;
}

/* First image (Logo. Full height) */
.bgimg-1 {
  background-image: url("logo.jpg");
  max-height: 50%;
}

/* Second image (Albuns) */
.bgimg-2 {
  background-image: url("logo.jpg");
  min-height: 400px;
}

/* Third image (Contato) */
.bgimg-3 {
  background-image: url("logo.jpg");
  min-height: 400px;
}

.w3-wide {letter-spacing: 10px;}
.w3-hover-opacity {cursor: pointer;}

/* Turn off parallax scrolling for tablets and phones */
@media only screen and (max-device-width: 1600px) {
  .bgimg-1, .bgimg-2, .bgimg-3 {
    background-attachment: scroll;
    min-height: 400px;
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
	<a href="#albuns" class="w3-bar-item w3-button w3-hide-small"><i class="fa fa-th"></i> ALBUNS</a>
  </div>
  <div id="navDemo" class="w3-bar-block w3-white w3-hide w3-hide-large w3-hide-medium">
    <a href="#upload" class="w3-bar-item w3-button" onclick="toggleFunction()"> REGISTRAR ÁLBUM</a>
  </div>
</div>

<div class="bgimg-1 w3-display-container w3-opacity-min" id="inicio">
  <div class="w3-display-middle" style="white-space:nowrap;">
    <span class="w3-center w3-padding-large w3-black w3-xlarge w3-wide w3-animate-opacity"> ÁLBUNS<span class="w3-hide-small"> </span> </span>
  </div>
</div>

<div class="w3-content w3-container w3-padding-64" id="albuns">
  <div class="w3-row">
    <div class="w3-col m6 w3-center w3-padding-large">
      <p><b><i class="fa fa-user w3-margin-right"></i>Destaques:</b></p><br>
      <img src="pulse.jpg" class="w3-round w3-image w3-opacity w3-hover-opacity-off" alt="Pulse" width="500" height="333">
    </div>

    <div class="w3-col m6 w3-hide-small w3-padding-large">
      <p><br><br></br><br>Pulse é um álbum duplo ao vivo da banda britânica Pink Floyd, lançado em 1995. 
	  O álbum inclui uma versão ao vivo completa de The Dark Side of the Moon.
	  P•U•L•S•E chegou a nº 1 na tabela da Billboard 
	  em junho de 1995 e foram-lhe atribuídos disco de ouro, platina e dupla platina em 31 de julho 
	  do mesmo ano. No Brasil foram vendidas mais de 100 mil cópias e o álbum foi certificado com Disco 
	  de Diamante pela ABPD.</p>
    </div>
  </div>
  <div class="w3-row">
      <br></br>
	<div class="w3-col m6 w3-center w3-padding-large">
      <img src="killers.jpg" class="w3-round w3-image w3-opacity w3-hover-opacity-off" alt="Pulse" width="500" height="333">
    </div>

    <div class="w3-col m6 w3-hide-small w3-padding-large">
      <p><br>Imploding the Mirage é o sexto álbum de estúdio da banda de rock norte-americana 
	  The Killers, lançado em 21 de agosto de 2020. Foi precedido pelos singles "Caution", 
	  "Fire in Bone" (lançado promocionalmente), "My Own Soul's Warning" e "Dying Breed". 
	  A banda embarcaria em uma turnê mundial em apoio ao álbum, porém ela foi adiada devido 
	  à pandemia de COVID-19.</p>
    </div>
  </div>
  <div class="w3-row">
      <br></br>
	<div class="w3-col m6 w3-center w3-padding-large">
      <img src="clube.jpg" class="w3-round w3-image w3-opacity w3-hover-opacity-off" alt="Pulse" width="500" height="333">
    </div>

    <div class="w3-col m6 w3-hide-small w3-padding-large">
      <p><br>Clube da Esquina é um álbum de estúdio produto da reunião de músicos brasileiros 
	  conhecidos como Clube da Esquina, liderado pelos cantores e compositores Milton Nascimento 
	  e Lô Borges, a quem o álbum foi creditado. Desta forma, torna-se o quinto álbum de estúdio 
	  de Milton Nascimento e o primeiro de Lô Borges, que em seguida seguiria a carreira solo com 
	  trabalhos próprios. O disco foi lançado, no Brasil, em LP em 1972 pela EMI-Odeon.</p>
    </div>
  </div>
  <br>
  <p><b><i class="fa fa-user w3-margin-right"></i>Outros álbuns:</b></p><br>
  <div class="row">
                    <div class="panel panel-default">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Álbum</th>
                                    <th>Banda</th>
                                    <th>Ano</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                /**
                                 *  Bloco que realiza o papel do Read - recupera os dados e apresenta na tela
                                 */
                                try {
                                    $stmt = $conexao->prepare("SELECT * FROM albuns");
                                    if ($stmt->execute()) {
                                        while ($rs = $stmt->fetch(PDO::FETCH_OBJ)) {

                                            ?><tr>
                                                <td><?php echo $rs->album; ?></td>
                                                <td><?php echo $rs->banda; ?></td>
                                                <td><?php echo $rs->ano; ?></td>
                                                <td><center>
                                            <a href="?act=upd&id=<?php echo $rs->id; ?>" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-pencil"></span> Editar</a>
                                            <a href="?act=del&id=<?php echo $rs->id; ?>" class="btn btn-danger btn-xs" ><span class="glyphicon glyphicon-remove"></span> Excluir</a>
                                        </center>
                                        </td>
                                        </tr>
                                        <?php
                                    }
                                } else {
                                    echo "Erro: Não foi possível recuperar os dados do banco de dados";
                                }
                            } catch (PDOException $erro) {
                                echo "Erro: " . $erro->getMessage();
                            }

                            ?>