<div style="font-family: Gill Sans, sans-serif; font-size:10px;" id="pedido">
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
            <b>Pedido:  <?php echo "#".$encabezado->id ?> </b>
            <br>
            <br>
             <table style="border-collapse: collapse; font-family: Gill Sans, sans-serif; font-size:10px;" align="right">
              <tr>
                <td style="padding: 1px; vertical-align: middle; text-align: left; border: 1px solid #EEEEEE; background-color: #EEEEEE;"><b>Fecha:</b></td>
                <td style="padding: 1px; border: 1px solid #EEEEEE;"><?php echo date('d/m/Y', strtotime($encabezado->fecha_pedido)); ?></td>
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
      <?php if ($encabezado->cliente_id == $parametro_sistema): ?>
        <td style="width: 17%; padding: 1px; vertical-align: middle; text-align: left; border: 1px solid #EEEEEE; background-color: #EEEEEE;"><b>Cliente:</b></td> 
        <td style="width: 33%; padding: 1px; border: 1px solid #EEEEEE;"><?php echo $encabezado->nombre_cliente ?></td>
        <td style="width: 17%; padding: 1px; vertical-align: middle; text-align: left; border: 1px solid #EEEEEE; background-color: #EEEEEE;"><b>Cliente Comodín:</b></td>
        <td style="width: 33%; padding: 1px; border: 1px solid #EEEEEE;"> <?php echo $encabezado->nombre_cliente_comodin ?> </td>      -->
      <?php else: ?>
        <td style="width: 17%; padding: 1px; vertical-align: middle; text-align: left; border: 1px solid #EEEEEE; background-color: #EEEEEE;"><b>Cliente:</b></td> 
        <td style="width: 33%; padding: 1px; border: 1px solid #EEEEEE;"><?php echo $encabezado->nombre_cliente ?></td>
        <td style="width: 17%; padding: 1px; vertical-align: middle; text-align: left; border: 1px solid #EEEEEE; background-color: #EEEEEE;"><b>Teléfono:</b></td> 
        <td style="width: 33%; padding: 1px; border: 1px solid #EEEEEE;"><?php echo $encabezado->telefono ?></td>
      <?php endif; ?>
    </tr>
    <tr>
      <td style="width: 17%; padding: 1px; vertical-align: middle; text-align: left; border: 1px solid #EEEEEE; background-color: #EEEEEE">
        <b>Transacción:</b>
      </td>
      <td colspan="3" style="width: 33%; padding: 1px; border: 1px solid #EEEEEE;"> <?php echo $encabezado->nombre_transaccion ?> </td>    
    </tr>
    <tr>
      <td style="padding: 1px; vertical-align: middle; text-align: left; border: 1px solid #EEEEEE; background-color: #EEEEEE;">
        <b>Observación:</b>
      </td>
      <td colspan="3" style="width: 33%; padding: 1px; border: 1px solid #EEEEEE;"><?php echo $encabezado->observacion ?></td>
    </tr>
    <tr>
      <td style="padding: 1px; vertical-align: middle; text-align: left; border: 1px solid #EEEEEE; background-color: #EEEEEE;">
        <b>Referencia:</b>
      </td>
      <td colspan="3" style="width: 33%; padding: 1px; border: 1px solid #EEEEEE;"><?php echo $encabezado->referencia ?></td>
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
        <th id="th-detalle" style="text-align:center;">Um</th>
        <th id="th-detalle" style="text-align:center;">Lote</th>
        <th id="th-detalle" style="text-align:center;">F. Vence</th>
        <th id="th-detalle" style="text-align:center;">Total</th>
      </tr>
    </thead>
    <tbody>
      <?php $granTotal = 0 ?>
      <?php foreach ($detalle as $row): ?>
        <?php $granTotal += $row->total; ?>
        <tr>
          <td id="td-detalle" style="text-align:center;"> <?php echo $row->no_linea ?></td>
          <td id="td-detalle" style="text-align: left; padding: 2px;"> <?php echo $row->codigo_producto ?></td>
          <td id="td-detalle" style="text-align: left; padding: 2px;"> <?php echo $row->nombre_producto ?></td>
          <td id="td-detalle" style="text-align: center; padding: 2px;"> <?php echo $row->cantidad ?></td>
          <td id="td-detalle" style="text-align: right; padding: 2px;"> Q.<?php echo number_format($row->precio, 2) ?></td>
          <td id="td-detalle" style="text-align: center; padding: 2px;"> <?php echo $row->nombre_unidad_medida ?></td>
          <td id="td-detalle" style="text-align: center; padding: 2px;"> <?php echo $row->lote ?></td>
          <td id="td-detalle" style="text-align: center; padding: 2px;"> <?php echo $row->fecha_vence ?></td>
          <td id="td-detalle" style="text-align: right; padding: 2px;"> Q.<?php echo number_format($row->total, 2, '.', ',') ?></td>
        </tr>
      <?php endforeach ?>
    </tbody>
  </table>
</div>

<div style="position: fixed; bottom: 2%; width: 100%; font-family: Gill Sans, sans-serif; font-size:11px; background-color: white; padding-top: 10px;">
  <table width="100%" style="border-collapse: collapse;">
    <tr>
      <td style="text-align: right; /*padding-right: 20px;*/ font-weight: bold; width: 70%;">Total:</td>
      <td style="text-align: right; /*width: 90px*/; font-weight: bold;">Q. <?php echo number_format($granTotal, 2, '.', ','); ?></td>
    </tr>
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
