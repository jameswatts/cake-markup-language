<?php
switch ($state) {
	case self::TAG_OPEN:
	case self::TAG_SELF:
		echo $this->compile('$value = %s; $out = $this->%s->charset((empty($value))? null : $value); if (!empty($value)) { $this->response->charset($value); } $set = %s; if (!empty($set)) { $this->set($set, $out); } else { echo $out; }', $this->resolve($attrs, 'value'), $this->{$ns}->settings['classes']['Html'], $this->resolve($attrs, 'set'));
}

