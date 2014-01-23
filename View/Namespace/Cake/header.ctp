<?php
switch ($state) {
	case self::TAG_OPEN:
	case self::TAG_SELF:
		echo $this->compile('$header = $this->request->header(%s); $set = %s; if (!empty($set)) { $this->set($set, $header); } else { echo $header; }', $this->resolve($attrs, 'name'), $this->resolve($attrs, 'set'));
}

