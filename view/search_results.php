<div id="results_header">
<h3>
<?php
$num_matches = count($protein_matches);
if ($num_matches > 1) {
	echo $num_matches . ' matches found for "' . $_POST['lookup'] . '"';
}
elseif ($num_matches == 1) {
	echo $num_matches . ' match found for "' . $_POST['lookup'] . '"';
}
if ($protein_matches == NULL) {
	echo 'Sorry, no matches found for "' . $_POST['lookup'] . '"!';
}
?>
</h3>
</div>
<div id="close_button">
<a href="#" onclick="$('#search_results').hide(); return false;"><img src="images/close_button.png" alt="close" width="18px" /></a>
</div>
<div id="show_results">
<?php
if ($protein_matches != NULL) {
	echo '<table>';
	foreach ($protein_matches as $protein) {
		echo '
		<tr>
		<td><strong><a href="#" onclick="
			$.post(\'index.php?ppi=' . $org . '&d=' . $dataset . '\', {\'protein_id\': \'' . $protein['entry'] . '\'}, 
				function(response) {
					$(\'#search_results\').html(response);
				}
			);
			">' . $protein['entry'] . '</a></strong></td>
		</tr>
		<tr>
		<td><small>' . $protein['protein_names'] . '</small></td>
		</tr>
		';
	}
}
?>
</div>