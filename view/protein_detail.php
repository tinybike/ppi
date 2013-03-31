<div id="results_header">
<?php
echo '
<h3><a href="http://www.uniprot.org/uniprot/' . $protein['entry'] . '">' . $protein['entry'] . '</a></h3>
<i>' . $protein['organism'] . '</i>
';
?>
</div>
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
';
$counter = 0;
foreach ($ss_links as $link) {
	$label = (!$counter) ? 'Links (small-scale):' : '';
	echo '
	<tr>
	<td>' . $label . '</td>
	<td><a href="#" onclick="
		$.post(\'index.php?ppi=' . $org . '&d=' . $dataset . '\', {\'protein_id\': \'' . $link[0] . '\'}, 
				function(response) {
					$(\'#search_results\').html(response);
				}
			); 
			return false;
		">' . $link[0] . '</a></td>
	</tr>
	';
	$counter++;
}
$counter = 0;
foreach ($hc_links as $link) {
	$label = (!$counter) ? 'Links (hi-confidence):' : '';
	echo '
	<tr>
	<td>' . $label . '</td>
	<td><a href="#" onclick="
		$.post(\'index.php?ppi=' . $org . '&d=' . $dataset . '\', {\'protein_id\': \'' . $link[0] . '\'}, 
				function(response) {
					$(\'#search_results\').html(response);
				}
			); 
			return false;
		">' . $link[0] . '</a></td>
	</tr>
	';
	$counter++;
}
echo '
</table>
</div>
';
?>