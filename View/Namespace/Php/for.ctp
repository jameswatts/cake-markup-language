<?php
switch ($state) {
	case self::TAG_OPEN:
		$var = uniqid();
		$i = uniqid();
		echo $this->compile('$_%s = $this->value(%s); $_%s = (empty($_%s))? array() : $_%s; $default = %s; if (!count($_%s)) { echo $default; } $this->set(\'COUNT\', 0); for ($_%s = %s; $_%s < %s; $_%s++): $this->viewVars[\'COUNT\']++; $this->set(%s, $_%s); $this->set(%s, (is_array($_%s) && array_key_exists($_%s, $_%s))? $_%s[$_%s] : $_%s);', $var, $this->resolve($attrs, 'var'), $var, $var, $var, $this->resolve($attrs, 'default'), $var, $i, $this->resolve($attrs, 'start', array('default' => '0', 'format' => null)), $i, $this->resolve($attrs, 'end', array('default' => 'count($_' . $var . ')', 'format' => null)), $i, $this->resolve($attrs, 'index', array('default' => 'INDEX')), $i, $this->resolve($attrs, 'value', array('default' => 'VALUE')), $var, $i, $var, $var, $i, $i);
		break;
	case self::TAG_CLOSE:
		echo $this->compile('endfor;');
}

