<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Prueba técnica Backend</title>
    <script>
        //Actualizar nombre de ciudad
    function ActualizarNombreCiudad() {
        var select = document.getElementById('selectCiudad');
        var selectedOption = select.options[select.selectedIndex];
        document.getElementById('nombreCiudad').value = selectedOption.getAttribute('data-nombre');
    }
    </script>

</head>
<body>
    <h1>Prueba técnica Backend</h1><br>
    <h3>Por: Samuel Alejandro Alegre Flores</h3>
    <hr>    
    <h1>Subir archivo CSV</h1>

    <form action="<?php echo site_url('ControladorCSV/upload'); ?>" method="post" enctype="multipart/form-data">
        <input type="file" name="csv_file" accept=".csv" required>
        
        <button type="submit">Cargar</button>
    </form>

   <?php if (isset($ciudades)): ?>
    <form action="<?php echo site_url('ControladorCSV/save'); ?>" method="post">
        <select name="IdCiudad" id="selectCiudad" required onchange="ActualizarNombreCiudad()">
            <option value="">Seleccione una ciudad</option>
            <?php foreach ($ciudades as $ciudad): ?>
                <option value="<?php echo $ciudad['Id']; ?>" data-nombre="<?php echo $ciudad['nombre']; ?>"><?php echo $ciudad['nombre']; ?></option>
            <?php endforeach; ?>
        </select>

        <select name="IdUsuario" required>
            <option value="">Seleccione un usuario</option>
            <?php foreach ($usuarios as $usuario): ?>
                <option value="<?php echo $usuario->id; ?>"><?php echo $usuario->nombre; ?></option>
            <?php endforeach; ?>
        </select>


        

        <input type="hidden" name="nombreCiudad" id="nombreCiudad"> 

        <button type="submit">Guardar</button>
    </form>
<?php endif; ?>

<hr>
<!--Verificar si se actualizo-->
<form method="post" action="<?php echo site_url('ControladorCSV/mostrarCiudadUsuario'); ?>">
    <button type="submit">Mostrar Datos</button>
</form>

<?php if (isset($ciudadUsuarios) && !empty($ciudadUsuarios)): ?>
<table>
    <tr>
        <th>Id Usuario</th>
        <th>Nombre Usuario</th>
        <th>Id Ciudad</th>
        <th>Nombre Ciudad</th>
    </tr>
    <?php foreach ($ciudadUsuarios as $usuarioCiudad): ?>
    <tr>
        <td><?php echo $usuarioCiudad['IdUsuario']; ?></td>
        <td><?php echo $usuarioCiudad['NombreUsuario']; ?></td>
        <td><?php echo $usuarioCiudad['IdCiudad']; ?></td>
        <td><?php echo $usuarioCiudad['NombreCiudad']; ?></td>
    </tr>
    <?php endforeach; ?>
</table>
<?php else: ?>
<p>No hay datos disponibles.</p>
<?php endif; ?>


</body>
</html>
