<?php
$this->load->view('include/hearderinformes');
//$this->load->view('include/menu');
foreach($vista_contenido_mod as $vista_mod):
$this->load->view($vista_mod);
endforeach;
$this->load->view('include/footerinformes');
?>