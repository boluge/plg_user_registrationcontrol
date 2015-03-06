<?php
/**
 * @copyright	Copyright (c) 2015 RegControl. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

jimport('joomla.plugin.plugin');

/**
 * user - RegistrationControl Plugin
 *
 * @package		Joomla.Plugin
 * @subpakage	RegControl.RegistrationControl
 */
class plguserRegistrationControl extends JPlugin {

	/**
	 * onUserBeforeSave.
	 *
	 * @param 	array $previousData
	 * @param	array $isNew
	  * @param	array $futureData
	 */

	function onUserBeforeSave($previousData, $isNew, $futureData){

		$response->type = 'Joomla';

		$type = $this->params->get('type'); // Récupère le type de fonctionnement
		$param = $this->params->get('domains'); // Récupère les domaines définies
		$error = $this->params->get('error'); // Récupère le text de l'error

		$param = preg_replace('/\s+/', '', $param); // Suprime les espaces
		$domains = explode(",", $param); // Décompose en array
		$email = $futureData['email'];

		$result = true;
		$matches = array();

		// Vérifie si l'utilisateur est nouveau si c'est le cas il retourne TRUE
		if (!$isNew || !JFactory::getApplication()->isSite()) {
			return true;
		}

		// Boucle qui vérifie que le mail de l'utilisateur est présent dans les domaines autorisés.
		foreach ($domains as $domain) {
			$pattern = '/@' . $domain . '$/';
			if (preg_match($pattern, $email)) {
				$matches[] = $email;
			};
		}

		if( $type == 1 ){
			if(empty($matches)){ $result = false; } else { $result = true; }
			if ($result != true) {
				JError::raiseWarning( 4711, $error);
				return $result;
			} else {
				return $result;
			}
		} else {
			if(empty($matches)){ $result = true; } else { $result = false; }
			if ($result == true) {
				return $result;
			} else {
				JError::raiseWarning( 4711, $error);
				return $result;
			}
		}
	}
}