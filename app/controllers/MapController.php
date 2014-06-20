<?php
class MapController extends Zend_Controller_Action {
	public function travelAction() {
		$this->view->headMeta()->appendName('keywords', 'Travel, Alex Lukyanov Blog, Sashas, Magento, Magento Extensions, Blog, News, Articles, New York, PHP');
		$this->view->headMeta()->appendName('description', 'Travel around the  world');		
		$this->view->headTitle()->append('Travels map');
		
		$maps = new App_Model_Map ();
		// sashas <script
		// src="http://maps.google.com/maps?file=api&amp;v=2&amp;sensor=true_or_false&amp;key=ABQIAAAA8Jmm8-PU4Xo8UoaLa7zqQhQLmOSNqwulke5-uvzIe8d96rH2ehTeHeOFSfr_4hmUzOQDgvOwgA3KsQ"
		// type="text/javascript"></script>
		// sashas.org <script
		// src="http://maps.google.com/maps?file=api&amp;v=2&amp;sensor=true_or_false&amp;key=ABQIAAAA8Jmm8-PU4Xo8UoaLa7zqQhQv1SoJhM3upLRl_gXJqC7Uz-jmQRR1dUm4vgd5GSyOIPmCIyaG3vmi8Q"
		// type="text/javascript"></script>
		$maps = $maps->getAll ();
		$i = 0;
		$text = '';
		foreach ( $maps as $map ) {
			$i ++;
			$text .= '
				var trip' . $i . ' = [
				new google.maps.LatLng(' . $map ["from_x"] . ',' . $map ["from_y"] . '),
				new google.maps.LatLng(' . $map ["x"] . ',' . $map ["y"] . ')
				];
		
				var path' . $i . ' = new google.maps.Polyline({
				path: trip' . $i . ',
				strokeColor: "#FF0000",
				strokeOpacity: 1.0,
				strokeWeight: 2
			});
			path' . $i . '.setMap(map);
			';		
		}
		
	 
		$this->view->maps=$text;
	}
}

