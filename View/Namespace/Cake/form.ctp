<?php
switch ($state) {
	case self::TAG_OPEN:
		echo $this->compile('echo $this->%s->create(%s, %s); $formEnd = %s;', $this->{$ns}->settings['classes']['Form'], $this->resolve($attrs, 'model'), $this->resolve($attrs, 'options', array('type' => self::TYPE_ARRAY)), $this->resolve($attrs, 'submit'));
		break;
	case self::TAG_CLOSE:
		echo $this->compile('echo $this->%s->end((!empty($formEnd))? $formEnd : null);', $this->{$ns}->settings['classes']['Form']);
}

