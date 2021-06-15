
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
     <meta charset="utf-8">
     <title>Planta de tratamiento</title>
    
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
       
        <!--Conexion con datatables js-->
          <link rel="stylesheet" type="text/css" 
          href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
          <script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" 
          type="text/javascript"></script>

  </head>
  <body>
     <!--navbar-->
      <nav class="navbar sticky-top navbar-expand-lg navbar-light" id="mainNav">
         <div class="container">
                 <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                     <ul class="nav navbar-nav navbar-right">
                         <a class="display-4"></a>
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
                             <a class="nav-link" href="graficasDiarias.php">Graficas</a>
                          </li>
                          <li class="nav-item">
                             <a  class="nav-link" href="index.php">Inicio</a>
                          </li>
                      </ul>
                 </div>
             </div>
        </nav>
     <!--Finaliza el navbar-->
     <div class="container container-fluid tabla">
             <!--Table-->
         <table id="tabla1" class="table table-secondary table-hover">
             <thead class="thead thead-dark thead-hover">
                 <tr style="">
                     <th style="text-align: left;">Fecha(Año-Mes-Dia)</th>
                     <th style="text-align: left;">Coagulante gastado</th>
                     <th style="text-align: left;">Floculante gastado</th>
                     <th style="text-align: left;">Cloro gastado</th>
                     <th style="text-align: left;">Nivel medio del Tanque</th>
                     <th style="text-align: left;">Nivel maximo del Tanque</th>
                     <th style="text-align: left;">Nivel minimo del Tanque</th>
                     <th style="text-align: left;">Turbidez media</th>
                     <th style="text-align: left;">Turbidez maxima</th>
                     <th style="text-align: left;">Turbidez minima</th>
                     <th style="text-align: left;">Documento del informe</th>
                  </tr>
             </thead>
             <tbody>
                  <?php
                      include("conexion.php");
                     $sql = "SELECT * FROM reportediario";
                     $query = $conexion->query($sql);
                     $totalGastoCoagulante = 0;
                     $totalGastoFloculante = 0;
                     $totalGastoCloro = 0;
                     while ($row = $query->fetch_assoc()) {
                        $totalGastoCoagulante += $row['coagulante_gastado'];
                        $totalGastoFloculante += $row['floculante_gastado'];
                        $totalGastoCloro += $row['cloro_gastado'];
                   ?>
                       <tr>
                           <td><?php echo $row['dia'];?></td>
                           <td><?php echo round($row['coagulante_gastado'],2);  ?> kg</td>
                           <td><?php echo round($row['floculante_gastado'],2);  ?> kg</td>
                           <td><?php echo round($row['cloro_gastado'],2); ?> L</td>
                           <td><?php echo round($row['mid_tanque'],2);  ?> L</td>
                           <td><?php echo round($row['max_tanque'],2);  ?> L</td>
                           <td><?php echo round($row['min_tanque'],2); ?>L</td>
                           <td><?php echo round($row['mid_turbidez'],2);  ?> NTU</td>
                           <td><?php echo round($row['max_turbidez'],2);  ?> NTU</td>
                           <td><?php echo round($row['min_turbidez'],2); ?> NTU</td>
                           <td><a href="reportes/<?php echo $row['dia']; ?>">Descargar</a></td>
                       </tr>
                 <?php
                     }
                  ?>
             </tbody>
             <tfooter>
               <tr  class="bg-light">
                  <td><h4>Total</h4></td>
                  <td><h4><?php echo  round($totalGastoCoagulante,2); ?> kg</h4></td>
                  <td><h4><?php echo  round($totalGastoFloculante,2); ?> kg</h4></td>
                  <td><h4><?php echo  round($totalGastoCloro,2); ?> L</h4></td>
               </tr>
               <tr  class="bg-light">
                  <td><h4>Costo Total</h4></td>
                  <td><h4>$<?php echo  round($totalGastoCoagulante*10000,2); ?></h4></td>
                  <td><h4>$<?php echo  round($totalGastoFloculante*10000,2); ?> </h4></td>
                  <td><h4>$<?php echo  round($totalGastoCloro*10000,2); ?> </h4></td>
               </tr>
             </tfooter>
          </table>
           <!--Finish tables-->
       </div>
     <!--Inicia el footer-->
     <footer>
         <div class="container container-fluid footer">
             <br><br>
             <div class="row">
                 <div class="col-sm-4"></div>
                 <div class="col-sm-4"><p class="text-light">Sistema para planta de tratamiento</p></div>
                 <div class="col-sm-4"></div>
             </div>
           </div>
           <br>
     </footer>
      <!-- jQuery -->
     <script language="javascript" 
     src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
     <!-- El JavaScript de DataTables -->
     <script language="javascript" type="text/javascript" 
     src="https://cdn.datatables.net/v/dt/jszip-2.5.0/pdfmake-0.1.18/dt-1.10.12/af-2.1.2/b-1.2.2/b-colvis-1.2.2/b-flash-1.2.2/b-html5-1.2.2/b-print-1.2.2/cr-1.3.2/fc-3.2.2/fh-3.1.2/kt-2.1.3/r-2.1.0/rr-1.1.2/sc-1.4.2/se-1.2.0/datatables.min.js"></script>
     <!--DataTables JS--> 
     <script language="javascript">
        var objetoDataTables_miembros = $('#tabla1').DataTable({
            "language": {
                "emptyTable":     "No hay datos disponibles en la tabla.",
                "info":         "Del _START_ al _END_ de _TOTAL_ ",
                "infoEmpty":      "Mostrando 0 registros de un total de 0.",
                "infoFiltered":     "(filtrados de un total de _MAX_ registros)",
                "infoPostFix":      "(actualizados)",
                "lengthMenu":     "Mostrar _MENU_ registros",
                "loadingRecords":   "Cargando...",
                "processing":     "Procesando...",
                "search":     "Buscar:",
                "searchPlaceholder":    "Dato para buscar",
                "zeroRecords":      "No se han encontrado coincidencias.",
                "paginate": {
                    "first":      "Primera",
                    "last":       "Última",
                    "next":       "Siguiente",
                    "previous":     "Anterior"
                },
                "aria": {
                    "sortAscending":  "Ordenación ascendente",
                    "sortDescending": "Ordenación descendente"
                }
            },
            "lengthMenu":   [[5, 10, 20, 25, 50, -1], [5, 10, 20, 25, 50, "Todos"]],
            "iDisplayLength": 5,
            "bJQueryUI":    false,
            "columns" : [
                {"data": 0},
                {"data": 1},
                {"data": 2},
                {"data": 3},
                {"data": 4},
                {"data": 5},
                {"data": 6},
                {"data": 7},
                {"data": 8},
                {"data": 9},
                {"data": 10}
            ],
        });
        $('label').addClass('form-inline');
        $('select, input[type="search"]').addClass('form-control input-sm');
     </script>
  </body>
</html>

