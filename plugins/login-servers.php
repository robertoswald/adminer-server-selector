<?php
/** Display constant list of servers in login form
* @link http://www.adminer.org/plugins/#use
* @author Jakub Vrana, http://www.vrana.cz/
* @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU General Public License, version 2 (one or other)
*/
class AdminerLoginServers {
	/** @access protected */
	var $servers, $driver;
	
	/** Set supported servers
	* @param array array($domain) or array($domain => $description) or array($category => array())
	* @param string
	*/
	function AdminerLoginServers($servers, $driver = "server") {
		$this->servers = $servers;
		$this->driver = $driver;
	}
	
	function login($login, $password) {
		return true;
	}
	
	function loginForm() {
		?>
<script src="https://code.jquery.com/jquery-1.11.2.min.js"></script>
<script>
	var servers = JSON.parse('<?php echo json_encode($this->servers); ?>');
	$(function() {
		$('select').on('change', function() {
			var server = $('option:selected', this).data('server');
			console.log('change', server);
			$('#username').val(server.username);
			$('#password').val(server.password);
			$('#db').val(server.database);
		});
		$('select').change();
	});
</script>
<table cellspacing="0">
<tr><th><?php echo lang('Server'); ?><td><input type="hidden" name="auth[driver]" value="<?php echo $this->driver; ?>">
<select name="auth[server]">
	<?php
		foreach ($this->servers as $server) {
			echo '<option value="' . $server->host. '" data-server="' . htmlentities(json_encode($server)). '">' . $server->name . '</option>' . "\n";
		}
	?>
</select>
<tr><th><?php echo lang('Username'); ?><td><input id="username" name="auth[username]">
<tr><th><?php echo lang('Password'); ?><td><input id="password" type="password" name="auth[password]">
<tr><th><?php echo lang('Database'); ?><td><input id="db" type="text" name="auth[db]">
</table>
<p><input type="submit" value="<?php echo lang('Login'); ?>">
<?php
		echo checkbox("auth[permanent]", 1, $_COOKIE["adminer_permanent"], lang('Permanent login')) . "\n";
		return true;
	}
	
}

