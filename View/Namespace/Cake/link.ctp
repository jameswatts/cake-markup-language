<?php
switch ($state) {
	case self::TAG_OPEN:
		echo $this->_compile('$out = $this->%s->link(%s, %s, %s, %s); echo substr($out, 0, -4);', $this->_helpers['Html'], $this->_processAttribute($attributes, 'value'), $this->_processAttribute($attributes, 'url'), $this->_processAttribute($attributes, 'options', array('default' => 'array()', 'format' => null)), $this->_processAttribute($attributes, 'confirm'));
		break;
	case self::TAG_SELF:
		echo $this->_compile('$out = $this->%s->link(%s, %s, %s, %s); $set = %s; if (!empty($set)) { $this->viewVars[$set] = $out; } else { echo $out; }', $this->_helpers['Html'], $this->_processAttribute($attributes, 'value'), $this->_processAttribute($attributes, 'url'), $this->_processAttribute($attributes, 'options', array('default' => 'array()', 'format' => null)), $this->_processAttribute($attributes, 'confirm'), $this->_processAttribute($attributes, 'set'));
		break;
	case self::TAG_CLOSE:
		echo '</a>';
}

