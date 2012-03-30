<?php

namespace MARSFW\Auth;
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UserAuth
 *
 * @author vanduir
 */
abstract class UserAuth {
	abstract function __construct(array $params);
	abstract function getUser();
}

