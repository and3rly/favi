<div style="font-family: Gill Sans, sans-serif; font-size:10px;" id="despacho">
  <table width="100%" style="padding-bottom: 5px; font-family: Gill Sans, sans-serif;">
    <tr>
        <td width="20%" style="text-align: left; vertical-align: top;">
            <img src="<?php echo "https://lh3.googleusercontent.com/d/".$empresa->logo ?>" width="90" height="auto" alt="Logo"/>
        </td>
        <td width="60%" style="text-align: center;">
            <h4><?php echo $empresa->nombre ?> </h4>
            <h5>SERVICIOS PARA LA CONSTRUCCIÓN</h5>
            <p style="font-size:10px;"><?php echo $empresa->direccion ?> </p>
            <p style="font-size:10px;">Tecpán Guatemala, Chimaltenango</p>
            <p style="font-size:10px;">Teléfono: <?php echo $empresa->telefono ?></p>
        </td>
        <td width="20%" style="text-align: center; vertical-align: top;">
            <b>Despacho:  <?php echo "#".$encabezado->id ?> </b>
            <br>
            <br>
             <table style="border-collapse: collapse; font-family: Gill Sans, sans-serif; font-size:13px;" align="right">
              <tr>
                <td style="padding: 1px; vertical-align: middle; text-align: left; border: 1px solid #EEEEEE; background-color: #EEEEEE;"><b>Fecha:</b></td>
                <td style="padding: 1px; border: 1px solid #EEEEEE;"><?php echo date('d/m/Y', strtotime($encabezado->fecha_mod)); ?></td>
              </tr>
            </table>

        </td>
    </tr>
  </table>
  
  <table 
    id="tb-encabezado"
    width="100%"
    style="border-collapse: collapse; font-family: Gill Sans, sans-serif; font-size:9px;"
  >
    <tr>
      <td style="width: 17%; padding: 1px; vertical-align: middle; text-align: left; border: 1px solid #EEEEEE; background-color: #EEEEEE">
        <b>Cliente:</b>
      </td>
      <td style="width: 33%; padding: 1px; border: 1px solid #EEEEEE;"> <?php echo $cliente->nombre_cliente ?> </td>
      <td style="width: 17%; padding: 1px; vertical-align: middle; text-align: left; border: 1px solid #EEEEEE; background-color: #EEEEEE;">
        <b>Teléfono:</b>
      </td>
      <td style="width: 33%; padding: 1px; border: 1px solid #EEEEEE;"> <?php echo $telefono->telefono ?> </td>
    </tr>
    <tr>
      <td style="width: 17%; padding: 1px; vertical-align: middle; text-align: left; border: 1px solid #EEEEEE; background-color: #EEEEEE">
        <b>Transacción:</b>
      </td>
      <td style="width: 33%; padding: 1px; border: 1px solid #EEEEEE;"> <?php echo $encabezado->nombre_transaccion ?> </td>
      <td style="width: 17%; padding: 1px; vertical-align: middle; text-align: left; border: 1px solid #EEEEEE; background-color: #EEEEEE;"><b>Bodega:</b></td>  
      <td style="width: 33%; padding: 1px; border: 1px solid #EEEEEE;"> <?php echo $encabezado->nombre_bodega ?> </td>      
    </tr>
    <tr>
      <td style="width: 17%; padding: 1px; vertical-align: middle; text-align: left; border: 1px solid #EEEEEE; background-color: #EEEEEE">
        <b>Marchamo:</b>
      </td>
      <td style="width: 33%; padding: 1px; border: 1px solid #EEEEEE;"> <?php echo $encabezado->marchamo ?> </td>
      <td style="width: 17%; padding: 1px; vertical-align: middle; text-align: left; border: 1px solid #EEEEEE; background-color: #EEEEEE">
        <b>Estado:</b>
      </td>
      <td style="width: 33%; padding: 1px; border: 1px solid #EEEEEE;"> <?php echo $encabezado->nombre_estado ?> </td>
    </tr>

    <tr>
      <td style="width: 17%; padding: 1px; vertical-align: middle; text-align: left; border: 1px solid #EEEEEE; background-color: #EEEEEE">
        <b>Vehiculo:</b>
      </td>
      <td style="width: 33%; padding: 1px; border: 1px solid #EEEEEE;"> <?php echo $encabezado->tipo_vehiculo . " ".  $encabezado->marca_vehiculo .", Placas: ". 
      $encabezado->placa_vehiculo?> </td>
      <td style="width: 17%; padding: 1px; vertical-align: middle; text-align: left; border: 1px solid #EEEEEE; background-color: #EEEEEE;"><b>Piloto:</b></td>  
      <td style="width: 33%; padding: 1px; border: 1px solid #EEEEEE;"> <?php echo $encabezado->nombres_piloto . " " . $encabezado->apellidos_piloto . ", Contacto: " .
       $encabezado->contacto_piloto ?> </td>      
    </tr>

    <tr>
      <td style="padding: 1px; vertical-align: middle; text-align: left; border: 1px solid #EEEEEE; background-color: #EEEEEE;">
        <b>Observación:</b>
      </td>
      <td colspan="3" style="width: 33%; padding: 1px; border: 1px solid #EEEEEE;"><?php echo $encabezado->observacion ?></td>
    </tr>
  </table>

  <br>

  <table
    id="tb-detalle"
    width="100%"
    style="border-collapse: collapse; font-family: Gill Sans, sans-serif; font-size:11px;"
  >
    <thead>
      <tr>
        <th id="th-detalle" width="30">#</th>
        <th id="th-detalle" style="text-align: left;">Código</th>
        <th id="th-detalle" style="text-align: left;">Descripción</th>
        <th id="th-detalle" style="text-align:center;">Cantidad</th>
        <th id="th-detalle" style="text-align:center;">Precio</th>
        <th id="th-detalle" style="text-align:center;">UM</th>
        <th id="th-detalle" style="text-align:center;">Estado Producto</th>
        <th id="th-detalle" style="text-align:center;">Total</th>
      </tr>
    </thead>
    <tbody>
      <?php $granTotal = 0; $total = 0; ?>
      <?php foreach ($detalle as $row): ?>p
        <?php 
            $total = $row->total ?  $row->total : $row->cantidad_despachada * $row->precio;
            $granTotal += ($row->total) ; 
        ?>
        <tr>
          <td id="td-detalle" style="text-align:center;"> <?php echo $row->no_linea ?></td>
          <td id="td-detalle" style="text-align: left; padding: 2px;"> <?php echo $row->codigo_producto ?></td>
          <td id="td-detalle" style="text-align: left; padding: 2px;"> <?php echo $row->nombre_producto ?></td>
          <td id="td-detalle" style="text-align: center; padding: 2px;"> <?php echo $row->cantidad_despachada ?></td>
          <td id="td-detalle" style="text-align: center; padding: 2px;"> <?php echo $row->precio ?></td>
          <td id="td-detalle" style="text-align: center; padding: 2px;"> <?php echo $row->nombre_um ?></td>
          <td id="td-detalle" style="text-align: center; padding: 2px;"> <?php echo $row->nombre_estado_producto ?></td>
          <td id="td-detalle" style="text-align: right; padding: 2px;">Q. <?php echo $row->total ?></td>
        </tr>
      <?php endforeach ?>
    </tbody>
    <tfoot>
      <tr>
        <td id="td-detalle" colspan="7" style="text-align: right; font-weight: bold; padding: 10px;">TOTAL:</td>
        <td id="td-detalle" style="text-align: right;">Q. <?php echo number_format($granTotal, 2, '.', ','); ?></td>
      </tr>
    </tfoot>
  </table>
</div>

<div style="position: fixed; bottom: 2%; width: 100%; sans-serif;  background-color: white; padding-top: 10px;">
  <table width="100%" style="text-align: center; font-size:10px;">
    <tr>
      <td width="40%" style="border-bottom: 1px solid black;"></td>
      <td width="10%"></td>
      <td width="20%" style="border-bottom: 1px solid black;"></td>
      <td width="10%"></td>
      <td width="20%" style="border-bottom: 1px solid black;"></td>
    </tr>
    <tr>
      <td>Nombre de la Persona Responsable</td>
      <td></td>
      <td>Firma</td>
      <td></td>
      <td>Torre Fuerte</td>
    </tr>
  </table>

  <br>

  <table width="100%" style="text-align: center; font-size:10px;">
    <tr>
      <td width="15%">Observaciones</td>
      <td width="85%" style="border-bottom: 1px solid black;"></td>
    </tr>
    <tr>
      <td colspan="2" style="border-bottom: 1px solid black; height: 15px;"></td>
    </tr>
  </table>

  <br>
</div>

<style>
  #tb-detalle, #tb-encabezado {
    width: 100%;
    border: 1px solid #EEEEEE;
  }

  #td-detalle {
    padding: 4px; 
    border: 1px solid #EEEEEE;
  }

  #th-detalle {
    padding: 4px;
    padding: 4px; 
    border: 1px solid #EEEEEE;
    background-color: #EEEEEE;
  }
</style>
