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
					<a id="try-1" class="try" href="#" onclick="return false;">about</a>								
					</td>
					<div id="how">
					<td>
					<a id="how-trigger" href="#" onclick="return false;">reference</a>
					<div id="how-content">
						<small>
						J. Peterson, S. Presse, K. Peterson, and K. Dill. <a href="http://www.plosone.org/article/info%3Adoi%2F10.1371%2Fjournal.pone.0039052">Simulated evolution of protein-protein interaction networks with realistic topology</a>. <i>PLoS ONE</i> 7(6): e39052, 2012.
						</small>
					</div>
					</td>
					<td>
					<a href="https://github.com/tensorjack/ppi">source</a>
					</td>
					<td>
					<a href="https://github.com/tensorjack/DUNE">simulation</a>
					</td>
					<td>
					<a href="#" onclick="$(\'#intro\').toggle(); $(\'#summary\').toggle(); return false;">help</a>
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
					<!---<div id="login">
						<tr>
						<td>
							<a id="login-trigger" href="#">search</a>
							<div id="login-content">
								<form action="index.php" method="post" class="form">
									<fieldset id="inputs">
										<input id="username" type="username" name="login_username" placeholder="Username" required />
										<input id="password" type="password" name="login_password" placeholder="Password" required />
									</fieldset>
									<fieldset id="actions">
										<input class="button" type="submit" id="submit" value="Search" />
									</fieldset>
								</form>
							</div>
						</td>--->	
						<td><a href="http://dillgroup.org">dillgroup</a></td>
						</tr>
					</div>
				</table>
				</div>
			</div>
		</nav>
	</div>
	';
}