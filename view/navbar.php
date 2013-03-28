<?php
function create_navbar() {
	echo '
	<div id="topbar">
		<div id="nav">
			<nav>
			<div class="tabs_table">
				<table>
				<tr>
					<td>
					<a id="try-1" class="try" href="#">about</a>								
					</td>
					<div id="how">
					<td>
					<a id="how-trigger" href="#">reference</a>
					<div id="how-content">
						<small>
						G.J. Peterson, S. Press<span style="font-family:Times New Roman,serif;font-size:11pt">é</span>, K.S. Peterson, and K.A. Dill. <a href="http://www.plosone.org/article/info%3Adoi%2F10.1371%2Fjournal.pone.0039052">Simulated evolution of protein-protein interaction networks with realistic topology</a>. <i>PLoS ONE</i> 7(6): e39052, 2012.
						</small>
					</div>
					</td>
					<td>
					<a href="https://github.com/tensorjack/DUNE">downloads</a>
					</td>
					</div>
				</tr>
				</table>
			</div>
			</nav>
		</div>
	<nav>
		<div class="tabs_table">
			<div class="tabs">
			<table>
				<tr>
				<td><a href="http://dillgroup.org">dillgroup</a></td>
				</tr>
			</table>
			</div>
		</div>
	</nav>
	</div>
	';
}
