<?php
switch ($state) {
	case self::TAG_OPEN:
		echo $this->compile('$out = $this->%s->label(%s, %s, %s); echo substr($out, 0, -8);', $this->{$ns}->settings['classes']['Form'], $this->resolve($attrs, 'field'), $this->resolve($attrs, 'value'), $this->resolve($attrs, 'options'));
		break;
	case self::TAG_SELF:
		echo $this->compile('$out = $this->%s->label(%s, %s, %s); $set = %s; if (!empty($set)) { $this->set($set, $out); } else { echo $out; }', $this->{$ns}->settings['classes']['Form'], $this->resolve($attrs, 'field'), $this->resolve($attrs, 'value'), $this->resolve($attrs, 'options'), $this->resolve($attrs, 'set'));
		break;
	case self::TAG_CLOSE:
		echo '</label>';
}

