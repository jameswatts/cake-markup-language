<?php
switch ($state) {
	case self::TAG_OPEN:
	case self::TAG_SELF:
		echo $this->_compile('$options = %s; ob_start(); $return = $this->requestAction(%s, $options); $output = ob_get_clean(); $set = %s; if (!empty($set)) { $this->viewVars[$set] = (in_array(\'return\', $options))? $return : $output; } else { echo $output; }', $this->_processAttribute($attributes, 'options', array('format' => null, 'default' => 'array()')), $this->_processAttribute($attributes, 'url', array('default' => '/')), $this->_processAttribute($attributes, 'set'));
}

