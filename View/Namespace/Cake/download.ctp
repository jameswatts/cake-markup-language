<?php
switch ($state) {
	case self::TAG_OPEN:
	case self::TAG_SELF:
		echo $this->compile('$this->response->download(%s);', $this->resolve($attrs, 'filename'));
}

