<?php
switch ($state) {
	case self::TAG_OPEN:
	case self::TAG_SELF:
		echo $this->compile('$out = $this->%s->dateTime(%s, %s, %s, %s); $set = %s; if (!empty($set)) { $this->set($set, $out); } else { echo $out; }', $this->{$ns}->settings['classes']['Form'], $this->resolve($attrs, 'field'), $this->resolve($attrs, 'date'), $this->resolve($attrs, 'time'), $this->resolve($attrs, 'attributes'), $this->resolve($attrs, 'set'));
}

