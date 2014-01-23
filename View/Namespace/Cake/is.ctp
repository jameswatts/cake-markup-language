<?php
switch ($state) {
	case self::TAG_OPEN:
		echo $this->compile('if ($this->request->is(%s)):', $this->resolve($attrs, 'type'));
		break;
	case self::TAG_SELF:
		echo $this->compile('if ($this->request->is(%s)) { echo %s; }', $this->resolve($attrs, 'type'), $this->resolve($attrs, 'value'));
		break;
	case self::TAG_CLOSE:
		echo $this->compile('endif;');
		break;
}

