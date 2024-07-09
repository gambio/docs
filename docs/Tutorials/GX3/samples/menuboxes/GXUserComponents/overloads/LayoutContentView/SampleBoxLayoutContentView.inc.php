<?php

/* --------------------------------------------------------------
   SampleBoxLayoutContentView.inc.php 2016-08-01 gm
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2016 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   -------------------------------------------------------------- 
*/

class SampleBoxLayoutContentView extends SampleBoxLayoutContentView_parent
{
	public function prepare_data()
	{
		parent::prepare_data();
		
		if($GLOBALS['coo_template_control']->get_menubox_status('sample_box'))
		{
			$sampleBox = MainFactory::create_object('SampleBoxContentView');
			$boxHtml = $sampleBox->get_html();
			
			$boxPos = $GLOBALS['coo_template_control']->get_menubox_position('sample_box');
			$this->set_content_data($boxPos, $boxHtml);
		}
	}
}