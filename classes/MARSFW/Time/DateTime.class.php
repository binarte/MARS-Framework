<?php

namespace MARS\Time;
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

final class DateTime extends DateTimeLocal{

	public function __toString() {
		return $this->format('Y-m-d\TH:i:s.uP');
	}
}