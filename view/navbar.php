<?php
function create_navbar() {
	echo '
	<div id="topbar">
		<div id="nav">
			<nav>
			<div class="tabs_table">
				<div id="title_label">
					<table>
						<tr>
						<th><img src="images/interactome.png" alt="interactome" /></th>
						</tr>
					</table>
				</div>
			</div>
			</nav>
		</div>
		<!---<nav>
		<div id="title_label">
			<table>
				<tr><td>
				<img src="images/interactome.png" alt="interactome" />
				</td></tr>
			</table>
		</div>
		</nav>--->
		<nav>
			<div class="tabs_table">
				<div class="tabs">
					<table>
						<tr>
						<div id="how">
						<td>
						<a href="#" onclick="$(\'#intro\').lightbox_me({centered: true});/*$(\'#intro\').toggle(); $(\'#summary\').toggle();*/ return false;">help</a>
						</td>						
						<!---<td>
						<a id="how-trigger" href="#" onclick="return false;">reference</a>
						<div id="how-content">
							<small>
							J. Peterson, S. Presse, K. Peterson, and K. Dill. <a href="http://www.plosone.org/article/info%3Adoi%2F10.1371%2Fjournal.pone.0039052">Simulated evolution of protein-protein interaction networks with realistic topology</a>. <i>PLoS ONE</i> 7(6): e39052, 2012.
							</small>
						</div>
						</td>--->
						<td>
						<a href="https://github.com/tensorjack/ppi">source</a>
						</td>
						<td>
						<a href="https://github.com/tensorjack/DUNE">simulation</a>
						</td>
						<td><a href="http://dillgroup.org">dillgroup</a></td>
						<td>
						<a id="try-1" class="try" href="#" onclick="return false;">about</a>								
						</td>
						</div>
						</tr>
					</table>
				</div>
			</div>
		</nav>
	</div>
	';
}