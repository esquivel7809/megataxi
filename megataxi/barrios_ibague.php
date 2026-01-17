<?php
include('Connections/conexion.php');
for($i=0;$i<count($_POST[barrios]);$i++){

//	mysql_query("insert into barrios(barrio) values('".$_POST[barrios][$i]."')",$conexion);

}



?>


<form action="" method="post">

<select name="barrios[]" id="barrios" multiple="multiple">

<option value="7860">Alejandra</option>
<option value="7851">Alto de la Pola</option>
<option value="7843">Baitazar</option>
<option value="7849">Brisas del Combeima</option>
<option value="7852">Centro</option>
<option value="7853">Chapetón</option>
<option value="7844">Combeima</option>
<option value="7859">Coqueta</option>
<option value="7850">Edén de Interlaken</option>
<option value="7845">Estación</option>
<option value="7854">Interlaken</option>
<option value="7846">La Pola</option>
<option value="7858">La Pola Sector Los Tanques</option>
<option value="7855">La vega</option>
<option value="7847">Libertador</option>
<option value="7856">Pueblo Nuevo</option>
<option value="7857">Pueblo Nuevo parte baja</option>
<option value="7848">San Pedro Alejandrino</option>


              <option value="8171">Alto de santa Helena</option>
<option value="8179">América</option>
<option value="8172">Arkalena</option>
<option value="8194">Bosques de santa Helena</option>
<option value="8180">Boyacá</option>
<option value="8181">Casa Club</option>
<option value="8173">Cádiz</option>
<option value="8174">Departamental</option>
<option value="8182">Federico Lleras</option>
<option value="8175">Hipódromo</option>
<option value="8176">La Francia</option>
<option value="8184">Las Palmas</option>
<option value="8199">Laureles</option>
<option value="8177">Macarena</option>
<option value="8185">Magisterio</option>
<option value="8178">Metaima I</option>
<option value="8186">Metaima II</option>
<option value="8187">Montealegre</option>
<option value="8189">Nacional</option>
<option value="8188">Naciones Unidas</option>
<option value="8195">Primero de Mayo</option>
<option value="8190">San Cayetano</option>
<option value="8191">San Fernando</option>
<option value="8197">San P. Alejandrino</option>
<option value="8192">Santa Helena</option>
<option value="8196">Santa María Claret</option>
<option value="8193">Torres del Ferrocarril</option>
<option value="8183">la Castellana</option>
<option value="8198">santander</option>


              <option value="8200">Alto de la cruz</option>
<option value="8212">Departamental</option>
<option value="8201">Doce de Octubre</option>
<option value="8202">El Bosque parte Baja</option>
<option value="8203">El Playón</option>
<option value="8204">Garzón</option>
<option value="8205">Independiente Parte Baja</option>
<option value="8213">La Cartagena</option>
<option value="8206">Las Brisas</option>
<option value="8207">Los Mártires</option>
<option value="8208">Rodríguez Andrade</option>
<option value="8210">San Vicente de Paúl</option>
<option value="8209">Villa del rio</option>
<option value="8211">la Castellana</option>



              <option value="8214">Alberto Santo Fimio</option>
<option value="8247">Andrés Lopéz de Galarza</option>
<option value="8246">Avenida</option>
<option value="8229">Avenida Parte Baja</option>
<option value="8215">Avenida cerro Gordo</option>
<option value="8230">Bella Vista</option>
<option value="8253">Carlos Lleras</option>
<option value="8233">Cerro Fordo</option>
<option value="8226">Cural</option>
<option value="8236">Eduardo Santos</option>
<option value="8216">Galán</option>
<option value="8237">Industrial</option>
<option value="8217">Kennedy</option>
<option value="8238">La Gaitana</option>
<option value="8250">La Pradera</option>
<option value="8248">La Pradera</option>
<option value="8227">La comuna de los Cova</option>
<option value="8224">La reforma</option>
<option value="8218">Las Vegas</option>
<option value="8219">Los Cámbulos</option>
<option value="8251">Los Guaduales</option>
<option value="8249">Los Nogales</option>
<option value="8239">López de Galarza</option>
<option value="8240">Metaliana</option>
<option value="8220">Murillo Toro</option>
<option value="8221">Ricaute Parte Alta</option>
<option value="8242">Ricaute Parte Baja</option>
<option value="8222">San José</option>
<option value="8232">Urbanizacion Divino Niño</option>
<option value="8228">Urbanizacion el Danubio</option>
<option value="8235">Urbanización Arkaida</option>
<option value="8241">Urbanización La Primavera</option>
<option value="8225">Urbanización Rosa Badillo de uribe</option>
<option value="8243">Urbanización Venecia</option>
<option value="8223">Urbanización Villa Luces</option>
<option value="8244">Villa Claudia</option>
<option value="8234">Villa Leidy</option>
<option value="8231">Villa Yuli</option>
<option value="8252">Viscaya</option>
<option value="8245">Yuldaima</option>


              <option value="8254">Boquerón</option>
<option value="8270">Colinas del Sur</option>
<option value="8269">Dario Echandía</option>
<option value="8262">El Tejar I</option>
<option value="8261">El Vagón </option>
<option value="8263">Granada</option>
<option value="8255">Jazmín</option>
<option value="8259">Juan francisco</option>
<option value="8260">La Flonda Parte Baja</option>
<option value="8264">La Florida</option>
<option value="8265">La Unión</option>
<option value="8257">Las Colinas</option>
<option value="8258">Llano Largo</option>
<option value="8267">Miramar</option>
<option value="8268">San Isidro</option>
<option value="8266">Sector los Túneles</option>
<option value="8256">la Isla</option>



              <option value="7881">20 de Julio</option>
<option value="7862">Alaskita</option>
<option value="7861">Aleska</option>
<option value="7864">Ancón</option>
<option value="7888">Ancón Tesorito</option>
<option value="7863">Augusto E. Medina</option>
<option value="7886">Belencito</option>
<option value="7885">Belén </option>
<option value="7865">Belén Parte Alta</option>
<option value="7866">Centenario</option>
<option value="7867">Clarita Botero</option>
<option value="7889">Conjunto Cerrado Fontenova</option>
<option value="7890">Conjunto Cerrado Pablo VI</option>
<option value="7887">El Oasis</option>
<option value="7873">La Paz</option>
<option value="7868">La Sofía</option>
<option value="7882">Los Alpes</option>
<option value="7883">Los Pínos</option>
<option value="7874">Malabar</option>
<option value="7891">Multifamiliares la aurora</option>
<option value="7884">Pan de Azúcar</option>
<option value="7880">Pueblo Nuevo</option>
<option value="7875">San Diego</option>
<option value="7876">Santa Bárbara</option>
<option value="7877">Santa Cruz</option>
<option value="7878">Siete de Agosto</option>
<option value="7892">Torres de Líbano</option>
<option value="7879">Trinidad</option>
<option value="7870">UrbanizacionHimalaya</option>
<option value="7869">Urbanización Irazú</option>
<option value="7872">Urbanización Pablo VI</option>
<option value="7871">Urbanización la Aurora</option>
<option value="7893">Villa Adriana</option>



              <option value="7894">Antonio Nariño</option>
<option value="7908">Betalcázar</option>
<option value="7895">Calambeo</option>
<option value="7909">Carmenza Rocha</option>
<option value="7903">Diamante</option>
<option value="7918">El Cafetal</option>
<option value="7896">El Carmén</option>
<option value="7910">Fenalco</option>
<option value="7900">Fénix</option>
<option value="7897">Gaitán Parte Alta</option>
<option value="7911">INEM</option>
<option value="7905">La Ceiba</option>
<option value="7898">La Esperanza</option>
<option value="7912">La Granja</option>
<option value="7906">La Jaula</option>
<option value="7913">San Jorge</option>
<option value="7901">San Simón Parte Alta</option>
<option value="7914">San Simón parte Baja</option>
<option value="7916">Santa Lucía</option>
<option value="7899">Sector las Acacias</option>
<option value="7904">Torres Los Periodista</option>
<option value="7907">Urbanización Hacienda Calambeo</option>
<option value="7902">Urbanización Villa Pinzón</option>
<option value="7917">Villa Ilusión</option>
<option value="7915">Viveros</option>




              <option value="7919">Alfonso López</option>
<option value="7943">Balcones Navarra</option>
<option value="7929">Calarcá</option>
<option value="7920">Caracolí</option>
<option value="7930">Castilla</option>
<option value="7922">Cordobita</option>
<option value="7921">Córdoba</option>
<option value="7931">Córdoba Parte Baja</option>
<option value="7925">El Limonar 5 Sector</option>
<option value="7923">El Triunfo</option>
<option value="7932">Gaitán Parte Baja</option>
<option value="7924">Gardines de Navarra</option>
<option value="7945">Hacienda Piedra Pintada</option>
<option value="7933">Las Viudas</option>
<option value="7940">Onzaga</option>
<option value="7946">Piedra Pintada Alta</option>
<option value="7934">Piedra Pintada P.B</option>
<option value="7926">Pijao</option>
<option value="7935">Restrepo</option>
<option value="7942">Rincón Piedra Pintada</option>
<option value="7927">San Carlos</option>
<option value="7936">San Luis</option>
<option value="7944">Santa Lucía de Navarra</option>
<option value="7928">Sorrento</option>
<option value="7941">Urbanización El Pijao</option>
<option value="7937">Urbanización Villa Teresa</option>
<option value="7938">Villa Marlén I</option>
<option value="7939">Villa Marlén II</option>




              <option value="7969">Aptos Multifamiliares</option>
<option value="7948">Arka Lucía</option>
<option value="7959">Arkacentro</option>
<option value="7960">Arkamónica</option>
<option value="7961">El Edén</option>
<option value="7962">El Prado</option>
<option value="7951">Jordán IV Etapa</option>
<option value="7953">Jordán IX Etapa</option>
<option value="7950">Jordán Multifamiliares</option>
<option value="7963">Jordán VI Etapa</option>
<option value="7952">Jordán VII Etapa</option>
<option value="7964">Jordán VIII Etapa</option>
<option value="7965">La Campiña</option>
<option value="7954">Las Margaritas</option>
<option value="7966">Las Orquideas</option>
<option value="7955">Los Arrayanes</option>
<option value="7967">Los Ocobos</option>
<option value="7956">Los Parrales</option>
<option value="7968">Macadamia</option>
<option value="7970">Tierra Linda</option>
<option value="7947">Urbanización Almería</option>
<option value="7958">Urbanización Andalucía</option>
<option value="7949">Urbanización Calatayud</option>
<option value="7957">Urbanización Rincón de la Campiña</option>




              <option value="7971">Ambalá</option>
<option value="8012">Apartamentos Entre Ríos</option>
<option value="7996">Arkala II</option>
<option value="7987">Arkalucia-macademia</option>
<option value="8001">Bosques del Vergel</option>
<option value="8020">Brisas del Pedregal</option>
<option value="7976">Caminos del Vergel</option>
<option value="7990">Carandu Quinto</option>
<option value="7994">Cañaveral II</option>
<option value="8019">Cañaveral III</option>
<option value="7991">El Vergel</option>
<option value="8003">El Vergel</option>
<option value="7978">Entre Ríos</option>
<option value="7997">Girasol</option>
<option value="7988">Ibagué 2000</option>
<option value="8004">La Arboleda</option>
<option value="8013">La Balsa</option>
<option value="8005">La Gaviota</option>
<option value="8009">Las Delicias</option>
<option value="8010">Los Angeles</option>
<option value="7984">Los Ciruelos</option>
<option value="7981">Los Guabandayes</option>
<option value="7986">Los Mangarinos</option>
<option value="7998">Mira Flores</option>
<option value="8016">Nancahuazu</option>
<option value="7989">Parque Res. La Primavera</option>
<option value="8000">Portal del Bosque</option>
<option value="8015">Primavera</option>
<option value="7992">Rincón del Bosque</option>
<option value="7977">Rincón del Pedregal</option>
<option value="8008">Rincón del Vergel</option>
<option value="8007">San Antonio</option>
<option value="7982">San Francisco</option>
<option value="7995">Terrazas de Ambalá</option>
<option value="8014">Torres del Bergel</option>
<option value="8011">Triunfo Bella Vista</option>
<option value="7972">Urbanización Ambalá</option>
<option value="7973">Urbanización Antares</option>
<option value="7974">Urbanización Arkalá</option>
<option value="7975">Urbanización Arkambuco</option>
<option value="7980">Urbanización Colinas del Norte</option>
<option value="7999">Urbanización Los Alpes</option>
<option value="8006">Urbanización Los Cámbulos</option>
<option value="8017">Urbanización Pedregal II </option>
<option value="7993">Urbanización Pedregal III</option>
<option value="8018">Urbanización Pedregal IV</option>
<option value="8002">Urbanización el Pedregal</option>
<option value="7979">Urbanización la Esperanza</option>
<option value="7985">Villa Gloria</option>
<option value="7983">Yurupán</option>




              <option value="8052">Cantabeia</option>
<option value="8065">Carlos Lleras</option>
<option value="8043">Ceiba Norte</option>
<option value="8028">Chicó</option>
<option value="8041">Darien San Lucas</option>
<option value="8021">El Salado</option>
<option value="8068">Floresta</option>
<option value="8048">La Cabaña Confacopy</option>
<option value="8022">La Ceiba</option>
<option value="8050">La Floresta</option>
<option value="8031">La Victoria</option>
<option value="8029">Los Alpes</option>
<option value="8023">Los Lagos</option>
<option value="8042">Los Músicos</option>
<option value="8061">Modelia I </option>
<option value="8039">Modelia II</option>
<option value="8034">Montecarlos</option>
<option value="8046">Montecarlos II</option>
<option value="8069">Nuevo Horizonte Salado</option>
<option value="8024">Oviedo</option>
<option value="8035">Pacandé</option>
<option value="8030">Palo Grande</option>
<option value="8025">Parcelación Ibagué</option>
<option value="8062">País</option>
<option value="8067">Praderas del Norte</option>
<option value="8047">Salado Sección Ceiba Sur</option>
<option value="8064">San Lucas II</option>
<option value="8063">San Sebastián</option>
<option value="8040">SanTropel</option>
<option value="8051">Santa Ana</option>
<option value="8032">Sector La Cabaña</option>
<option value="8056">Tieera Firme</option>
<option value="8072">Tierra Grata</option>
<option value="8049">Urbanización Comfacopy</option>
<option value="8053">Urbanización Comfatolima</option>
<option value="8044">Urbanización El Salado</option>
<option value="8058">Urbanización Fuente Santa</option>
<option value="8057">Urbanización Fuentes El Salado</option>
<option value="8036">Urbanización Pedro Villa Marín</option>
<option value="8026">Urbanización Protecho</option>
<option value="8055">Urbanización San Luis Gonzaga</option>
<option value="8037">Urbanización San Pablo</option>
<option value="8054">Urbanización Tolima Grande</option>
<option value="8027">Urbanización Villa Clara</option>
<option value="8038">Urbanización Villa Martha</option>
<option value="8033">Urnanización la Victoria</option>
<option value="8060">Villa Basílica</option>
<option value="8071">Villa Ciera</option>
<option value="8045">Villa Cindy</option>
<option value="8066">Villa Emilia</option>
<option value="8059">Villa Julieta</option>
<option value="8070">Villa Martha</option>



              <option value="8108">Acacias</option>
<option value="8103">Aguamarina</option>
<option value="8073">Atolsure</option>
<option value="8110">Buenaventura</option>
<option value="8117">C. Simón Bolívar IV Etapa</option>
<option value="8112">C. Simón Bolívar Sec. Bait.</option>
<option value="8100">Carlos Pizarro</option>
<option value="8074">Ciudad Blanca</option>
<option value="8115">Ciudad Simón Bolivar II Etapa</option>
<option value="8096">Ciudad Simón Bolívar I Etapa</option>
<option value="8075">Comuneros</option>
<option value="8086">Cond. Nueva Andalucía</option>
<option value="8111">El Bunde</option>
<option value="8089">Germán Huertas</option>
<option value="8090">Jardín I Etapa</option>
<option value="8091">Jardín II Etapa</option>
<option value="8080">Jardín III Etapa</option>
<option value="8113">Jardín P.A. Sec. Bait.</option>
<option value="8114">Jardín P.a. Sec. Carac</option>
<option value="8104">Jardín Santander</option>
<option value="8116">Jardín Sec. Diamante</option>
<option value="8099">Jardín Sector Las Acacias</option>
<option value="8092">Jardín del Campo</option>
<option value="8119">Jardín septor los Pinos</option>
<option value="8109">Mi Tolima</option>
<option value="8081">Musicalia</option>
<option value="8076">Nuevo Armero</option>
<option value="8101">Nuevo Combeima</option>
<option value="8093">Nuevo Palermo</option>
<option value="8082">Palermo</option>
<option value="8094">Palmar</option>
<option value="8121">Prado I y II</option>
<option value="8083">Protecho II</option>
<option value="8095">Roberto A. Calderón</option>
<option value="8084">San Vicente de Paul</option>
<option value="8122">Sect. El Porvenir</option>
<option value="8088">Simón Bolívar III Etapa</option>
<option value="8097">Sintratolima</option>
<option value="8105">Topacio</option>
<option value="8120">Topacio Plan D</option>
<option value="8098">Tulio Varón</option>
<option value="8124">Urbanización Esmeralda</option>
<option value="8085">Urbanización Martín Reyes</option>
<option value="8079">Urbanización Quinta Avenida</option>
<option value="8087">Urbanización San Luisa</option>
<option value="8106">Urbanización Villa Marcela</option>
<option value="8107">Valparaiso</option>
<option value="8123">Villa Magdalena</option>
<option value="8077">Villa del Norte</option>
<option value="8078">Villa del Palmar</option>
<option value="8102">Villa del Sol</option>
<option value="8118">dartecho</option>



              <option value="8125">Alfonso Uribe Badillo</option>
<option value="8167">Altamira</option>
<option value="8126">Aparco San Francisco</option>
<option value="8153">Arkaniza II Etapa</option>
<option value="8127">Arkaparaiso</option>
<option value="8142">B. La Floresta</option>
<option value="8137">Bello Horizonte</option>
<option value="8156">Bosque de la Alameda</option>
<option value="8128">Ciudad Luz</option>
<option value="8135">Ciudad las Americas</option>
<option value="8141">Ciudad tunal</option>
<option value="8170">Ciudadela Comfenalco</option>
<option value="8129">Cutucumay</option>
<option value="8140">El Campestre</option>
<option value="8130">El Poblado</option>
<option value="8164">Estación Picaleña</option>
<option value="8148">Fabiolandia</option>
<option value="8131">Jordán I Etapa</option>
<option value="8157">Jordán I Etapa detrás de Presentación</option>
<option value="8166">Jordán II Etapa</option>
<option value="8158">Jordán III Etapa</option>
<option value="8132">La Soborna</option>
<option value="8165">Mira Flores Conjunto Cerrado</option>
<option value="8133">Mirolindo</option>
<option value="8134">Papayo</option>
<option value="8152">Picaleña Parte Alta</option>
<option value="8168">Picaleñita</option>
<option value="8139">Piedra Pintada Parte Baja</option>
<option value="8151">San Martín Picaleña</option>
<option value="8149">Santa Rita</option>
<option value="8169">Terrazas del Campestre</option>
<option value="8147">Urbanizacion Villa Arcaida</option>
<option value="8136">Urbanización Arkaniza</option>
<option value="8143">Urbanización Las Palmeras</option>
<option value="8145">Urbanización Niza</option>
<option value="8160">Urbanización Taití</option>
<option value="8163">Urbanización Villa Café</option>
<option value="8144">Valparaiso</option>
<option value="8161">Valparaiso II Etapa</option>
<option value="8155">Valparaiso III Etapa</option>
<option value="8162">Varsovia I Etapa</option>
<option value="8154">Varsovia II Etapa</option>
<option value="8150">Versales</option>
<option value="8138">Villa Marina</option>
<option value="8159">Villa del Pilar</option>
<option value="8146">picaleña</option>

</select>

<input type="submit" value="enviar">
</form>


<script language="javascript">

	sel=document.getElementById('barrios');
	cantidad=sel.length ;
	

	for(i=0;i<cantidad;i++){
		sel.options[i].value=sel.options[i].text;
	}
	


</script>