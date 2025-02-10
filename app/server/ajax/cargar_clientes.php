<?php
require ("../persistence/ClientDAO.php");

$clienteDAO = new ClienteDAO();
$clientes = $clienteDAO->obtenerClientes();

if (!empty($clientes)) {
    foreach ($clientes as $cliente) {
        echo "<tr>
                <th scope='row'>
                    <label class='control control--checkbox'>
                        <input type='checkbox'>
                        <div class='control__indicator'></div>
                    </label>
                </th>
                <td>{$cliente->getIdPerson()}</td>
                <td>{$cliente->getName()} {$cliente->getLastname()}</td>
                <td>{$cliente->getEmail()}</td>
                <td>{$cliente->getIdentification()}</td>
                <td>{$cliente->getIdentification()}</td>
                <td>{$cliente->getDateInit()}</td>
                <td>{$cliente->getSeller()}</td>

              </tr>";
    }
} else {
    echo "<tr><td colspan='5'>No hay clientes disponibles</td></tr>";
}
?>
