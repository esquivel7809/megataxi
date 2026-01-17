<?php
$this->load->view('include/hearder');
$this->load->view('include/slogan');
$this->load->view('include/menu');
$this->load->view('include/vencimiento_view');
foreach($vista_contenido_mod as $vista_mod):
$this->load->view($vista_mod);
endforeach;
//$this->load->view('include/lateral_derecha_view');
$this->load->view('include/footer');
?>