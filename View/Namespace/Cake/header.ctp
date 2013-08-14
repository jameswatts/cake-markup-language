<?php
switch ($state) {
	case self::TAG_OPEN:
	case self::TAG_SELF:
		echo $this->_compile('$header = $this->request->header(%s); $set = %s; if (!empty($set)) { $this->viewVars[$set] = $header; } else { echo $header; }', $this->_processAttribute($attributes, 'name'), $this->_processAttribute($attributes, 'set'));
}

