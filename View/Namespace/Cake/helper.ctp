<?php
switch ($state) {
	case self::TAG_OPEN:
	case self::TAG_SELF:
		echo $this->compile('$name = %s; $var = %s; $get = %s; $call = %s; $args = %s; $object = (!empty($var))? $this->get($var) : $this->$name; $out = (!empty($get))? $object->$get : call_user_func_array(array($object, $call), $args); $set = %s; if (!empty($set)) { $this->set($set, $out); } else { echo $out; }', $this->resolve($attrs, 'name'), $this->resolve($attrs, 'var'), $this->resolve($attrs, 'get'), $this->resolve($attrs, 'call'), $this->resolve($attrs, 'args', array('type' => self::TYPE_ARRAY)), $this->resolve($attrs, 'set'));
}

