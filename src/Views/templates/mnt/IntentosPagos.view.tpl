<h1>Intentos Pagos</h1>
<hr>
<table>
    <thead>
        <tr>
            <td>Id</td>
            <td>Fecha</td>
            <td>Cliente</td>
            <td>Monto</td>
            <td>Fecha de Vencimiento</td>
            <td>estado</td>
            <td><a href="index.php?page=mnt.intentospagos.intentopago&mode=INS&id=0">Nuevo</a></td>
            
        </tr>
    </thead>

    <tbody>
        {{foreach intentosPagos}}
            <tr>
                <td>{{id}}</td>
                <td>{{fecha}}</td>
                <td><a href="index.php?page=mnt.intentospagos.intentopago&mode=DSP&id={{id}}">{{cliente}}</a></td>
                <td>{{monto}}</td>
                <td>{{fechaVencimiento}}</td>
                <td>{{estado}}</td>
                <td><a href="index.php?page=mnt.intentospagos.intentopago&mode=UPD&id={{id}}">Modificar</a></td>
                <td><a href="index.php?page=mnt.intentospagos.intentopago&mode=DEL&id={{id}}">Eliminar</a></td>
               
            </tr>
        {{endfor intentosPagos}}
    </tbody>
</table>