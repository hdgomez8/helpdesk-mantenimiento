<?php
/* TODO: Rol 1 es de Usuario */
if ($_SESSION["rol_id"] == 1) {
?>
    <nav class="side-menu">
        <ul class="side-menu-list">
            <li class="blue-dirty">
                <a href="..\Home\">
                    <span class="glyphicon glyphicon-home"></span>
                    <span class="lbl">Inicio</span>
                </a>
            </li>

            <li class="blue-dirty">
                <a href="..\NuevoTicket\">
                    <span class="glyphicon glyphicon-pencil"></span>
                    <span class="lbl">Nueva solicitud de servicio</span>
                </a>
            </li>

            <li class="blue-dirty">
                <a href="..\MntUsuario\">
                    <span class="glyphicon glyphicon-user"></span>
                    <span class="lbl">Mant. Usuario</span>
                </a>
            </li>

            <li class="blue-dirty">
                <a href="..\MntPrioridad\">
                    <span class="glyphicon glyphicon-exclamation-sign"></span>
                    <span class="lbl">Mant. Prioridad</span>
                </a>
            </li>

            <li class="blue-dirty">
                <a href="..\MntCategoria\">
                    <span class="glyphicon glyphicon-copyright-mark"></span>
                    <span class="lbl">Mant. Tipo De Mantenimiento</span>
                </a>
            </li>

            <li class="blue-dirty">
                <a href="..\MntSubCategoria\">
                    <span class="glyphicon glyphicon-subtitles"></span>
                    <span class="lbl">Mant. Sub Categoria</span>
                </a>
            </li>

            <li class="blue-dirty">
                <a href="..\GestionarTicket\">
                    <span class="glyphicon glyphicon-fullscreen"></span>
                    <span class="lbl">Gestionar Solicitud</span>
                </a>
            </li>

            <li class="blue-dirty">
                <a href="..\ConsultarTicketPendientes\">
                    <span class="glyphicon glyphicon-exclamation-sign"></span>
                    <span class="lbl">Solicitudes Pendientes</span>
                </a>
            </li>

            <li class="blue-dirty">
                <a href="..\ConsultarTicket\">
                    <span class="glyphicon glyphicon-search"></span>
                    <span class="lbl">Consultar Solicitud</span>
                </a>
            </li>
        </ul>
    </nav>
<?php
} elseif ($_SESSION["rol_id"] == 2) {
?>
    <nav class="side-menu">
        <ul class="side-menu-list">
            <li class="blue-dirty">
                <a href="..\Home\">
                    <span class="glyphicon glyphicon-home"></span>
                    <span class="lbl">Inicio</span>
                </a>
            </li>

            <li class="blue-dirty">
                <a href="..\NuevoTicket\">
                    <span class="glyphicon glyphicon-pencil"></span>
                    <span class="lbl">Nueva solicitud de servicio</span>
                </a>
            </li>

            <li class="blue-dirty">
                <a href="..\GestionarTicket\">
                    <span class="glyphicon glyphicon-fullscreen"></span>
                    <span class="lbl">Gestionar Solicitud</span>
                    <span id="lbltotalxgestionarnavadmin"></span>
                </a>
            </li>

            <li class="blue-dirty">
                <a href="..\ConsultarTicketPendientesTecnicos\">
                    <span class="glyphicon glyphicon-user"></span>
                    <span class="lbl">Solicitudes Pendientes Por Realizar Tecnicos</span>
                    <span id="lbltotalxrealizartecnicosadmin"></span>
                </a>
            </li>

            <li class="blue-dirty">
                <a href="..\ConsultarTicketPendientesProveedores\">
                    <span class="glyphicon glyphicon-exclamation-sign"></span>
                    <span class="lbl">Solicitudes Pendientes Por Realizar Proveedores</span>
                    <span id="lbltotalxrealizarproveedoresadmin"></span>
                </a>
            </li>

            <li class="blue-dirty">
                <a href="..\ConsultarTicketPendientesCompras\">
                    <span class="glyphicon glyphicon-shopping-cart"></span>
                    <span class="lbl">Solicitudes Pendientes Por Materiales</span>
                    <span id="lbltotalpendientesxmaterialesadmin"></span>
                </a>
            </li>

            <li class="blue-dirty">
                <a href="..\ConsultarTicketPendientesEnCompras\">
                    <span class="glyphicon glyphicon-usd"></span>
                    <span class="lbl">Solicitudes Pendientes En Compras</span>
                    <span id="lbltotalpendientesencomprasadmin"></span>
                </a>
            </li>

            <li class="blue-dirty">
                <a href="..\ConsultarTicketAsignadoConMateriales\">
                    <span class="glyphicon glyphicon-warning-sign"></span>
                    <span class="lbl">Solicitudes Asignadas Con Materiales</span>
                    <span id="lbltotalpendientesconmaterialesadmin"></span>
                </a>
            </li>

            <li class="blue-dirty">
                <a href="..\ConsultarTicketPendientesCierreCliente\">
                    <span class="glyphicon glyphicon-thumbs-up"></span>
                    <span class="lbl">Solicitudes Pendientes Para Visto Bueno</span>
                    <span id="lbltotalpendientesparavistobuenoadmin"></span>
                </a>
            </li>

            <li class="blue-dirty">
                <a href="..\ConsultarTicketPendientesCierreJefeMantenimiento\">
                    <span class="glyphicon glyphicon-eye-open"></span>
                    <span class="lbl">Solicitudes Pendientes Para Cierre Jefe Mantenimiento</span>
                    <span id="lbltotalpendientescierrejefeadmin"></span>
                </a>
            </li>

            <li class="blue-dirty">
                <a href="..\ConsultarTicket\">
                    <span class="glyphicon glyphicon-search"></span>
                    <span class="lbl">Consultar Solicitud</span>
                </a>
            </li>
        </ul>
    </nav>
<?php
} elseif ($_SESSION["rol_id"] == 3) {
?>
    <nav class="side-menu">
        <ul class="side-menu-list">
            <li class="blue-dirty">
                <a href="..\Home\">
                    <span class="glyphicon glyphicon-home"></span>
                    <span class="lbl">Inicio</span>
                </a>
            </li>

            <li class="blue-dirty">
                <a href="..\NuevoTicket\">
                    <span class="glyphicon glyphicon-pencil"></span>
                    <span class="lbl">Nueva solicitud de servicio</span>
                </a>
            </li>

            <li class="blue-dirty">
                <a href="..\ConsultarTicketPendientes\">
                    <span class="glyphicon glyphicon-exclamation-sign"></span>
                    <span class="lbl">Solicitudes Pendientes Por Realizar</span>
                </a>
            </li>

            <li class="blue-dirty">
                <a href="..\ConsultarTicketAsignadoConMateriales\">
                    <span class="glyphicon glyphicon-warning-sign"></span>
                    <span class="lbl">Solicitudes Asignadas Con Materiales</span>
                </a>
            </li>

            <li class="blue-dirty">
                <a href="..\ConsultarTicketPendientesCierreCliente\">
                    <span class="glyphicon glyphicon-thumbs-up"></span>
                    <span class="lbl">Solicitudes Pendientes Para Visto Bueno</span>
                </a>
            </li>

            <li class="blue-dirty">
                <a href="..\ConsultarTicket\">
                    <span class="glyphicon glyphicon-search"></span>
                    <span class="lbl">Consultar Solicitud</span>
                </a>
            </li>
        </ul>
    </nav>
<?php
} else {
?>
    <nav class="side-menu">
        <ul class="side-menu-list">
            <li class="blue-dirty">
                <a href="..\Home\">
                    <span class="glyphicon glyphicon-home"></span>
                    <span class="lbl">Inicio</span>
                </a>
            </li>

            <li class="blue-dirty">
                <a href="..\NuevoTicket\">
                    <span class="glyphicon glyphicon-pencil"></span>
                    <span class="lbl">Nueva solicitud de servicio</span>
                </a>
            </li>

            <li class="blue-dirty">
                <a href="..\ConsultarTicketPendientesCierreCliente\">
                    <span class="glyphicon glyphicon-thumbs-up"></span>
                    <span class="lbl">Solicitudes Pendientes Para Visto Bueno</span>
                </a>
            </li>

            <li class="blue-dirty">
                <a href="..\ConsultarTicket\">
                    <span class="glyphicon glyphicon-search"></span>
                    <span class="lbl">Consultar Solicitud</span>
                </a>
            </li>
        </ul>
    </nav>
<?php
}
?>

