<script language="javascript" type="text/javascript">
    //Definimos que el js se ejecute cuando la pagina este completamente cargada.
    $(document).ready(function() {
    });

</script>
<div class="clear"></div>
<div class="grid_12">
    <fieldset class="login">
        <legend>Auditoria de Cuenta medicas</legend>
            <?php

            $arrayjQueryOptions=array("changeMonth"=>"true","changeYear"=>"true","hideIfNoPrevNext"=>"true","maxDate"=>"+0d" );
            $arrayfechas=array("readonly" => "readonly","width" => 90,"maxlength"=>10, "jQueryOptions" => $arrayjQueryOptions);
            $options = array("Option #1", "Option #2", "Option #3");
            
            $form = new Form("layout_grid", 920);
            $form->configure(array(
                    "view" => new View_Grid(array(5, 6, 3, 5, 3, 7, 8)),
                    "prevent" => array("focus", "jQuery", "jQueryUI"),
            ));
            $form->addElement(new Element_Hidden("form", "layout_grid"));

            $form->addElement(new Element_Textbox("Registro N&ordm;:", "idregistroatencion"));
            $form->addElement(new Element_Date("Fecha:","fechaingreso",$arrayfechas));

            $form->addElement(new Element_Select("Origen Hospitalizaci&oacute;n:", "idorigenhospitalizacion", $options ));
            $form->addElement(new Element_Select("Situaci&oacute;n:", "idsituacion", $options ));
            $form->addElement(new Element_Textbox("Cama:", "cama"));
/*
            $form->addElement(new Element_State("M&eacute;dico:", "idmedico"));
            $form->addElement(new Element_Textbox("Especialidad:", "idespecialidad"));
            $form->addElement(new Element_Textbox("Dep.Procedencia:", "iddepartamento"));
            $form->addElement(new Element_Textbox("Mun.Procedencia:", "cama"));
            $form->addElement(new Element_Textbox("Cama:", "cama"));
            $form->addElement(new Element_State("Situaci&oacute;n:", "idsituacion"));
*/

            $form->addElement(new Element_Select("Identicaci&oacute;n Paciente:", "idtipodocumento", $options));
            $form->addElement(new Element_Textbox("Numero de Doc.:", "numerodocumento"));
            $form->addElement(new Element_Textbox("Nombre Paciente:", "nombrepaciente", array("width" => 220)));
            $form->addElement(new Element_Date("Fec.Nac:", "fechanacimiento",$arrayfechas));
            $form->addElement(new Element_Textbox("Edad:", "edadactualpaciente"));
            $form->addElement(new Element_Select("Gr. Etareo:", "idgrupoetareo", $options));

            $form->addElement(new Element_Select("Entidad Salud:", "idinstitucioneapb", $options));
            $form->addElement(new Element_Select("Contrato:", "idcontrato", $options));
            $form->addElement(new Element_Select("R&eacute;gimen:", "idregimen", $options));

            $form->addElement(new Element_Textbox("Id", "iddiagnosticoingreso", array("width" => 30)));
            $form->addElement(new Element_Textbox("Diagn&oacute;stico de Ingreso:", "nombrediagnosticoingreso"));
            $form->addElement(new Element_Textbox("Id", "iddiagnosticootro", array("width" => 30)));
            $form->addElement(new Element_Textbox("Otro Diagn&oacute;stico:", "nombrediagnosticootro"));
            $form->addElement(new Element_Select("Sala:", "idsalacirugia", $options));

            $form->addElement(new Element_Select("Entidad Salud:", "idinstitucioneapb", $options));
            $form->addElement(new Element_Select("Contrato:", "idcontrato", $options));
            $form->addElement(new Element_Select("R&eacute;gimen:", "idregimen", $options));

            $form->addElement(new Element_Textbox("Id", "iddiagnosticoegreso", array("width" => 30)));
            $form->addElement(new Element_Textbox("Diagn&oacute;stico de Egreso:", "nombrediagnosticoegreso"));
            $form->addElement(new Element_Select("Alto Costo:", "altocosto", $options));
            $form->addElement(new Element_Select("Tipo Egreso:", "idtipoegreso", $options));
            $form->addElement(new Element_Select("Est. Egreso:", "idestadoegreso", $options));
            $form->addElement(new Element_Select("Destino:", "iddestinopaciente", $options));
            $form->addElement(new Element_Select("Inst. Destino:", "idestadoegreso", $options));

            $form->addElement(new Element_Textbox("N&ordm; Factura:", "numerofactura", array("width" => 70)));
            $form->addElement(new Element_Date("Fecha:", "fechafactura",$arrayfechas));
            $form->addElement(new Element_Select("Recobro:", "idrecobro", $options));
            $form->addElement(new Element_Textbox("Nombre Facturador:", "nombrefacturador"));
            $form->addElement(new Element_Select("Dig.Vr.Fac:", "habilitarvalor", $options));
            $form->addElement(new Element_Textbox("Vr. Factura:", "valorfactura"));
            $form->addElement(new Element_Textbox("Vr. Glosas:", "valorglosas"));
            $form->addElement(new Element_Textbox("Vr. a Pagar:", "valorpagar"));

            //$form->addElement(new Element_Button);
            $form->render();
            ?>
   </fieldset>
</div>
