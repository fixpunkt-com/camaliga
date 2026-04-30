<?php

namespace Quizpalme\Camaliga\Utility;

use Quizpalme\Camaliga\Domain\Model\Content;
use TYPO3\CMS\Core\MetaTag\MetaTagManagerRegistry;
use Quizpalme\Camaliga\PageTitle\PageTitleProvider;
use TYPO3\CMS\Core\Resource\FileRepository;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * General helpers for the FE
 *
 * @package camaliga
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class HelpersUtility
{

    /**
     * Zufälliges sortieren der Ergebnisse
     *
     * @return array
     */
    public function sortObjects($objects)
    {
        /**
         * zuerst holen wir uns alle gewünschten Objekte, welche später in Fuid in zufälliger Reihenfolge ausgegeben werden sollen
         * und erstellen ein zusätzelichen Array, in welches mittels array_push() die UIDs der Objekte   geschrieben werden
         */
        $uidArray = [];
        foreach($objects as $object) {
            array_push($uidArray, $object->getUid());
        }
        /**
         * shuffle verwürfelt den Inhalt das UID Arrays
         * außerdem erstellen wir ein neues Array, welches später von der Funktion zurückgegeben wird
         */
        shuffle($uidArray);
        $objectArray = [];
        /**
         * für jeden Eintrag im UID Array gehen wir durch die vorhandenen Objekte
         * und wenn die aktuelle uid im Array = der Uid des aktuellen Objektes ist,
         * wird das Objekt in das $objectArray geschrieben und zurückgegeben
         */
        foreach ($uidArray as $uid) {
            foreach($objects as $object) {
                if($uid == $object->getUid()) {
                    array_push($objectArray, $object);
                }
            }
        }
        return $objectArray;
    }

    /**
     * set SEO head?
     *
     * @return void
     */
    public function setSeo(Content $content, array $settings): void
    {
        $title = $content->getTitle();
        $desc = preg_replace("/[\n\r]/"," - ", $content->getShortdesc());
        $MetaTagManagerRegistry = GeneralUtility::makeInstance(MetaTagManagerRegistry::class);
        if ($settings['seo']['setTitle'] == 1) {
            //$GLOBALS['TSFE']->page['title'] = $title;
            $titleProvider = GeneralUtility::makeInstance(PageTitleProvider::class);
            $titleProvider->setTitle($title);
        }
        if (($settings['seo']['setDescription'] == 1) && $desc) {
            //$GLOBALS['TSFE']->page['description'] = $desc;
            $metaTagManager = $MetaTagManagerRegistry->getManagerForProperty('description');
            $metaTagManager->addProperty('description', $desc);
        }
        if ($settings['seo']['setIndexedDocTitle'] == 1) {
            // TODO: ersetzen, da ab TYPO3 12 internal
            //$GLOBALS['TSFE']->indexedDocTitle = $title;
        }
        if ($settings['seo']['setOgTitle'] == 1) {
            //$this->response->addAdditionalHeaderData('<meta property="og:title" content="' . $title .'">');
            $metaTagManager = $MetaTagManagerRegistry->getManagerForProperty('og:title');
            $metaTagManager->addProperty('og:title', $title);
        }
        if (($settings['seo']['setOgDescription'] == 1) && $desc) {
            //$this->response->addAdditionalHeaderData('<meta property="og:description" content="' . $desc . '">');
            $metaTagManager = $MetaTagManagerRegistry->getManagerForProperty('og:description');
            $metaTagManager->addProperty('og:description', $desc);
        }
        if ($settings['seo']['setOgImage'] == 1) {
            $server = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']) ? 'https://' : 'http://';
            $server .= $_SERVER['SERVER_NAME'];
            $image = '';
            if ($content->getFalimage() && $content->getFalimage()->getUid()) {
                $typo3FALRepository = GeneralUtility::makeInstance(FileRepository::class);
                $fileObject = $typo3FALRepository->findByRelation(
                    'tx_camaliga_domain_model_content',
                    'falimage',
                    $content->getUid()
                );
                if (is_array($fileObject) && is_object($fileObject[0])) {
                    $fileObjectData = $fileObject[0]->toArray();
                    $imgUrl = $fileObjectData['url'];
                    if (substr($imgUrl, 0, 1) == '/') {
                        $imgUrl = substr($imgUrl, 1);
                    }
                    $image = $server . '/' . $imgUrl;
                }
            }
            if ($image) {
                $metaTagManager = $MetaTagManagerRegistry->getManagerForProperty('og:image');
                $metaTagManager->addProperty('og:image', $image);
                //$metaTagManager->addProperty('og:image:width', $fileObjectData['width']);
                //$metaTagManager->addProperty('og:image:height', $fileObjectData['height']);
            }
        }
    }

    /**
     * Latitude und Longitude von einer Adresse ermitteln
     * Lösung von hier: http://stackoverflow.com/questions/8633574/get-latitude-and-longitude-automatically-using-php-api
     *
     * @return array
     */
    public function getLatLonOfAddress($street, $zip, $city, $country, $getLatLon, $key) {
        $result = [];
        $result['latitude']  = 0;
        $result['longitude'] = 0;
        $result['debug']     = '';
        $address = $street;
        if ($zip) {
            $address .= ($address) ? ', ' . $zip : $zip;
        }
        if ($city) {
            $address .= ($address) ? ', ' . $city : $city;
        }
        if ($country) {
            $address .= ($address) ? ', ' . $country : $country;
        }
        $address = urlencode((string) $address);
        $httpOptions = [
            "http" => [
                "method" => "GET",
                "header" => "User-Agent: TYPO3"
            ]
        ];
        $streamContext = stream_context_create($httpOptions);
        if ($getLatLon == 2) {
            $url = 'https://nominatim.openstreetmap.org/search?format=json&limit=1&q=' . $address;
        } else {
            $url = 'https://maps.googleapis.com/maps/api/geocode/json?address=' . $address . '&key=' . $key;
        }
        // get the json response
        $resp_json = file_get_contents($url, false, $streamContext);
        // decode the json
        $resp = json_decode($resp_json, true);
        // response status will be 'OK', if able to geocode given address
        if ($getLatLon == 2) {
            if ($resp[0]['lat'] || $resp[0]['lon']) {
                $result['latitude'] = $resp[0]['lat'];
                $result['longitude'] = $resp[0]['lon'];
            } else {
                $result['debug'] = 'no coordinates found at openstreetmap of address "' . $address . '". ' . "\n";
            }
        } else {
            if ($resp['status']=='OK'){
                // get the important data
                $result['latitude'] = $resp['results'][0]['geometry']['location']['lat'] ?? "";
                $result['longitude'] = $resp['results'][0]['geometry']['location']['lng'] ?? "";
                //$formatted_address = isset($resp['results'][0]['formatted_address']) ? $resp['results'][0]['formatted_address'] : "";
            } else {
                $result['debug'] = 'google geocode response to address "' . $address . '": ' . $resp['status'] . "\n";
            }
        }
        return $result;
    }

    /**
     * Latitude und Longitude von einem Bild ermitteln
     * Lösung von hier: https://stackoverflow.com/questions/5449282/reading-geotag-data-from-image-in-php
     *
     * @return array
     */
    public function getLatLonOfImage($fileName)
    {
        //get the EXIF all metadata from Images
        $result = [];
        $gps = [];
        $exif = exif_read_data($fileName);
        if(isset($exif["GPSLatitudeRef"])) {
            $LatM = 1;
            $LongM = 1;
            if($exif["GPSLatitudeRef"] == 'S') {
                $LatM = -1;
            }
            if($exif["GPSLongitudeRef"] == 'W') {
                $LongM = -1;
            }

            //get the GPS data
            $gps['LatDegree']=$exif["GPSLatitude"][0];
            $gps['LatMinute']=$exif["GPSLatitude"][1];
            $gps['LatgSeconds']=$exif["GPSLatitude"][2];
            $gps['LongDegree']=$exif["GPSLongitude"][0];
            $gps['LongMinute']=$exif["GPSLongitude"][1];
            $gps['LongSeconds']=$exif["GPSLongitude"][2];

            //convert strings to numbers
            foreach($gps as $key => $value){
                $pos = strpos((string) $value, '/');
                if($pos !== false){
                    $temp = explode('/',(string) $value);
                    $gps[$key] = $temp[0] / $temp[1];
                }
            }

            //calculate the decimal degree
            $result['latitude']  = $LatM * ($gps['LatDegree'] + ($gps['LatMinute'] / 60) + ($gps['LatgSeconds'] / 3600));
            $result['longitude'] = $LongM * ($gps['LongDegree'] + ($gps['LongMinute'] / 60) + ($gps['LongSeconds'] / 3600));
            $result['datetime']  = $exif["DateTime"];
        }
        return $result;
    }

    /**
     * Calculate widths and heights
     *
     * @return array
     */
    public function calculateWidthAndHeight(array $settings)
    {
        $values = [];
        $item_width = intval($settings['item']['width']);
        $padding_item_width = $item_width + 2 * intval($settings['item']['padding']);
        $total_item_width = $padding_item_width + 2 * intval($settings['item']['margin']);
        $total_width = intval($settings['item']['items']) * $total_item_width;
        $values['paddingItemWidth'] = $padding_item_width;
        $values['totalItemWidth'] = $total_item_width;
        $values['itemWidth'] = (($settings['addPadding']) ? $padding_item_width : $item_width);
        $values['totalWidth'] = $total_width;
        $item_height = intval($settings['item']['height']);
        $padding_item_height = $item_height + 2 * intval($settings['item']['padding']);
        $total_item_height = $padding_item_height + 2 * intval($settings['item']['margin']);
        $values['paddingItemHeight'] = $padding_item_height;
        $values['totalItemHeight'] = $total_item_height;
        $values['itemHeight'] = (($settings['addPadding']) ? $padding_item_height : $item_height);
        return $values;
    }
}
