<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
     <meta charset="utf-8">
     <title>Planta de tratamiento</title>

     <!--Favicon de la pagina-->
       <!--<link rel="shorcut icon" type="image/ico" 
       href='<i class="fas fa-space-shuttle"></i>'>-->

     <!--Conexion con estilos.css-->
      <link rel="stylesheet" href="css/estilos.css">

     <!--Links para el funcionamiento de bootstrap-->
      <link rel="stylesheet" href="css/bootstrap.min.css">
      <script  src="js/jquery.min.js"></script>
      <script src="js/popper.min.js"></script>
      <script src="js/bootstrap.min.js"></script>

      <!--Links para el funcionamiento de font awesome icons-->
         <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/solid.css">
         <script src="https://use.fontawesome.com/releases/v5.0.7/js/all.js"></script>
       
      <!---Link pra el funcionamiento de chart  js librarie-->
         <script src="chart/Chart.min.js"></script>

  </head>
  <body>
        <!--navbar-->
        <nav class="navbar sticky-top navbar-expand-lg navbar-light" id="mainNav">
             <div class="container">
                 <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                     <ul class="nav navbar-nav navbar-right">
                         <a class="display-4"><!--<i class="fas fa-tint"</i>--></a>
                     </ul>
                 </div>
                  <button class="navbar-toggler navbar-toggler-right" type="button" 
                  data-toggle="collapse" data-target="#navbarResponsive" 
                  aria-controls="navbarResponsive" aria-expanded="false"
                  aria-label="Toggle navigation">
                  <span class="navbar-toggler-icon"></span>
                 </button>
                 <div class="collapse navbar-collapse" id="navbarResponsive">
                     <ul class="navbar-nav ml-auto">
                          <li class="nav-item">
                             <a class="nav-link" href="registros.php">Informes</a>
                          </li>
                          <li class="nav-item">
                             <a  class="nav-link" href="index.php">Inicio</a>
                          </li>
                      </ul>
                 </div>
             </div>
         </nav>
     <!--Finaliza el navbar-->
       <?php
          include("conexion.php");
          $sql = "SELECT * FROM reportediario";
          $query = $conexion->query($sql);
          $datosFecha = array();
          $datosGastoFloculante = array();
          $datosGastoCoagulante = array();
          $datosGastoCloro = array();
          $datosMediaTanque = array();
          $datosMaximoTanque = array();
          $datosMinimoTanque = array();
          $datosMediaTurbidez = array();
          $datosMaximoTurbidez = array();
          $datosMinimoTurbidez = array();
          $datosTiempo = array();
          while ($row = $query->fetch_assoc()) {
              array_push($datosFecha,$row['dia']);
              array_push($datosGastoCoagulante,round($row['coagulante_gastado'],2));
              array_push($datosGastoFloculante,round($row['floculante_gastado'],2));
              array_push($datosGastoCloro,round($row['cloro_gastado'],2));
              array_push($datosMediaTanque,round($row['mid_tanque'],2));
              array_push($datosMaximoTanque,round($row['max_tanque'],2));
              array_push($datosMinimoTanque,round($row['min_tanque'],2));
              array_push($datosMediaTurbidez,$row['mid_turbidez']);
              array_push($datosMaximoTurbidez,$row['max_turbidez']);
              array_push($datosMinimoTurbidez,$row['min_turbidez']);
          }
        ?>
      <div class="container container-fluid">
            <div class="row shadow-lg p-3 cajaGraficas ">
             <div class="col-sm-12">
                <h1 align="center" class="titulo">Gasto de quimicos por dia</h1>
                 <canvas id="gastoChart" height="135%"><!-----Inicia grafica de Fecha- Gasto de quimicos---->
                   <script>
                 var gastoCanvas = document.getElementById("gastoChart");

                 Chart.defaults.global.defaultFontFamily = "Lato";
                 Chart.defaults.global.defaultFontSize = 18;

                 var gastoData = {
                  labels:[<?php for($f = 0; $f < count($datosFecha); $f++)
                  {
                    ?>  
                     "<?php echo $datosFecha[$f]; ?>",
                 <?php } ?>
                 ],
                 datasets: [{
                   label: "Gasto Total Coagulante(kg)",
                   data:[<?php for($i = 0; $i < count($datosGastoCoagulante); $i++) {?>  <?php echo $datosGastoCoagulante[$i]; ?>,
                                    <?php } ?>],
                                  lineTension: 0,
                   fill: false,
                   borderColor: '#335eff',
                   backgroundColor: 'transparent',
                   borderDash: [5, 5],
                   pointBorderColor: 'blue',
                   pointBackgroundColor: 'rgba(25,150,189,0.5)',
                   pointRadius: 5,
                   pointHoverRadius: 10,
                   pointHitRadius: 30,
                   pointBorderWidth: 2,
                   pointStyle: 'rectRounded'
                 },
                 { label: "Gasto Total Floculante(kg)",
                   data:[<?php for($i = 0; $i < count($datosGastoFloculante); $i++) {?>  <?php echo $datosGastoFloculante[$i]; ?>,
                                    <?php } ?>],
                                  lineTension: 0,
                   fill: false,
                   borderColor: '#49ff33',
                   backgroundColor: 'transparent',
                   borderDash: [5, 5],
                   pointBorderColor: 'green',
                   pointBackgroundColor: 'rgba(25,189,150,0.5)',
                   pointRadius: 5,
                   pointHoverRadius: 10,
                   pointHitRadius: 30,
                   pointBorderWidth: 2,
                   pointStyle: 'rectRounded'
                 },
                 { label: "Gasto Total Cloro(L)",
                   data:[<?php for($i = 0; $i < count($datosGastoCloro); $i++) {?>  <?php echo $datosGastoCloro[$i]; ?>,
                                    <?php } ?>],
                                  lineTension: 0,
                   fill: false,
                   borderColor: '#ff7d33',
                   backgroundColor: 'transparent',
                   borderDash: [5, 5],
                   pointBorderColor: 'orange',
                   pointBackgroundColor: 'rgba(255,153,51,0.5)',
                   pointRadius: 5,
                   pointHoverRadius: 10,
                   pointHitRadius: 30,
                   pointBorderWidth: 2,
                   pointStyle: 'rectRounded'
                 }
                ]
                };
                var chartOptions = {
                  legend: {
                    display: true,
                    position: 'top',
                    labels: {
                      boxWidth: 80,
                      fontColor: 'grey',
                    }
                  },
                  options:{
                      responsive: true,
                   }
                };

                var lineChart = new Chart(gastoCanvas, {
                  type: 'line',
                  data: gastoData,
                  options: chartOptions
                },);
                </script>
             </canvas>
            </div>  <!--------Finaliza Grafica de Fecha-(Gasto)------------------------>
          </div>
            <!----Inicia grafica de niveles medio,maximo y minimo del tanque--->
            <div class="row shadow-lg p-3 cajaGraficas ">
             <div class="col-sm-12">
                <h1 align="center" class="titulo">Niveles del tanque</h1>
                 <canvas id="tanqueChart" height="135%"><!-----Inicia grafica de Fecha- Gasto de quimicos---->
                   <script>
                 var tanqueCanvas = document.getElementById("tanqueChart");

                 Chart.defaults.global.defaultFontFamily = "Lato";
                 Chart.defaults.global.defaultFontSize = 18;

                 var gastoData = {
                  labels:[<?php for($f = 0; $f < count($datosFecha); $f++)
                  {
                    ?>  
                     "<?php echo $datosFecha[$f]; ?>",
                 <?php } ?>
                 ],
                 datasets: [{
                   label: "Nivel medio(L)",
                   data:[<?php for($i = 0; $i < count($datosMediaTanque); $i++) {?>  <?php echo $datosMediaTanque[$i]; ?>,
                                    <?php } ?>],
                                  lineTension: 0,
                   fill: false,
                   borderColor: '#335eff',
                   backgroundColor: 'transparent',
                   borderDash: [5, 5],
                   pointBorderColor: 'blue',
                   pointBackgroundColor: 'rgba(25,150,189,0.5)',
                   pointRadius: 5,
                   pointHoverRadius: 10,
                   pointHitRadius: 30,
                   pointBorderWidth: 2,
                   pointStyle: 'rectRounded'
                 },
                 { label: "Nivel maximo(L)",
                   data:[<?php for($i = 0; $i < count($datosMaximoTanque); $i++) {?>  <?php echo $datosMaximoTanque[$i]; ?>,
                                    <?php } ?>],
                                  lineTension: 0,
                   fill: false,
                   borderColor: '#49ff33',
                   backgroundColor: 'transparent',
                   borderDash: [5, 5],
                   pointBorderColor: 'green',
                   pointBackgroundColor: 'rgba(25,189,150,0.5)',
                   pointRadius: 5,
                   pointHoverRadius: 10,
                   pointHitRadius: 30,
                   pointBorderWidth: 2,
                   pointStyle: 'rectRounded'
                 },
                 { label: "Nivel minimo(L)",
                   data:[<?php for($i = 0; $i < count($datosMinimoTanque); $i++) {?>  <?php echo $datosMinimoTanque[$i]; ?>,
                                    <?php } ?>],
                                  lineTension: 0,
                   fill: false,
                   borderColor: '#ff7d33',
                   backgroundColor: 'transparent',
                   borderDash: [5, 5],
                   pointBorderColor: 'orange',
                   pointBackgroundColor: 'rgba(255,153,51,0.5)',
                   pointRadius: 5,
                   pointHoverRadius: 10,
                   pointHitRadius: 30,
                   pointBorderWidth: 2,
                   pointStyle: 'rectRounded'
                 }
                ]
                };
                var chartOptions = {
                  legend: {
                    display: true,
                    position: 'top',
                    labels: {
                      boxWidth: 80,
                      fontColor: 'grey',
                    }
                  },
                  options:{
                      responsive: true,
                   }
                };

                var lineChart = new Chart(tanqueCanvas, {
                  type: 'line',
                  data: gastoData,
                  options: chartOptions
                },);
                </script>
             </canvas>
            </div>  <!--------Finaliza Grafica de Niveles del tanque------------------------>
            </div>

             <!----Inicia grafica de niveles medio,maximo y minimo de turbidez--->
             <div class="row shadow-lg p-3 cajaGraficas ">
             <div class="col-sm-12">
                <h1 align="center" class="titulo">Turbidez</h1>
                 <canvas id="turbidezChart" height="135%"><!-----Inicia grafica de Fecha- Gasto de quimicos---->
                   <script>
                 var turbidezCanvas = document.getElementById("turbidezChart");

                 Chart.defaults.global.defaultFontFamily = "Lato";
                 Chart.defaults.global.defaultFontSize = 18;

                 var turbidezData = {
                  labels:[<?php for($f = 0; $f < count($datosFecha); $f++)
                  {
                    ?>  
                     "<?php echo $datosFecha[$f]; ?>",
                 <?php } ?>
                 ],
                 datasets: [{
                   label: "Turbidez media(NTU)",
                   data:[<?php for($i = 0; $i < count($datosMediaTurbidez); $i++) {?>  <?php echo $datosMediaTurbidez[$i]; ?>,
                                    <?php } ?>],
                                  lineTension: 0,
                   fill: false,
                   borderColor: '#335eff',
                   backgroundColor: 'transparent',
                   borderDash: [5, 5],
                   pointBorderColor: 'blue',
                   pointBackgroundColor: 'rgba(25,150,189,0.5)',
                   pointRadius: 5,
                   pointHoverRadius: 10,
                   pointHitRadius: 30,
                   pointBorderWidth: 2,
                   pointStyle: 'rectRounded'
                 },
                 { label: "Turbidez maxima(NTU)",
                   data:[<?php for($i = 0; $i < count($datosMaximoTurbidez); $i++) {?>  <?php echo $datosMaximoTurbidez[$i]; ?>,
                                    <?php } ?>],
                                  lineTension: 0,
                   fill: false,
                   borderColor: '#49ff33',
                   backgroundColor: 'transparent',
                   borderDash: [5, 5],
                   pointBorderColor: 'green',
                   pointBackgroundColor: 'rgba(25,189,150,0.5)',
                   pointRadius: 5,
                   pointHoverRadius: 10,
                   pointHitRadius: 30,
                   pointBorderWidth: 2,
                   pointStyle: 'rectRounded'
                 },
                 { label: "Turbidez minima(NTU)",
                   data:[<?php for($i = 0; $i < count($datosMinimoTurbidez); $i++) {?>  <?php echo $datosMinimoTurbidez[$i]; ?>,
                                    <?php } ?>],
                                  lineTension: 0,
                   fill: false,
                   borderColor: '#ff7d33',
                   backgroundColor: 'transparent',
                   borderDash: [5, 5],
                   pointBorderColor: 'orange',
                   pointBackgroundColor: 'rgba(255,153,51,0.5)',
                   pointRadius: 5,
                   pointHoverRadius: 10,
                   pointHitRadius: 30,
                   pointBorderWidth: 2,
                   pointStyle: 'rectRounded'
                 }
                ]
                };
                var chartOptions = {
                  legend: {
                    display: true,
                    position: 'top',
                    labels: {
                      boxWidth: 80,
                      fontColor: 'grey',
                    }
                  },
                  options:{
                      responsive: true,
                   }
                };

                var lineChart = new Chart(turbidezCanvas, {
                  type: 'line',
                  data: turbidezData,
                  options: chartOptions
                },);
                </script>
             </canvas>
            </div>  <!--------Finaliza Grafica de Fecha-(Gasto)------------------------>
          </div>
            <!--Finaliza grafica de nivel medio,maximo y minimo del tanque-->
       </div>
      </div>
        <br>
     <!--Inicia el footer-->
     <footer>
         <div class="container container-fluid footer">
              <br><br>
              <div class="row">
                 <div class="col-sm-4"></div>
                 <div class="col-sm-4"><p class="text-light">Sistema de monitoreo planta de agua</p></div>
                 <div class="col-sm-4"></div>
              </div>
          </div>
          <br>
     </footer>
     <!-- jQuery -->
        <script language="javascript" 
        src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
  </body>