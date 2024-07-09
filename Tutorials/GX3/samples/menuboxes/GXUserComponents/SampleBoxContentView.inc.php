<?php

/* --------------------------------------------------------------
   SampleBoxContentView.inc.php 2016-08-01 gm
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2016 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   -------------------------------------------------------------- 
*/

class SampleBoxContentView extends ContentView
{
	public function __construct()
	{
		parent::__construct();
		$this->set_content_template('boxes/sample_box.html');
	}
	
	
	public function prepare_data()
	{
		$this->content_array['BOX_ID'] = 'sample_box_1';
	}
}