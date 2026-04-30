<?php
namespace Quizpalme\Camaliga\ViewHelpers;

use Quizpalme\Camaliga\Domain\Repository\ContentRepository;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper;

/**
 * Content-ViewHelper
 * {namespace cam=Quizpalme\Camaliga\ViewHelpers}
 * <cam:content param="nicecontent"></cam:content>
 * A ViewHelper for the camaliga-content
 *
 * @package camaliga
 */
class ContentViewHelper extends AbstractTagBasedViewHelper
{
	/**
	 * As this ViewHelper renders HTML, the output must not be escaped.
	 *
	 * @var bool
	 */
	protected $escapeOutput = false;
	
	/**
  * contentRepository
  *
  * @var ContentRepository
  */
 protected $contentRepository = NULL;
	
	/**
      * Constructor
      */
     public function __construct(\Quizpalme\Camaliga\Domain\Repository\ContentRepository $contentRepository)
     {
         parent::__construct();
         $this->contentRepository = $contentRepository;
     }

	/**
	 * Content-ViewHelper
	 *
	 * @return string $result
	 */
	public function render(): string
	{
	    if (isset($_GET['tx_camaliga_show']))
	        $camaligaArray = $_GET['tx_camaliga_show'];
	    else if (isset($_POST['tx_camaliga_show']))
	    	$camaligaArray = $_POST['tx_camaliga_show'];
	    else if (isset($_GET['tx_camaliga_showextended']))
            $camaligaArray = $_GET['tx_camaliga_showextended'];
        else if (isset($_POST['tx_camaliga_showextended']))
            $camaligaArray = $_POST['tx_camaliga_showextended'];
        else
	    	$camaligaArray = [];
        if (isset($camaligaArray['content']))
	        $uid = intval($camaligaArray['content']);
        else
            $uid = 0;
	    //$lang = intval($_GET['L']);
        $row = [];
        if ($uid > 0) {
            $entry = $this->contentRepository->findOneByUid2($uid);
            if ($entry && $entry->getUid()) {
            	$row['camaliga_title'] = $entry->getTitle();
                $row['camaliga_shortdesc'] = $entry->getShortdesc();
                $row['camaliga_link'] = $entry->getLink();
                $row['camaliga_image'] = $entry->getFalimage();
                $row['camaliga_street'] = $entry->getStreet();
                $row['camaliga_zip'] = $entry->getZip();
                $row['camaliga_city'] = $entry->getCity();
                $row['camaliga_country'] = $entry->getCountry();
                $row['camaliga_person'] = $entry->getPerson();
                $row['camaliga_phone'] = $entry->getPhone();
                $row['camaliga_mobile'] = $entry->getMobile();
                $row['camaliga_email'] = $entry->getEmail();
                $row['camaliga_latitude'] = $entry->getLatitude();
                $row['camaliga_longitude'] = $entry->getLongitude();
                $row['camaliga_custom1'] = $entry->getCustom1();
                $row['camaliga_custom2'] = $entry->getCustom2();
                $row['camaliga_custom3'] = $entry->getCustom3();
			}
		}
		return str_replace(
			array_keys($row),
			array_values($row),
			(string) $this->additionalArguments['param']
		);
	}
}