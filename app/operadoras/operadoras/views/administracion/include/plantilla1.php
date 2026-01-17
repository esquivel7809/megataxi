<?php
/**
 * plantilla para visualizar los modulos administrativos
 * autor: Jorge Serrano
 */
$this->load->view('include/hearderinicio');
$this->load->view('include/sloganinicio');
$this->load->view($vista_contenido);
$this->load->view('include/footerinicio');
?>