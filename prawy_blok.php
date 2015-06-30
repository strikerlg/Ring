		</div>
	<div id="sidebar">
	<?php
	if(!empty($uzytkownik['gracz'])){
		echo "
		<h2>Statystyki</h2>
		<table style='width:100%'>
		<tr>
			<td style='border-bottom:dashed 1px #000'>$$</td>
			<td align='right' style='border-bottom:dashed 1px #000'>".number_format($uzytkownik['kasa'],0,',','.')."</td>
		</tr>
		<tr>
			<td style='border-bottom:dashed 1px #000'>akcje</td>
			<td align='right' style='border-bottom:dashed 1px #000'>".$uzytkownik['akcje']." / ".$uzytkownik['akcje_max']."</td>
		</tr>
		<tr>
			<td style='border-bottom:dashed 1px #000'>zmęczenie</td>
			<td align='right' style='border-bottom:dashed 1px #000'>".$uzytkownik['zmeczenie']." / ".$uzytkownik['zmeczenie_max']."</td>
		</tr>
		<tr>
			<td style='border-bottom:dashed 1px #000'>ranking</td>
			<td align='right' style='border-bottom:dashed 1px #000'>".$uzytkownik['ranking']."</td>
		</tr>
		<tr>
			<td>boksowanie</td>
			<td align='right'>".$uzytkownik['boksowanie']."</td>
		</tr>
		<tr>
			<td>walka w parterze</td>
			<td align='right'>".$uzytkownik['walka_parter']."</td>
		</tr>
		<tr>
			<td>zapasy</td>
			<td align='right'>".$uzytkownik['zapasy']."</td>
		</tr>
		<tr>
			<td>kopanie</td>
			<td align='right'>".$uzytkownik['kopanie']."</td>
		</tr>
		<tr>
			<td style='border-bottom:dashed 1px #000'>kondycja</td>
			<td align='right' style='border-bottom:dashed 1px #000'>".$uzytkownik['kondycja']."</td>
		</tr>
		</table>
		";
	}
	?>
      
   </div>
    