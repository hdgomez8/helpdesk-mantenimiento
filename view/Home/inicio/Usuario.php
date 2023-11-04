<div class="container-fluid">
    <div class="row">
        <div class="col-xl-12">
            <div class="row">
                <div class="col-sm-2">
                    <a href="..\ConsultarTicketPendientesClientes\">
                        <article class="statistic-box custom-orange">
                            <div>
                                <div class="number" id="lbltotalabierto"></div>
                                <div class="caption">
                                    <div>Abiertas</div>
                                </div>
                            </div>
                        </article>
                    </a>
                </div>
                <div class="col-sm-2">
                    <a href="..\ConsultarTicketPendientesCierreCliente\">
                        <article class="statistic-box custom-green">
                            <div>
                                <div class="number" id="lbltotalxvistobueno"></div>
                                <div class="caption">
                                    <div>Por Visto Bueno</div>
                                </div>
                            </div>
                        </article>
                    </a>
                </div>

                <?php if ($_SESSION["usu_id"] == 522) : ?>
                    <div class="col-sm-2">
                        <a href="..\ConsultarTicketPendientesEnCompras\">
                            <article class="statistic-box green">
                                <div>
                                    <div class="number" id="lbltotalencompras"></div>
                                    <div class="caption">
                                        <div>En Compras</div>
                                    </div>
                                </div>
                            </article>
                        </a>
                    </div>
                <?php endif; ?>



                <div class="col-sm-2">
                    <a href="..\ConsultarTicket\">
                        <article class="statistic-box red">
                            <div>
                                <div class="number" id="lbltotalcerrado"></div>
                                <div class="caption">
                                    <div>Total Cerrados</div>
                                </div>
                            </div>
                        </article>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>