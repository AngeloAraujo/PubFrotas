<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <title>Pubfrotas</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">    <link rel="stylesheet" type="text/css"  href="estilo.css" />
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    </head>
<body>
 
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">
		 Pubfrotas
	</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="index.php">Home</a>
        </li>
		<li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Cadastro
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
		  	<li><a class="dropdown-item" href="cadabastecimento.php">Abastecimento</a></li>
		 	<li><a class="dropdown-item" href="cadmotorista.php">Motorista</a></li>
            <li><a class="dropdown-item" href="cadmodelo.php">Modelo</a></li>
			<li><a class="dropdown-item" href="cadrota.php">Rota</a></li>
			<li><a class="dropdown-item" href="cadveiculo.php">Veiculo</a></li>
			<li><a class="dropdown-item" href="cadviagem.php">Viagem</a></li>
     
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Consulta
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
		  	<li><a class="dropdown-item" href="listarabastecimento.php">Abastecimento</a></li>
		 	<li><a class="dropdown-item" href="listarmotorista.php">Motorista</a></li>
            <li><a class="dropdown-item" href="listarmodelo.php">Modelo</a></li>
			<li><a class="dropdown-item" href="listarrota.php">Rota</a></li>
			<li><a class="dropdown-item" href="listarveiculo.php">Veiculo</a></li>
			<li><a class="dropdown-item" href="listarviagem.php">Viagem</a></li>
          </ul>
        </li>
        <li class="nav-item dropdown">
        <li><a href="reset-password.php" class="nav-link dropdown-toggle">Redefina sua senha</a></li>
        </li>
		<li class="nav-item">
          <a class="nav-link" href="sobre.php">Sobre Nós</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="logout.php">Sair da conta</a>
          </li>
      </ul>
    </div>
  </div>
</nav>

</body>
</html>