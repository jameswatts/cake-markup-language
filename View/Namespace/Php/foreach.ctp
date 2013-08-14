<?php
switch ($state) {
	case self::TAG_OPEN:
		$var = uniqid();
		$key = uniqid();
		$value = uniqid();
		echo $this->_compile('$_%s = $this->_processValue(%s); $_%s = (empty($_%s))? array() : $_%s; $default = %s; if (!count($_%s)) { echo $default; } $this->viewVars[\'COUNT\'] = 0; foreach ($_%s as $_%s => $_%s): $this->viewVars[\'COUNT\']++; $this->viewVars[%s] = $_%s; $this->viewVars[%s] = $_%s;', $var, $this->_processAttribute($attributes, 'var'), $var, $var, $var, $this->_processAttribute($attributes, 'default'), $var, $var, $key, $value, $this->_processAttribute($attributes, 'key', array('default' => 'KEY')), $key, $this->_processAttribute($attributes, 'value', array('default' => 'VALUE')), $value);
		break;
	case self::TAG_CLOSE:
		echo $this->_compile('endforeach;');
}

