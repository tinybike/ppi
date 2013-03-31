<div id="close_button">
<a href="#" onclick="$('#search_results').hide(); return false;"><img src="images/close_button.png" alt="close" width="18px" /></a>
</div>
<?php
$genes = explode(' ', $protein['gene_names']);
$proteins = array();
$p_inner = preg_split('/\\) \\(|\\(|\\)/', $protein['protein_names'], -1, PREG_SPLIT_NO_EMPTY);
foreach($p_inner as $prot) {
	$proteins[] = $prot;
}
echo 
'
<div id="protein_details">
<table>
<tr>
<th></th>
<th><a href="http://www.uniprot.org/uniprot/' . $protein['entry'] . '">' . $protein['entry'] . '</a></th>
</tr>
<tr>
<td></td>
<td><i>' . $protein['organism'] . '</i></td>
</tr>
';
$counter = 0;
foreach ($proteins as $prot) {
	$label = (!$counter) ? 'Protein name(s):' : '';
	echo '
	<tr>
	<td>' . $label . '</td>
	<td>' . $prot . '</td>
	</tr>
	';
	$counter++;
}
$counter = 0;
foreach ($genes as $gene) {
	$label = (!$counter) ? 'Gene name(s):' : '';
	echo '
	<tr>
	<td>' . $label . '</td>
	<td>' . $gene . '</td>
	</tr>
	';
	$counter++;
}

echo '
<tr>
<td>Length:</td>
<td>' . $protein['length'] . '</td>
</tr>
</table>
</div>
';
?>