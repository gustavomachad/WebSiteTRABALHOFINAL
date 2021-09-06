<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = filter_input(INPUT_POST, 'id');
    $album = filter_input(INPUT_POST, 'album');
    $banda = filter_input(INPUT_POST, 'banda');
    $ano = filter_input(INPUT_POST, 'ano');
	$genero = filter_input(INPUT_POST, 'genero');
	$faixas = filter_input(INPUT_POST, 'faixas');
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
            $stmt = $conexao->prepare("UPDATE albuns SET album=?, banda=?,ano=?,genero=?,faixas=? WHERE id = ?");
            $stmt->bindParam(6, $id);
        } else {
            $stmt = $conexao->prepare("INSERT INTO albuns (album, banda, ano, genero, faixas) VALUES (?, ?, ?, ?, ?)");
        }
        $stmt->bindParam(1, $album);
        $stmt->bindParam(2, $banda);
        $stmt->bindParam(3, $ano);
		$stmt->bindParam(4, $genero);
		$stmt->bindParam(5, $faixas);
        if ($stmt->execute()) {
            if ($stmt->rowCount() > 0) {
                echo "<p class=\"bg-success\">Dados cadastrados com sucesso!</p>";
                $id = null;
                $album = null;
                $banda = null;
                $ano = null;
				$genero = null;
				$faixas = null;
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
			$genero = $rs->genero;
			$faixas = $rs->faixas;
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
<title>SPOTIFAI | Upload de Albuns</title>
<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="cssfinal.css">
<style>
body,h1,h2,h3,h4,h5,h6 {font-family: "Lato", sans-serif;}
body, html {
  height: 50%;
  color: #313131;
  line-height: 1;
}


.bgimg-1, .bgimg-2, .bgimg-3 {
  background-attachment: fixed;
  background-position: center;
  background-repeat: no-repeat;
  background-size: cover;
}

.bgimg-1 {
  background-image: url("logo.jpg");
  max-height: 50%;
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
	<a href="#upload" class="w3-bar-item w3-button w3-hide-small"><i class="fa fa-film"></i> REGISTRAR ÁLBUM</a>
  </div>
  <div id="navDemo" class="w3-bar-block w3-white w3-hide w3-hide-large w3-hide-medium">
    <a href="#upload" class="w3-bar-item w3-button" onclick="toggleFunction()"> REGISTRAR ÁLBUM</a>
  </div>
</div>

<div class="bgimg-1 w3-display-container w3-opacity-min" id="inicio">
  <div class="w3-display-middle" style="white-space:nowrap;">
    <span class="w3-center w3-padding-large w3-black w3-xlarge w3-wide w3-animate-opacity"> UPLOAD<span class="w3-hide-small"></span> </span>
  </div>
</div>
<div class="w3-content w3-container w3-padding-64" id="sobre">
  <h3 class="w3-center">COMO FAZER O UPLOAD</h3>
  <p class="w3-center"><em>Priorizamos as curtidas</em></p>
  <p class="w3-center">Os álbuns com mais acessos, mais vizualizações, mais curtidas, merece
  seu lugar de destaque, por isso, assim que você registrar um novo álbum, ele não possuirá
  foto, músicas e assinaturas, já que ele é um álbum recém lançado!</p>
  <div class="row">
  <p class="w3-center">Mas não fique triste!!! Compartilhe seu álbum com seus amigos para elevarmos o seu astral,
  e colocarmos este álbum para bombar!!!</p>
  </div>
</div>
<br>

<div class="container">
<div class="w3-content w3-container w3-padding-64" id="upload">
            <header class="row">
                <br />
            </header>
            <article>
                <div class="row">
					<div class ="form-style-5">
                    <form action="?act=save" method="POST" name="form1" class="form-horizontal" onsubmit="return valida_form(this)">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <span class="panel-title">Registre agora o seu álbum preferido!</span>
                            </div>
                            <div class="panel-body">

                                <input type="hidden" name="id" value="<?php
                                // Preenche o id no campo id com um valor "value"
                                echo (isset($id) && ($id != null || $id != "")) ? $id : '';

                                ?>" />
                                <div class="form-group">
                                    <label for="album" class="col-sm-1 control-label" >Álbum:</label>
                                    <div class="col-md-5">
                                        <input id="album" type="text" name="album" value="<?php
                                        // Preenche o nome no campo modelo com um valor "value"
                                        echo (isset($album) && ($album != null || $album != "")) ? $album : '';

                                        ?>" class="form-control"/>
                                    </div>
                                    <label for="banda" class="col-sm-1 control-label">Banda:</label>
                                    <div class="col-md-4">
                                        <input id="banda" type="text" name="banda" value="<?php
                                        // Preenche a marca no campo marca com um valor "value"
                                        echo (isset($banda) && ($banda != null || $banda != "")) ? $banda : '';

                                        ?>" class="form-control" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="ano" class="col-sm-1 control-label">Ano:</label>
                                    <div class="col-md-4">
                                        <input id="ano" type="text" name="ano" value="<?php
                                        // Preenche o ano no campo ano com um valor "value"
                                        echo (isset($ano) && ($ano != null || $ano != "")) ? $ano : '';

                                        ?>" class="form-control" />
                                    </div>
									<label for="genero" class="col-sm-1 control-label">Gênero:</label>
                                    <div class="col-md-4">
                                        <input id="genero" type="text" name="genero" value="<?php
                                        // Preenche o genero no campo genero com um valor "value"
                                        echo (isset($genero) && ($genero != null || $genero != "")) ? $genero : '';

                                        ?>" class="form-control" />
                                    </div>
                                </div>
								<div class="form-group">
                                    <label for="faixas" class="col-sm-1 control-label">Faixas:</label>
                                    <div class="col-md-4">
                                        <input id="faixas" type="text" name="faixas" value="<?php
                                        // Preenche o ano no campo ano com um valor "value"
                                        echo (isset($faixas) && ($faixas != null || $faixas != "")) ? $faixas : '';

                                        ?>" class="form-control" />
                                    </div>
                                </div>
                            </div>
                            <div class="panel-footer">
                                <div class="clearfix">
                                    <div class="pull-right">
                                        <button type="submit" class="btn btn-primary" /><span class="fa fa-cloud-upload"></span> Upload</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="row">
                    <div class="panel panel-default">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Álbum</th>
                                    <th>Banda</th>
                                    <th>Ano</th>
									<th>Gênero</th>
									<th>Faixas</th>
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
												<td><?php echo $rs->genero; ?></td>
												<td><?php echo $rs->faixas; ?></td>
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
                            </tbody>
                        </table>
                    </div>
                </div>
            </article>
			</div>
        </div>
		</div>
		</body>
		
		<footer class="w3-center w3-black w3-padding-64 w3-opacity w3-hover-opacity-off">
  <a href="#inicio" class="w3-button w3-light-grey"><i class="fa fa-arrow-up w3-margin-right"></i>To the top</a>
  <div class="w3-xlarge w3-section">
    <i class="fa fa-facebook-official w3-hover-opacity"></i>
    <i class="fa fa-instagram w3-hover-opacity"></i>
    <i class="fa fa-snapchat w3-hover-opacity"></i>
    <i class="fa fa-pinterest-p w3-hover-opacity"></i>
    <i class="fa fa-twitter w3-hover-opacity"></i>
    <i class="fa fa-linkedin w3-hover-opacity"></i>
  </div>
  <p>Feito pelo grupo mais top</p>
</footer> 

<script type="text/javascript" language="javascript">
function valida_form (){
if(document.getElementById("album").value.length < 3){
alert('Por favor, preencha o campo "Álbum"');
document.getElementById("album").focus();
return false
}
if(document.getElementById("banda").value.length < 3){
alert('Por favor, preencha o campo "Banda"');
document.getElementById("banda").focus();
return false
}
if(document.getElementById("ano").value.length < 3){
alert('Por favor, preencha o campo "Ano"');
document.getElementById("ano").focus();
return false
}
if(document.getElementById("genero").value.length < 3){
alert('Por favor, preencha o campo "Gênero"');
document.getElementById("genero").focus();
return false
}
if(document.getElementById("faixas").value.length < 1){
alert('Por favor, preencha o campo "Faixas"');
document.getElementById("faixas").focus();
return false
}
return true
}
</script>