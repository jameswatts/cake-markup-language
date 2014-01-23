<?php
switch ($state) {
	case self::TAG_OPEN:
		echo $this->compile('$out = $this->%s->postLink(%s, %s, %s, %s); echo substr($out, 0, -4);', $this->{$ns}->settings['classes']['Form'], $this->resolve($attrs, 'value'), $this->resolve($attrs, 'url'), $this->resolve($attrs, 'options', array('type' => self::TYPE_ARRAY)), $this->resolve($attrs, 'confirm'));
		break;
	case self::TAG_SELF:
		echo $this->compile('$out = $this->%s->postLink(%s, %s, %s, %s); $set = %s; if (!empty($set)) { $this->set($set, $out); } else { echo $out; }', $this->{$ns}->settings['classes']['Form'], $this->resolve($attrs, 'value'), $this->resolve($attrs, 'url'), $this->resolve($attrs, 'options', array('type' => self::TYPE_ARRAY)), $this->resolve($attrs, 'confirm'), $this->resolve($attrs, 'set'));
		break;
	case self::TAG_CLOSE:
		echo '</a>';
}

