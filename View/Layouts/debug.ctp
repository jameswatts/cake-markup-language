<?php
/**
 *
 * PHP 5
 *
 * Cake Markup Language (http://github.com/jameswatts/cake-markup-language)
 * Copyright 2012, James Watts (http://github.com/jameswatts)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2012, James Watts (http://github.com/jameswatts)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cml.View.Layouts
 * @since         CakePHP(tm) v 2.1.0.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

$cakeDescription = __d('Cml', 'Cake Markup Language');
$title_for_layout = __d('Cml', 'Debug');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $cakeDescription; ?>:
		<?php echo $title_for_layout; ?>
	</title>
	<?php
		echo $this->Html->meta('icon');
		echo $this->Html->css('cake.generic');
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
	<style type="text/css">
		.cake-debug-output SPAN {
			display: none !important;
		}
		.cake-debug {
			padding-left: 0 !important;
			background: transparent !important;
			border: 0 none !important;
		}
		.cake-debug SPAN.cake-debug-line {
			display: inline !important;
		}
		.cake-debug SPAN.cake-debug-line:hover {
			background: #F9F9F9;
		}
		.cake-debug A.cake-debug-number {
			display: inline;
			padding: 2px;
			background: #EEE;
			text-decoration: none;
			color: #999;
		}
		.cake-debug A.cake-debug-number:hover, .cake-debug A.cake-debug-number:focus {
			background: #DDD;
			color: #666;
		}
	</style>
</head>
<body>
	<div id="container">
		<div id="header">
			<h1><?php echo $this->Html->link($cakeDescription, 'http://github.com/jameswatts/cake-markup-language'); ?></h1>
		</div>
		<div id="content">
			<p class="notice"><?php echo __d('Cml', '<b>Notice:</b> The following is the compiled view code, generated after parsing the markup in file: ' . $this->_parsed); ?></p>
			<?php echo $this->fetch('content'); ?>
		</div>
		<div id="footer">
			<?php echo $this->Html->link(
					$this->Html->image('cake.power.gif', array('alt' => $cakeDescription, 'border' => '0')),
					'http://www.cakephp.org/',
					array('target' => '_blank', 'escape' => false)
				);
			?>
		</div>
	</div>
	<script type="text/javascript">
		ACTIVE_LINE = null;
		function updateLine() {
			var error = (typeof ERROR_LINE !== 'undefined');
			if (window.location.hash || error) {
				var line = document.getElementById((error)? ERROR_LINE : window.location.hash.substring(1));
				if (line) {
					if (ACTIVE_LINE) {
						ACTIVE_LINE.style.backgroundColor = 'transparent';
						ACTIVE_LINE.style.color = '#333';
						ACTIVE_LINE.getElementsByTagName('a')[0].style.color = '#999';
					}
					line.style.backgroundColor = '#FDFFBF';
					line.style.color = '#000';
					line.getElementsByTagName('a')[0].style.color = '#333';
					ACTIVE_LINE = line;
				}
			}
		}
		updateLine();
		setInterval(updateLine, 500)
	</script>
</body>
</html>
