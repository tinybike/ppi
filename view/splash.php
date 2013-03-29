<?php include 'view/navbar.php'; ?>
<!DOCTYPE html>
<html>
<head>
<title>Protein interaction networks</title>
<?php include 'view/headers.php'; ?>
<link href='css/bootstrap.min.css' rel='stylesheet' type='text/css'>
<link href='css/bootstrap-responsive.min.css' rel='stylesheet' type='text/css'>
<script src="js/jquery.lightbox_me.js"></script>
<script src="js/sigma.min.js"></script>
<script src="js/sigma.parseGexf.js"></script>
<script src="js/sigma.parseJson.js"></script>
<script>
$(document).ready(function() {

	// Drop-down boxes
	$('#login-trigger').click(function() {
		$(this).next('#login-content').toggle();
		$(this).toggleClass('active');							
		if ($(this).hasClass('active')) {
			$(this).find('span').html('&#x25B2;');
		}
		else {
			$(this).find('span').html('&#x25BC;');
		}
	})
	$('#how-trigger').click(function() {
		$(this).next('#how-content').toggle();
		$(this).toggleClass('active');							
		if ($(this).hasClass('active')) {
			$(this).find('span').html('&#x25B2;');
		}
		else {
			$(this).find('span').html('&#x25BC;');
		}
	})

	// Signup lightbox
	$('#try-1').click(function(e) {
		$('#sign_up').lightbox_me({
			centered: true, 
			onLoad: function() { 
				$('#sign_up').find('input:first').focus()
				}
			});
		e.preventDefault();
	});
});

function init() {
	// Instantiate sigma.js and customize rendering
	var sigInst = sigma.init(document.getElementById('sigma-example')).drawingProperties({
		defaultLabelColor: '#fff',
		defaultLabelSize: 14,
		defaultLabelBGColor: '#fff',
		defaultLabelHoverColor: '#000',
		labelThreshold: 11,
		defaultEdgeType: 'curve'
	}).graphProperties({
		minNodeSize: 0.5,
		maxNodeSize: 4,
		minEdgeSize: 1,
		maxEdgeSize: 1
	}).mouseProperties({
		maxRatio: 4
	});
 
	// Parse a JSON encoded file to fill the graph
	var organism = '<?php echo $org; ?>';
	sigInst.parseJson('data/' + organism + '_ss.json', function() { sigInst.draw(); });
	 
	// Bind events
	var greyColor = '#ccc';
	sigInst.bind('overnodes',function(event){
		var nodes = event.content;
		var neighbors = {};
		sigInst.iterEdges(function(e){
			if(nodes.indexOf(e.source)<0 && nodes.indexOf(e.target)<0){
				if(!e.attr['grey']){
					e.attr['true_color'] = e.color;
					e.color = greyColor;
					e.attr['grey'] = 1;
				}
			}
			else{
				e.color = e.attr['grey'] ? e.attr['true_color'] : e.color;
				e.attr['grey'] = 0;
				 
				neighbors[e.source] = 1;
				neighbors[e.target] = 1;
			}
		}).iterNodes(function(n){
			if(!neighbors[n.id]){
				if(!n.attr['grey']){
					n.attr['true_color'] = n.color;
					n.color = greyColor;
					n.attr['grey'] = 1;
				}
			}
			else{
				n.color = n.attr['grey'] ? n.attr['true_color'] : n.color;
				n.attr['grey'] = 0;
			}
		}).draw(2,2,2);
	}).bind('outnodes',function(){
		sigInst.iterEdges(function(e){
			e.color = e.attr['grey'] ? e.attr['true_color'] : e.color;
			e.attr['grey'] = 0;
		}).iterNodes(function(n){
			n.color = n.attr['grey'] ? n.attr['true_color'] : n.color;
			n.attr['grey'] = 0;
		}).draw(2,2,2);
	});
	
	// Draw the graph
	sigInst.draw();
}

if (document.addEventListener) {
	document.addEventListener('DOMContentLoaded', init, false);
}
else {
	window.onload = init;
}
</script>
</head>

<body>
<div class="wrapper">
	<?php create_navbar(); ?>
	<br />
	<div class="span12 sigma-parent" id="sigma-example-parent">
		<div class="sigma-expand" id="sigma-example"></div>
	</div>
	<div id="leftbar">
	<table>
		<tr>
		<td id="sce"><a href="index.php?ppi=sce">budding yeast</a></td>
		<td id="dme"><a href="index.php?ppi=dme">fruit fly</a></td>
		<td id="hsa"><a href="index.php?ppi=hsa">human</a></td>
		</tr>
		<tr>
		<td id="spo"><a href="index.php?ppi=spo">fission yeast</a></td>
		<td id="rno"><a href="index.php?ppi=rno">rat</a></td>
		<td id="mmu"><a href="index.php?ppi=mmu">mouse</a></td>
		</tr>
		<tr>
		<td id="ath"><a href="index.php?ppi=ath">arabidopsis</a></td>
		<td id="cel"><a href="index.php?ppi=cel">worm</a></td>
		<td id="eco"><a href="index.php?ppi=eco">E. coli</a></td>
		</tr>
	</table>
	</div>
	<script>
	$('#<?php echo $org; ?>').css('background-color', '#ffcccc');
	</script>
	<div id="summary">
	<table>
		<tr><th><a href="<?php echo $summary['url']; ?>"><?php echo $summary['common']; ?> <i>(<?php echo $summary['name']; ?>)</a></i></th></tr>
		<tr><td>proteins: <?php echo $summary['nodes']; ?></td></tr>
		<tr><td>interactions: <?php echo $summary['edges']; ?></td></tr>
		<tr><td>average degree: <?php echo $summary['average_k']; ?></td></tr>
		<tr><td>clustering coefficient: <?php echo $summary['clustering']; ?></td></tr>
		<tr><td>modularity: <?php echo $summary['modularity']; ?></td></tr>
		<tr><td>components: <?php echo $summary['component']; ?></td></tr>
		<tr><td>diameter: <?php echo $summary['diameter']; ?></td></tr>
		<tr><td>average path length: <?php echo $summary['average_l']; ?></td></tr>
		</tr>
	</table>
	</div>
	<div id="rightbar">
		<table>
			<tr><th>datasets</th></tr>
			<tr><td><span class="hover-item"><a href="http://thebiogrid.org/">BioGRID</a>
				<span>physical and genetic interactions</span>
			</span></td></tr>
			<tr><td><span class="hover-item"><a href="http://hintdb.hgc.jp/htp/index.html">HitPredict</a>
				<span>small-scale 'high-confidence' data, and predicted interactions based on Bayesian inference</span>
			</span></td></tr>
			<tr><td><span class="hover-item"><a href="http://string-db.org/">STRING</a>
				<span>database of known and predicted protein interactions, includes direct (physical) and indirect (functional) associations</span>
			</span></td></tr>
			<tr><td><span class="hover-item"><a href="https://interfly.med.harvard.edu/">DPiM</a>
				<span>protein interaction map of the Drosophila melanogaster proteome</span>
			</span></td></tr>
			<tr><td><span class="hover-item"><a href="http://www.ebi.ac.uk/intact/">IntAct</a>
				<span>open source database system and analysis tools for molecular interaction data</span>
			</span></td></tr>
			<tr><td><span class="hover-item"><a href="http://mint.bio.uniroma2.it/mint/Welcome.do">MINT</a>
				<span>protein-protein interactions mined from the scientific literature by expert curators</span>
			</span></td></tr>
			<tr><td><span class="hover-item"><a href="http://dip.doe-mbi.ucla.edu/dip/Main.cgi">DIP</a>
				<span>experimentally determined interactions between proteins, combining information from a variety of sources</span>
			</span></td></tr>
			<tr><td><span class="hover-item"><a href="http://www.hprd.org/">HPRD</a>
				<span>human protein reference database</span>
			</span></td></tr>
			<tr><td><span class="hover-item"><a href="http://mips.helmholtz-muenchen.de/proj/ppi/">MIPS</a>
				<span>collection of manually curated high-quality PPI data collected from the scientific literature by expert curators</span>
			</span></td></tr>
			<tr><td><span class="hover-item"><a href="http://www.arabidopsis.org/portals/proteome/proteinInteract.jsp">TAIR</a>
				<span>Arabidopsis protein-protein interaction data curated from the literature</span>
			</span></td></tr>
		</table>
		<br />
		<table>
			<tr><th>tools</th></tr>
			<tr><td><span class="hover-item"><a href="http://www.mathworks.com/matlabcentral/fileexchange/10922">MatlabBGL</a>
				<span>very fast graphs package for Matlab</span>
			</span></td></tr>
			<tr><td><span class="hover-item"><a href="https://sites.google.com/a/brain-connectivity-toolbox.net/bct/Home">Brain Connectivity Toolbox</a>
				<span>Matlab scripts to calculate most standard graph-theoretic quantities</span>
			</span></td></tr>
			<tr><td><span class="hover-item"><a href="http://www.cmth.bnl.gov/%7Emaslov/matlab.htm">Sergei Maslov's website</a>
				<span>Matlab scripts for degree-preserving network rewiring and degree-degree correlation maps</span>
			</span></td></tr>
			<tr><td><span class="hover-item"><a href="https://sites.google.com/a/brain-connectivity-toolbox.net/bct/Home/functions/modularity_louvain_und.m?attredirects=0">modularity calculator</a>
				<span>Matlab implementation of the Louvain algorithm to calculate network modularity</span>
			</span></td></tr>
			<tr><td><span class="hover-item"><a href="http://cbg.garvan.unsw.edu.au/pina/">PINA</a>
				<span>integrated platform for protein interaction network construction, filtering, analysis, visualization and management</span>
			</span></td></tr>
			<tr><td><span class="hover-item"><a href="http://cytoscape.org">Cytoscape</a>
				<span>open source software platform for visualizing complex networks and integrating these with any type of attribute data</span>
			</span></td></tr>
			<tr><td><span class="hover-item"><a href="http://mips.helmholtz-muenchen.de/genre/proj/mpact">MPact</a>
				<span>common access point to interaction resources at MIPS</span>
			</span></td></tr>
			<tr><td><span class="hover-item"><a href="http://snap.stanford.edu/snap/index.html">SNAP</a>
				<span>general purpose, high performance system for analysis and manipulation of large networks</span>
			</span></td></tr>
			<tr><td><span class="hover-item"><a href="http://snap.stanford.edu/snap/index.html">APID</a>
				<span>Agile Protein Interaction DataAnalyzer: interactive bioinformatic web-tool that has been developed to allow exploration and analysis of main currently known information about protein-protein interactions integrated and unified in a common and comparative platform</span>
			</span></td></tr>
			<tr><td><span class="hover-item"><a href="http://sigmajs.org/">sigma.js</a>
				<span>open-source lightweight JavaScript library to draw graphs</span>
			</span></td></tr>
			<tr><td><span class="hover-item"><a href="https://gephi.org/">Gephi</a>
				<span>interactive visualization and exploration platform for all kinds of networks and complex systems, dynamic and hierarchical graphs</span>
			</span></td></tr>
		</table>
	</div>
	<div class="push"></div>
</div>
<div id="footer">&copy; 2012 - 2013 <a href="http://www.tinybike.net">Jack Peterson</a>.  All rights reserved.</div>

<!--- Sign-up lightbox --->
<div id="sign_up">
	<h3 id="see_id">About this site</h3>
	<div id="sign_up_form">
		<p>The <a href="http://dillgroup.org">Dill research group</a>, at <a href="http://www.stonybrook.edu">Stony Brook University's</a> <a href="http://www.laufercenter.org">Laufer Center</a>, has recently begun a computational study of eukaryotic protein-protein interaction (PPI) network evolution.  We published our basic model layout in <i>PLoS ONE</i>, in 2012:</p>
		<p>J. Peterson, S. Presse, K. Peterson, and K. Dill. <a href="http://www.plosone.org/article/info%3Adoi%2F10.1371%2Fjournal.pone.0039052">Simulated evolution of protein-protein interaction networks with realistic topology</a>. <i>PLoS ONE</i> 7(6): e39052, 2012.</p>
		<p>The Matlab scripts we used are available on <a href="https://github.com/tensorjack/DUNE">GitHub</a>.  (In addition, you will need to install the <a href="http://www.mathworks.com/matlabcentral/fileexchange/10922">MatlabBGL package</a> and the <a href="https://sites.google.com/a/brain-connectivity-toolbox.net/bct/Home/functions/modularity_louvain_und.m?attredirects=0">Louvain modularity script</a>.)  In our model, protein networks evolve by two known biological mechanisms: (1) a gene can duplicate, putting one copy under new selective pressures that allow it to establish new relationships to other proteins in the cell, and (2) a protein undergoes a mutation that causes it to develop new binding or new functional relationships with existing proteins. In addition, we allow for the possibility that once a mutated protein develops a new relationship with another protein (called the target), the mutant protein can also more readily establish relationships with other proteins in the target’s neighborhood.</p>
	</div>
</div>
<!--- end lightbox --->

</body>
</html>
