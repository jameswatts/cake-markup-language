<?php
switch ($state) {
	case self::TAG_OPEN:
		echo $this->_compile('$out = $this->%s->postButton(%s, %s, %s); echo str_replace(array(\'</button>\', \'</form>\'), \'\', $out);', $this->_helpers['Form'], $this->_processAttribute($attributes, 'value'), $this->_processAttribute($attributes, 'url'), $this->_processAttribute($attributes, 'options', array('default' => 'array()', 'format' => null)));
		break;
	case self::TAG_SELF:
		echo $this->_compile('$out = $this->%s->postButton(%s, %s, %s); $set = %s; if (!empty($set)) { $this->viewVars[$set] = $out; } else { echo $out; }', $this->_helpers['Form'], $this->_processAttribute($attributes, 'value'), $this->_processAttribute($attributes, 'url'), $this->_processAttribute($attributes, 'options', array('default' => 'array()', 'format' => null)), $this->_processAttribute($attributes, 'set'));
		break;
	case self::TAG_CLOSE:
		echo '</button></form>';
}

