<?php
switch ($state) {
	case self::TAG_OPEN:
	case self::TAG_SELF:
		$value = $this->_processAttribute($attributes, 'value', array('format' => null));
		if (is_null($value)) {
			$value = (isset($attributes['default']))? $this->_processAttribute($attributes, 'default', array('format' => null)) : '';
		}
		$safe = $this->_processAttribute($attributes, 'safe', array('default' => 'true', 'format' => null));
		echo $this->_compile('ob_start();');
		echo $value;
		echo $this->_compile('$out = ob_get_clean();');
		if ($this->_processAttribute($attributes, 'nl2br', array('default' => 'false', 'format' => null))) {
			echo $this->_compile(($safe)? 'echo nl2br(h(html_entity_decode($out)));' : 'echo nl2br($out);');
		} else {
			echo $this->_compile(($safe)? 'echo h(html_entity_decode($out));' : 'echo $out;');
		}
}

