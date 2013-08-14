<?php
switch ($state) {
	case self::TAG_OPEN:
		$var = uniqid();
		$i = uniqid();
		echo $this->_compile('$_%s = $this->_processValue(%s); $_%s = (empty($_%s))? array() : $_%s; $default = %s; if (!count($_%s)) { echo $default; } $this->viewVars[\'COUNT\'] = 0; for ($_%s = %s; $_%s < %s; $_%s++): $this->viewVars[\'COUNT\']++; $this->viewVars[%s] = $_%s; $this->viewVars[%s] = $_%s[$_%s];', $var, $this->_processAttribute($attributes, 'var'), $var, $var, $var, $this->_processAttribute($attributes, 'default'), $var, $i, $this->_processAttribute($attributes, 'start', array('default' => '0', 'format' => null)), $i, $this->_processAttribute($attributes, 'end', array('default' => 'count($_' . $var . ')', 'format' => null)), $i, $this->_processAttribute($attributes, 'index', array('default' => 'INDEX')), $i, $this->_processAttribute($attributes, 'value', array('default' => 'VALUE')), $var, $i);
		break;
	case self::TAG_CLOSE:
		echo $this->_compile('endfor;');
}

