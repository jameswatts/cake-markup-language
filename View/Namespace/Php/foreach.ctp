<?php
switch ($state) {
	case self::TAG_OPEN:
		$var = uniqid();
		$key = uniqid();
		$value = uniqid();
		echo $this->compile('$_%s = $this->value(%s); $_%s = (empty($_%s))? array() : $_%s; $default = %s; if (!count($_%s)) { echo $default; } $this->set(\'COUNT\', 0); foreach ($_%s as $_%s => $_%s): $this->viewVars[\'COUNT\']++; $this->set(%s, $_%s); $this->set(%s, $_%s);', $var, $this->resolve($attrs, 'var'), $var, $var, $var, $this->resolve($attrs, 'default'), $var, $var, $key, $value, $this->resolve($attrs, 'key', array('default' => 'KEY')), $key, $this->resolve($attrs, 'value', array('default' => 'VALUE')), $value);
		break;
	case self::TAG_CLOSE:
		echo $this->compile('endforeach;');
}

