<?php include 'view/navbar.php'; ?>
<!DOCTYPE html>
<html>
<head>
<title>Protein interaction networks</title>
<?php include 'view/headers.php'; ?>
<!---<link href='css/bootstrap.min.css' rel='stylesheet' type='text/css'>--->
<!---<link href='css/bootstrap-responsive.min.css' rel='stylesheet' type='text/css'>--->
<script src="js/jquery.lightbox_me.js"></script>
<script src="js/sigma.min.js"></script>
<script src="js/sigma.parseGexf.js"></script>
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

	// Search query
	$('#finder').submit(function() {
		$.post('index.php?page=network', $(this).serialize(), function(response) {
			$('#links').html(response);
		});
		return false;
	});

});

function init() {
	// Instanciate sigma.js and customize rendering :
	var sigInst = sigma.init(document.getElementById('sigma-example')).drawingProperties({
		defaultLabelColor: '#fff',
		defaultLabelSize: 14,
		defaultLabelBGColor: '#fff',
		defaultLabelHoverColor: '#000',
		labelThreshold: 6,
		defaultEdgeType: 'curve'
	}).graphProperties({
		minNodeSize: 0.5,
		maxNodeSize: 5,
		minEdgeSize: 1,
		maxEdgeSize: 1
	}).mouseProperties({
		maxRatio: 4
	});
 
	// Parse a GEXF encoded file to fill the graph
	// (requires "sigma.parseGexf.js" to be included)
	sigInst.parseGexf('data/yeast.gexf');
	 
	// Bind events :
	var greyColor = '#666';
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
	 
	// Draw the graph :
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
  	<!---<div id="textwall">
	</div>--->
	<div id="rightbar">
		<table>
		<tr><th>Datasets</th></tr>
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
		<tr><th>Tools</th></tr>
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
		</table>
	</div>
	<div class="push"></div>
</div>
<div id="footer">&copy; 2012 - 2013 <a href="http://www.tinybike.net">Jack Peterson</a>.  All rights reserved.</div>

<!--- Sign-up lightbox --->
<div id="sign_up">
	<h3 id="see_id">About this site</h3>
	<div id="sign_up_form">
		<p>This website is a companion to our paper on eukaryotic protein-protein interaction (PPI) network evolution, written by Jack Peterson (me), Steve Press<span style="font-family:Times New Roman,serif;font-size:11pt">é</span>, Kristin Peterson, and Ken Dill.  This site will be a repository for all our PPI-related scripts.  Currently uploaded here are the Matlab scripts we used to simulate the PPI networks described in our paper.</p>
		<br/>
		<p>Our scripts are available on <a href="https://github.com/tensorjack/DUNE">GitHub</a>.&nbsp; In addition, you will need to install the <a href="http://www.mathworks.com/matlabcentral/fileexchange/10922">MatlabBGL package</a> and the <a href="https://sites.google.com/a/brain-connectivity-toolbox.net/bct/Home/functions/modularity_louvain_und.m?attredirects=0">Louvain modularity script</a>.&nbsp; A brief description of our scripts is below.</p>
		<br/>
		<p>ppi.m is an implementation of the DUNE (DUplication &amp; NEofunctionalization) model of eukaryotic PPI network evolution<br>
		ppi_import.m (data import, requires adjacency matrix as input file)<br/>
		pointmutation.m (neofunctionalization/assimilation events)<br/>
		timedepstats.m (updates dynamical properties at specified intervals)<br/>
		trackstats.m (updates degree and betweenness "tracking" values)<br/>
		&nbsp;<br/>
		Also included are several files used to calculate various statistics and plot several static and dynamic quantities obtained from the simulation.&nbsp; These files are <i>not </i>required to run ppi.m.<br/>
		</p>
		<p>std_dyn.m (calculates dynamical statistics)<br/>
		std_stat.m (calculates static end-state statistics)<br/>
		std_tracking.m (calculates degree and betweenness "tracking" statistics)<br/>
		ppi_dyn.m (prepares dynamical quantities for plotting)<br/>
		RT_save_figures_bvk.m (betweenness vs degree)<br/>
		RT_save_figures_nvk.m (nearest-neighbor degree vs degree)<br/>
		RT_save_figures_Cvk.m (clustering coefficients vs degree)<br/>
		RT_save_figures_E2.m (second-largest eigenvalue evolution)<br/>
		RT_save_figures_px.m (closeness distribution)<br/>
		RT_save_figures_plambda.m (walk matrix eigenvalue distribution)<br/>
		RT_save_figures_pb.m (betweenness distribution)<br/>
		RT_save_figures_pk.m (degree distribution)<br/>
		RT_save_figures_gcc.m (global clustering coefficient evolution)<br/>
		RT_save_figures_Q.m (modularity coefficient evolution)<br/>
		RT_save_figures_d.m (diameter evolution)<br/>
		RT_save_figures_f1.m (largest component evolution)<br/>
		&nbsp;<br/>
		</p>
	</div>
</div>
<!--- end lightbox --->

</body>
</html>
