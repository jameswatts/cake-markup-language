<?php
switch ($state) {
	case self::TAG_OPEN:
	case self::TAG_SELF:
		echo $this->compile('$out = Configure::check(%s); $set = %s; if (!empty($set)) { $this->set($set, $out); } else { echo $out; }', $this->resolve($attrs, 'name'), $this->resolve($attrs, 'set'));
}

