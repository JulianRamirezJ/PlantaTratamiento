<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Planta de tratamiento</title>
    
    <!--Conexion con estilos.css-->
     <link rel="stylesheet" href="css/estilos.css">

    <!--Links para el funcionamiento de bootstrap-->
      <link rel="stylesheet" href="css/bootstrap.min.css">
      <script src="js/jquery.min.js"></script>
      <script src="js/popper.min.js"></script>
      <script src="js/bootstrap.min.js"></script>

      <!--Links para el funcionamiento de font awesome icons-->
      <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/solid.css">
      <script src="https://use.fontawesome.com/releases/v5.0.7/js/all.js"></script>

  </head>

  <body>
    <span class="spinner-grow text-danger"></span>
   <!---- <header id="header" class="header">
    </header>-->
    <!--navbar-->
    <nav class="navbar sticky-top navbar-expand-lg navbar-light" id="mainNav">
        <div class="container">
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
              <ul class="nav navbar-nav navbar-right">
                <a class="display-4"><i class="fas fa-tint"></i></a>  
                <!--- Icono sacado de fontawesome: https://fontawesome.com/ -->
              </ul>
          </div>
            <button class="navbar-toggler navbar-toggler-right" type="button" 
            data-toggle="collapse" data-target="#navbarResponsive" 
            aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
              <ul class="navbar-nav ml-auto">
                 <li class="nav-item">
                    <a class="nav-link" href="registros.php">Informes diarios</a>
                  </li>
                  <li class="nav-item">
                    <a  class="nav-link" href="actual.php">Datos en tiempo real</a>
                  </li>
             </ul>
         </div>
        </div>
    </nav>
   <!--Finaliza el navbar-->
    
     <p class="titulo alert">Bienvenido al sistema de la planta de tratamiento</p>
     <div class="container container-fluid shadow-lg p-3 mb-5 bg-white rounded presentacion">
        <div class="row">
          <div class="col-sm-11">
             <h1 class="text-primary">Aquí podras :</h1>
             <p class="text-info informacion">
               <br>
               <span class ="text-success">
                 <i class="fas fa-check"></i>
               </span>
               <span class="textoinfo">
                 Obtener datos tomados directamente desde la planta, 
               </span>
               <span style="padding-left:16%;">además de poder visualizarlos.</span>
               <br><br>
               <span class ="text-success">
                 <i class="fas fa-check"></i>
               </span>
               <span class="textoinfo">
                 Visualizar el comportamiento de la planta mediante graficas.
               </span> 
               <br><br>
               <span class ="text-success">
                 <i class="fas fa-check"></i>
                </span>
                <span class="textoinfo">
                   Visualizar los datos en tiempo real  mediante  tablas.
                </span> 
                <br><br>
               <span class ="text-success">
                 <i class="fas fa-check"></i>
                </span>
                <span class="textoinfo">
                   Obtener acceso a los documentos de los informes diarios.
                </span> 
               <br><br><br> 
             </p>
          </div> 
          <div class="col-sm-1"></div>
        </div>
    </div>

    <div class="container container-fluid">
      <div class="row">
        <div class="col-sm-5"></div>
        <div class="col-sm-5"></div>
      </div>
    </div>
    <br><br>
    <footer>
      <div class="container container-fluid footer">
        <br><br>
        <div class="row">
           <div class="col-sm-4"></div>
           <div class="col-sm-4"><p class="text-light">Sistema para Planta de tratamiento de agua</p></div>
           <div class="col-sm-4"></div>
        </div>
      </div>
      <br>
    </footer>
    <!--Conexion con las animaciones en js-->
    <script src="js/animaciones.js"></script>
  </body>
</html>