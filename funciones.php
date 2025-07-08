<?php
include('config/config.php');

function consultarTabla($conexion, $tabla, $campos = "*", $condiciones = [], $orden = "") {
    // Validaciones
    if(empty($tabla)) {
        return ["error" => "El nombre de la tabla no puede estar vacï¿½o"];
    }
    
    // Construir consulta base
    $sql = "SELECT $campos FROM $tabla";
    
    // Aï¿½adir condiciones si existen
    $tipos = "";
    $valores = [];
    $whereParts = [];
    
    foreach($condiciones as $campo => $valor) {
        $whereParts[] = "$campo = ?";
        $valores[] = $valor;
        $tipos .= is_int($valor) ? "i" : (is_float($valor) ? "d" : "s");
    }
    
    if(!empty($whereParts)) {
        $sql .= " WHERE " . implode(" AND ", $whereParts);
    }
    
    // Aï¿½adir orden si existe
    if(!empty($orden)) {
        $sql .= " ORDER BY $orden";
    }
    
    // Preparar consulta
    $stmt = mysqli_prepare($conexion, $sql);
    
    if(!$stmt) {
        return ["error" => "Error al preparar consulta: " . mysqli_error($conexion)];
    }
    
    // Vincular parï¿½metros si hay condiciones
    if(!empty($valores)) {
        mysqli_stmt_bind_param($stmt, $tipos, ...$valores);
    }
    
    // Ejecutar
    if(!mysqli_stmt_execute($stmt)) {
        return ["error" => "Error al ejecutar consulta: " . mysqli_stmt_error($stmt)];
    }
    
    // Obtener resultados
    $result = mysqli_stmt_get_result($stmt);
    $datos = [];
    
    while($fila = mysqli_fetch_array($result, MYSQLI_BOTH)) {
        $datos[] = $fila;
    }
    
    // Liberar recursos
    mysqli_stmt_close($stmt);
    
    return $datos;
}


function buscarPorEmail($conexion, $tabla,$email) {
    // Validar parï¿½metros
    if(empty($tabla)) {
        return ["error" => "El nombre de la tabla"];
    }

    if(empty($email)) {
        return 0;
    }
    
    // Preparar la consulta SQL
    $sql = "SELECT * FROM $tabla WHERE email = ?";
    
    // Crear la sentencia preparada
    $stmt = mysqli_prepare($conexion, $sql);
    
    if(!$stmt) {
        return ["error" => "Error al preparar la consulta: " . mysqli_error($conexion)];
    }
    
    // Vincular parï¿½metros
    mysqli_stmt_bind_param($stmt, "s", $email);
    
    // Ejecutar la consulta
    if(!mysqli_stmt_execute($stmt)) {
        return ["error" => "Error al ejecutar la consulta: " . mysqli_stmt_error($stmt)];
    }
    
    // Obtener resultados
    $result = mysqli_stmt_get_result($stmt);
    $datos = array();
    
    // Obtener filas como array asociativo y numï¿½rico
    while($fila = mysqli_fetch_array($result, MYSQLI_BOTH)) {
        $datos[] = $fila;
    }
    
    // Cerrar la sentencia
    mysqli_stmt_close($stmt);
    
    // Retornar resultados
    if(empty($datos)) {
        return ["mensaje" => "No se encontraron registros con ese email"];
    }
    
    return $datos;

}

function buscar($conexion, $tabla,$condicion,$email) {
    // Validar parï¿½metros
    if(empty($tabla)) {
        return ["error" => "El nombre de la tabla"];
    }

    if(empty($email)) {
        return 0;
    }
    
    // Preparar la consulta SQL
    $sql = "SELECT * FROM $tabla WHERE $condicion = ?";
    
    // Crear la sentencia preparada
    $stmt = mysqli_prepare($conexion, $sql);
    
    if(!$stmt) {
        return ["error" => "Error al preparar la consulta: " . mysqli_error($conexion)];
    }
    
    // Vincular parï¿½metros
    mysqli_stmt_bind_param($stmt, "s", $email);
    
    // Ejecutar la consulta
    if(!mysqli_stmt_execute($stmt)) {
        return ["error" => "Error al ejecutar la consulta: " . mysqli_stmt_error($stmt)];
    }
    
    // Obtener resultados
    $result = mysqli_stmt_get_result($stmt);
    $datos = array();
    
    // Obtener filas como array asociativo y numï¿½rico
    while($fila = mysqli_fetch_array($result, MYSQLI_BOTH)) {
        $datos[] = $fila;
    }
    
    // Cerrar la sentencia
    mysqli_stmt_close($stmt);
    
    // Retornar resultados
    if(empty($datos)) {
        return ["mensaje" => "No se encontraron registros con ese email"];
    }
    
    return $datos;

}

function insertInto($connection, string $table, array $data) {
    // Verificar que hay datos para insertar
    if (empty($data)) {
        trigger_error('No se proporcionaron datos para insertar', E_USER_WARNING);
        return false;
    }

    // Preparar columnas y placeholders
    $columns = [];
    $placeholders = [];
    $values = [];
    $types = '';

    foreach ($data as $column => $value) {
        $columns[] = "`" . $connection->real_escape_string($column) . "`";
        $placeholders[] = "?";
        
        // Determinar el tipo de dato para bind_param
        if (is_int($value)) {
            $types .= 'i'; // integer
        } elseif (is_double($value)) {
            $types .= 'd'; // double
        } else {
            $types .= 's'; // string (default)
        }
        
        $values[] = $value;
    }

    // Construir la consulta SQL
    $columnsStr = implode(', ', $columns);
    $placeholdersStr = implode(', ', $placeholders);
    $sql = "INSERT INTO `$table` ($columnsStr) VALUES ($placeholdersStr)";

    // Preparar la sentencia
    $stmt = $connection->prepare($sql);
    if (!$stmt) {
        trigger_error('Error al preparar la consulta: ' . $connection->error, E_USER_WARNING);
        return false;
    }

    // Vincular parï¿½metros dinï¿½micamente
    $params = array_merge([$types], $values);
    $bindNames = [];
    
    // Crear referencias para bind_param
    foreach ($params as $key => $value) {
        $bindNames[$key] = &$params[$key];
    }

    // Llamar a bind_param con parï¿½metros dinï¿½micos
    call_user_func_array([$stmt, 'bind_param'], $bindNames);

    // Ejecutar la consulta
    if (!$stmt->execute()) {
        trigger_error('Error al ejecutar la consulta: ' . $stmt->error, E_USER_WARNING);
        $stmt->close();
        return false;
    }

    // Obtener el ID insertado
    $insertId = $stmt->insert_id;
    $stmt->close();

    return $insertId;
}


function updateWhere(mysqli $connection, string $table, array $data, array $where) {
    // Verificar que hay datos para actualizar y condiciones WHERE
    if (empty($data) || empty($where)) {
        trigger_error('Datos o condiciones WHERE no proporcionados', E_USER_WARNING);
        return false;
    }

    // Preparar la parte SET del UPDATE
    $setParts = [];
    $setValues = [];
    $setTypes = '';
    
    foreach ($data as $column => $value) {
        $setParts[] = "`" . $connection->real_escape_string($column) . "` = ?";
        
        if (is_int($value)) {
            $setTypes .= 'i';
        } elseif (is_float($value)) {
            $setTypes .= 'd';
        } else {
            $setTypes .= 's';
        }
        
        $setValues[] = $value;
    }

    // Preparar la parte WHERE del UPDATE
    $whereParts = [];
    $whereValues = [];
    $whereTypes = '';
    
    foreach ($where as $column => $value) {
        $whereParts[] = "`" . $connection->real_escape_string($column) . "` = ?";
        
        if (is_int($value)) {
            $whereTypes .= 'i';
        } elseif (is_float($value)) {
            $whereTypes .= 'd';
        } else {
            $whereTypes .= 's';
        }
        
        $whereValues[] = $value;
    }

    // Construir la consulta SQL completa
    $setClause = implode(', ', $setParts);
    $whereClause = implode(' AND ', $whereParts);
    $sql = "UPDATE `$table` SET $setClause WHERE $whereClause";

    // Preparar la sentencia
    $stmt = $connection->prepare($sql);
    if (!$stmt) {
        trigger_error('Error al preparar la consulta: ' . $connection->error, E_USER_WARNING);
        return false;
    }

    // Combinar tipos y valores para bind_param
    $types = $setTypes . $whereTypes;
    $params = array_merge($setValues, $whereValues);

    // Vincular parï¿½metros
    $stmt->bind_param($types, ...$params);

    // Ejecutar la consulta
    if (!$stmt->execute()) {
        trigger_error('Error al ejecutar la actualizaciï¿½n: ' . $stmt->error, E_USER_WARNING);
        $stmt->close();
        return false;
    }

    // Obtener nï¿½mero de filas afectadas
    $affectedRows = $stmt->affected_rows;
    $stmt->close();

    return $affectedRows;
}

function generarNumeroFactura($con) {
    // 1. Obtener el ï¿½ltimo nï¿½mero de la base de datos
    $query = "SELECT * FROM orden_pago ORDER BY id_orden DESC LIMIT 1";
    $result = $con->query($query);
    
    if ($result->num_rows > 0) {
        $ultimoNumero = $result->fetch_assoc()['id_orden'];
        // Extraer solo los dï¿½gitos
        $ultimoConsecutivo = intval(preg_replace('/[^0-9]/', '', $ultimoNumero));
    } else {
        $ultimoConsecutivo = 0;
    }
    
    // 2. Incrementar el nï¿½mero
    $nuevoConsecutivo = $ultimoConsecutivo + 1;
    
    // 3. Formatear con prefijo y 5 dï¿½gitos
    $nuevoNumero = 'PFP-' . str_pad($nuevoConsecutivo, 6, '0', STR_PAD_LEFT);
    
    return $nuevoNumero;
}



?>