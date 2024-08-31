<div style="font-family: Gill Sans, sans-serif; font-size:12px;" id="recepcion">
  <table width="100%" style="padding-bottom: 10px; font-family: Gill Sans, sans-serif;">
    <tr>
        <td width="20%" style="text-align: left; vertical-align: top;">
            <img src="<?php echo APPPATH.'public/logo.png' ?>" width="125" height="auto" alt="Logo"/>
        </td>
        <td width="60%" style="text-align: center;">
            <h3><?php echo $empresa->nombre ?> </h3>
            <h4><?php echo $empresa->eslogan ?></h4>
            <p style="font-size:12px;"><?php echo $empresa->direccion ?> </p>
            <p style="font-size:12px;"><?php echo  $empresa->departamento ." ". $empresa->municipio ?></p>
            <p style="font-size:12px;">Teléfono: <?php echo $empresa->telefono ?></p>
        </td>
        <td width="20%" style="text-align: right; vertical-align: top;">
            <b>Orden de Compra:  <?php echo "#".$encabezado->id ?> </b>
        </td>
    </tr>
  </table>

  <br>

  <table 
    id="tb-encabezado"
    width="100%"
    style="border-collapse: collapse; font-family: Gill Sans, sans-serif; font-size:13px;"
  >
    <tr>
      <td style="width: 17%; padding: 5px; vertical-align: middle; text-align: left; border: 1px solid #EEEEEE; background-color: #EEEEEE;"><b>Tipo:</b></td>  
      <td style="width: 33%; padding: 5px; border: 1px solid #EEEEEE;"> <?php echo $encabezado->nombre_tipo ?> </td>
      <td style="width: 17%; padding: 5px; vertical-align: middle; text-align: left; border: 1px solid #EEEEEE; background-color: #EEEEEE">
        <b>Transacción:</b>
      </td>
      <td style="width: 33%; padding: 5px; border: 1px solid #EEEEEE;"> <?php echo $encabezado->nombre_transaccion ?> </td>
    </tr>
    <tr>
      <td style="padding: 5px; vertical-align: middle; text-align: left; border: 1px solid #EEEEEE; background-color: #EEEEEE;">
        <b>Piloto:</b>
      </td>
      <td style="padding: 5px; border: 1px solid #EEEEEE;"> 
        <?php echo $encabezado->nombre_piloto ." ". $encabezado->apelldiso_piloto ?> 
      </td>
      <td style="padding: 5px; vertical-align: middle; text-align: left; border: 1px solid #EEEEEE; background-color: #EEEEEE;">
        <b>Vehículo:</b>
      </td>
      <td style="padding: 5px; border: 1px solid #EEEEEE;"> 
        <?php echo $encabezado->marca ." ". $encabezado->placa ?> 
      </td>
    </tr>
    <tr>
      <td colspan="100" style="padding: 5px; vertical-align: middle; text-align: left; border: 1px solid #EEEEEE; background-color: #EEEEEE;">
        <b>Observación:</b>
      </td>  
    </tr>
    <tr>
      <td colspan="" style="padding: 5px;"><?php echo $encabezado->observacion ?></td>
    </tr>
  </table>

  <br>

  <table
    id="tb-detalle"
    width="100%"
    style="border-collapse: collapse; font-family: Gill Sans, sans-serif; font-size:13px;"
  >
    <thead>
      <tr>
        <th id="th-detalle" width="30">#</th>
        <th id="th-detalle" style="text-align: left;">Código</th>
        <th id="th-detalle" style="text-align: left;">Descripción</th>
        <th id="th-detalle" style="text-align:center;">Cantidad</th>
        <th id="th-detalle" style="text-align:center;">Um</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($detalle as $row): ?>
        <tr>
          <td id="td-detalle" style="text-align:center;"> <?php echo $row->no_linea ?></td>
          <td id="td-detalle" style="text-align: left; padding: 4px;"> <?php echo $row->codigo_producto ?></td>
          <td id="td-detalle" style="text-align: left; padding: 4px;"> <?php echo $row->nombre_producto ?></td>
          <td id="td-detalle" style="text-align: center; padding: 4px;"> <?php echo $row->cantidad_recibida ?></td>
          <td id="td-detalle" style="text-align: center; padding: 4px;"> <?php echo $row->nombre_unidad_medida ?></td>
        </tr>
      <?php endforeach ?>
    </tbody>
  </table>
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
