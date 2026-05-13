<?php
namespace Quizpalme\Camaliga\Domain\Repository;

use TYPO3\CMS\Extbase\Persistence\Repository;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Database\ConnectionPool;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Kurt Gusbeth <info@quizpalme.de>
 *  
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * Content Repository: das Herz der Extension
 *
 * @package camaliga
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class ContentRepository extends Repository
{

	/**
	 * Entferungsarray
	 *
	 * @var \array
	 */
	protected $distanceArray = [];
	
	// Entferungsarray zurück geben
	function getDistanceArray()
	{
		return $this->distanceArray;
	}
	
	// String Escape for DB
	function ms_escape_string($data)
	{
		if ( !isset($data) or empty($data) ) {
			return '';
		}
		if ( is_numeric($data) ) {
			return $data;
		}
	
		$non_displayables = [
				'/%0[0-8bcef]/',            // url encoded 00-08, 11, 12, 14, 15
				'/%1[0-9a-f]/',             // url encoded 16-31
				'/[\x00-\x08]/',            // 00-08
				'/\x0b/',                   // 11
				'/\x0c/',                   // 12
				'/[\x0e-\x1f]/'             // 14-31
		];
		$entf = ['\\', '"', "'", '%', '´', '`'];
		foreach ( $non_displayables as $regex ) {
			$data = preg_replace( $regex, '', (string) $data );
		}
		return str_replace( $entf, '', $data );
	}
	
	/**
	 * findAll ersetzen, wegen Sortierung
	 * @param	string	$sortBy		Sort by
	 * @param	string	$sortOrder	Sort order
	 * @param	boolean	$onlyDistinct	Only distinct entries?
	 * @param	array	$pids		Storage PIDs
	 * @param	integer	$limit		Limit
	 */
	public function findAll($sortBy = 'sorting', $sortOrder = 'asc', $onlyDistinct = FALSE, $pids = [], $limit = 0)
	{
		$order = ($sortOrder == 'desc') ? QueryInterface::ORDER_DESCENDING :
										 QueryInterface::ORDER_ASCENDING;
		if ($sortBy=='sorting' || $sortBy=='tstamp' || $sortBy=='crdate' || $sortBy=='title' || $sortBy=='zip' || $sortBy=='city'
		 || $sortBy=='country' || $sortBy=='custom1' || $sortBy=='custom2' || $sortBy=='custom3') {
		 	// OK
		 } else {
		 	$sortBy = 'sorting';
		 }
		
		$constraints = [];
		$query = $this->createQuery();
		if (!empty($pids)) {
			$query->getQuerySettings()->setRespectStoragePage(FALSE);
			$constraints[] = $query->in('pid', $pids);
		}
		// keine gute Idee: Mutter muss 0 sein, aber nur wenn die Mutter vorhanden ist (die könnte auch in einem anderen Ordner liegen)
		//if ($onlyDistinct) $constraints[] = $query->equals('mother', 0);
		if (!empty($constraints)) {
			$query->matching($query->logicalAnd(...$constraints));
		}
		if ($limit > 0) {
			$query->setLimit(intval($limit));
		}
		//	->setOffset($page * $limit)
		$result = $query
			->setOrderings(	[$sortBy => $order] )
			->execute();
		
		if ($onlyDistinct) {
			// bessere Idee:
			$resUids = [];
			$delKeys = [];
			foreach ($result as $element) {
				$resUids[$element->getUid()] = 1;
			}
			foreach ($result as $key => $element)  {
				if (($element->getMother()) && ($resUids[$element->getMother()->getUid()] == 1)) {
					// Mutter und Kind sind vorhanden => Kind löschen
					$delKeys[] = $key;
				}
			}
			if (count($delKeys) > 0) {
				foreach ($delKeys as $key)  {
					// Mutter und Kind sind vorhanden => Kind löschen
					unset($result[$key]);
				}
			}
		}
		return $result;
	}

	/**
	 * findComplex: umfangreiche Suche
	 * @param	array	$uids		UIDs
	 * @param	string	$sword		Suchwort
	 * @param	string	$place		Ort
	 * @param	integer	$radius		Radius
	 * @param	string	$sortBy		Sort by
	 * @param	string	$sortOrder	Sort order
	 * @param	boolean	$onlyDistinct	Only distinct entries?
	 * @param	array	$pids		Storage PIDs
	 * @param	integer	$limit		Limit
	 */
	public function findComplex($uids, $sword, $place, $radius, $sortBy = 'sorting', $sortOrder = 'asc', $onlyDistinct = FALSE, $pids = [], $limit = 0)
	{
		$order = ($sortOrder == 'desc') ? QueryInterface::ORDER_DESCENDING :
										  QueryInterface::ORDER_ASCENDING;
		if ($sortBy=='sorting' || $sortBy=='tstamp' || $sortBy=='title' || $sortBy=='zip' || $sortBy=='city'
			 || $sortBy=='country' || $sortBy=='custom1' || $sortBy=='custom2' || $sortBy=='custom3') {
		 	// OK
		} else {
		 	$sortBy = 'sorting';
		}
		if ($sword) {
		 	$sword = '%' . $sword . '%';
		}
		if (!empty($uids)) {
			$catSearch = TRUE;
		} else {
			$catSearch = FALSE;
			$uids = [];
		}
		$noMatch = FALSE;
		$this->distanceArray = [];
		
		// Umkreissuche von hier: http://opengeodb.org/wiki/OpenGeoDB_-_Umkreissuche
		if ($place && $radius) {
			// Achtung: die Tabelle geodb_zip_coordinates muss vorhanden und befüllt sein!
			$ort = $this->ms_escape_string($place);
			$radius = intval($radius);
			$zc_id = 0;
			
			// Position des Suchortes finden
			$where = (is_numeric($ort)) ? "zc_zip = '" . $ort . "'" : "zc_location_name LIKE '" . $ort . "%'";
			$statement = 'SELECT zc_id, zc_location_name FROM geodb_zip_coordinates WHERE ' . $where . ' ORDER BY zc_location_name LIMIT 1';
			$query = $this->createQuery();
			$query->getQuerySettings()->setRespectStoragePage(FALSE);
			$query->statement($statement);
			$resultArray = $query->execute(TRUE);
			if (count($resultArray) >= 1) {
				foreach ($resultArray as $row) {
					$zc_id = $row['zc_id'];		// Die erst beste ID nehmen. Nicht immer die beste Wahl!
				}
			}

			// Elemente in der Umgebung des Suchortes finden
			if ($zc_id) {
				$new_uids = [];
				$statement = 'SELECT dest.uid, dest.zip, dest.city,
						ACOS(
					         SIN(RADIANS(src.zc_lat)) * SIN(RADIANS(dest.latitude))
					         + COS(RADIANS(src.zc_lat)) * COS(RADIANS(dest.latitude))
					         * COS(RADIANS(src.zc_lon) - RADIANS(dest.longitude))
					    ) * 6380 AS distance
					FROM tx_camaliga_domain_model_content dest
					CROSS JOIN geodb_zip_coordinates src
					WHERE src.zc_id = ' . $zc_id .'
					HAVING distance < ' . $radius .'
			 		ORDER BY dest.uid';		// . 'ORDER BY distance'); Außerdem fehlt a.x=b.y !
				//echo $statement;
				$query = $this->createQuery();
				$query->getQuerySettings()->setRespectStoragePage(false);
				$query->statement($statement);
				$resultArray = $query->execute(true);
				if (count($resultArray) >= 1) {
					foreach ($resultArray as $row) {
						$uid = intval($row['uid']);
						//echo "\nGefunden: " . $uid . ': ' . $row['zip'] . ' ' . $row['city'];
						if ($catSearch) {
							// Gibt es auch eine Übereinstimmung bei der Kategoriensuche?
							if (isset($uids[$uid]) && $uids[$uid] > 0) {
								$new_uids[$uid] = $uid;
								$this->distanceArray[$uid] = $row['distance'];
                               // echo "\nÜbrig 1: " . $uid . ': ' . $row['zip'] . ' ' . $row['city'];
							} else {
							    //echo "\Fällt weg: " . $uid . ': ' . $row['zip'] . ' ' . $row['city'];
                            }
						} else {
							// Keine Kategoriensuche
							$uids[$uid] = $uid;
							$this->distanceArray[$uid] = $row['distance'];
                            //echo "\nÜbrig 2: " . $uid . ': ' . $row['zip'] . ' ' . $row['city'];
						}
					}
				}
				if ($catSearch)	{
                    // nur die UIDs übernehmen, wo Kategorie-Suche und PLZ/Ort-Suche das selbe gefunden hat!
				    $uids = $new_uids;
                }
			} else {
				// nix gefunden
				$uids = [];
			}
			if (count($uids) == 0) {
                // keine Treffer bei der Umkreissuche!
			    $noMatch = TRUE;
            }
		} else if ($place) {
			// Suche nach Ort, aber keine Umkreissuche
			$place = $place . '%';
		}
		
		if (!$noMatch) {
		    //var_dump($uids);
			$constraints = [];
			$query = $this->createQuery();
			if (!empty($pids)) {
				$query->getQuerySettings()->setRespectStoragePage(false);
				$constraints[] = $query->in('pid', $pids);
			}
			if ($onlyDistinct) {
				$constraints[] = $query->equals('mother', 0);
			}
			if (!empty($uids)) {
				$constraints[] = $query->in('uid', $uids);
			}
			if ($place && !$radius) {
				$constraints[] = $query->logicalOr(
					$query->like('city', $place),
					$query->like('zip', $place)
				);
			} elseif ($sword) {
				$constraints[] = $query->logicalOr(
					$query->logicalOr(
							$query->logicalOr(
									$query->like('title', $sword),
									$query->like('shortdesc', $sword)
							),
							$query->logicalOr(
									$query->like('person', $sword),
									$query->like('longdesc', $sword)
							)
					),
					$query->logicalOr(
							$query->logicalOr(
									$query->like('custom1', $sword),
									$query->like('custom2', $sword)
							),
							$query->logicalOr(
									$query->like('city', $sword),
									$query->like('zip', $sword)
							)
					)
				);
			}
			if (!empty($constraints)) {
			    //var_dump($constraints);
				$query->matching($query->logicalAnd(...$constraints));
			}
			if ($limit > 0) {
				$query->setLimit(intval($limit));
			}
			return $query
				->setOrderings([$sortBy => $order])
				->execute();
		}
	}
	
	/**
	 * findByUids ersetzen, wegen Sortierung
	 * @param	array	$uids		UIDs
	 * @param	string	$sortBy		Sort by
	 * @param	string	$sortOrder	Sort order
	 */
	public function findByUids($uids, $sortBy = 'sorting', $sortOrder = 'asc')
	{
		$order = ($sortOrder == 'desc') ? QueryInterface::ORDER_DESCENDING :
										 QueryInterface::ORDER_ASCENDING;
		if ($sortBy=='sorting' || $sortBy=='tstamp' || $sortBy=='title' || $sortBy=='zip' || $sortBy=='city'
		 || $sortBy=='country' || $sortBy=='custom1' || $sortBy=='custom2' || $sortBy=='custom3') {
		 	// OK
		} else {
		 	$sortBy = 'sorting';
		}
		$query = $this->createQuery();
		$query->getQuerySettings()->setRespectStoragePage(false);
		// nicht nötig: if ($onlyDistinct) $query->matching($query->logicalAnd($query->equals('mother', 0), $query->in('uid', $uids))); else 
		$query->matching($query->in('uid', $uids));
		return $query
			->setOrderings(	[$sortBy => $order] )
			->execute();
	}
	
	/**
	 * findByCategories ersetzen, wegen Sortierung
	 * @param	array	$cat_uids	UIDs von Kategorien
	 * @param	string	$sword		Suchwort
	 * @param	string	$place		Ort
	 * @param	integer	$radius		Radius
	 * @param	string	$sortBy		Sort by
	 * @param	string	$sortOrder	Sort order
	 * @param	boolean	$onlyDistinct	Only distinct entries?
	 * @param	array	$pids		Storage PIDs
	 * @param	boolean	$checkMax	true: OR/AND mode; false: only OR mode
	 * @param	integer	$limit		Limit
	 */
	public function findByCategories($cat_uids, $sword, $place, $radius, $sortBy = 'sorting', $sortOrder = 'asc', $onlyDistinct = false, $pids = [], $checkMax = true, $limit = 0)
	{
		if (!empty($cat_uids)) {
			$max = 0;
			$parents = [];	// Übergeordnete Elemente
			$childs = [];	// Kind-Elemente, die angezeigt werden sollen
			$twice = [];	// Kind-Elemente, die entfernt werden sollen
			$elements = [];	// Elemente, die gefunden wurden, mit Anzahl der Treffer bei der Suche zu diesem Element
			$results = [];	// Elemente, die zum Schluss übrig bleiben
			$table = 'tx_camaliga_domain_model_content';
			$joinTable = 'sys_category_record_mm';
			//if (count($pids)>0) $where = ' AND con.pid IN (' . implode(',', $pids) . ')'; else $where = '';
			
			foreach ($cat_uids as $uidsChilds) {
				// Search all elements of specified category/ies
				$queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable($table);	// muss jedes mal neu gezogen werden!
				$queryBuilder
					->select('uid', 'mother')
					->from($table)
					->leftJoin(
						$table,
						$joinTable,
						'categoryMM',
						$queryBuilder->expr()->eq(
							'tx_camaliga_domain_model_content.uid',
							$queryBuilder->quoteIdentifier('categoryMM.uid_foreign')
						)
					)
					->where(
						$queryBuilder->expr()->eq('categoryMM.tablenames', $queryBuilder->createNamedParameter($table)),
						$queryBuilder->expr()->eq('categoryMM.fieldname', $queryBuilder->createNamedParameter('categories')),
						$queryBuilder->expr()->in('categoryMM.uid_local', explode(',', (string) $uidsChilds))
					);
				if (!empty($pids)) {
					$queryBuilder->andWhere( $queryBuilder->expr()->in('tx_camaliga_domain_model_content.pid', $pids) );
				}
				$queryBuilder->groupBy('tx_camaliga_domain_model_content.uid');
				//debug($queryBuilder->getSQL());
				$result = $queryBuilder->executeQuery()->fetchAllAssociative();
				foreach ($result as $row) {
					$cam_uid = $row['uid'];
                    if (isset($elements[$cam_uid])) {
                        $elements[$cam_uid]++;
                    } else {
                        $elements[$cam_uid] = 1;
                    }
					$parents[$cam_uid] = $row['mother'];
					$childs[$cam_uid] = 0;
				}
				$max++;
			}
			//var_dump($uids); echo "max: $max -- "; var_dump($elements);
			
			// take only elements where all matches were true
			foreach ($elements as $uid => $count) {
				if (($count == $max) || !$checkMax) {
					$results[$uid] = $uid; // statt $results[] =
				}
			}
			
			// wenn nur einmalige Elemente angezeigt werden sollen, dann weiter ausdünnen
			if ($onlyDistinct) {
				foreach ($results as $key => $uid) {
					$mother = $parents[$uid];
					if ($mother > 0) {
						// Es gibt ein Mutter-Element
						if (in_array($mother, $results)) {
							// Mutter-Element vorhanden, also dieses Kind entfernen
							$twice[$key] = $uid;
						} else {
							if ($childs[$mother]) {
								// Ähnliches Element vorhanden, also dieses Kind entfernen
								$twice[$key] = $uid;
							} else {
								// Dieses Kind statt der Mutter anzeigen
								$childs[$mother] = $uid;
							}
						}
					}
				}
				if (!empty($twice)) {
					// Dieses nicht eindeutigen Elemente entfernen
					foreach ($twice as $key => $uid) {
						unset($results[$key]);
					}
				}
			}
			
			if (sizeof($results) > 0) {
				// search all content elements of specified uids
				if ($sword || $place) {
					return $this->findComplex($results, $sword, $place, $radius, $sortBy, $sortOrder, $onlyDistinct, $pids, $limit = 0);
				} else {
					return $this->findByUids($results, $sortBy, $sortOrder);
				}
			}
		} else {
			// sollte eigentlich nie eintreten
			return $this->findAll($sortBy, $sortOrder, $onlyDistinct, $pids, $limit = 0);
		}
	}
	
	/**
     * Get a random object
     */
    public function findRandom()
    {
        $rows = $this->createQuery()->execute()->count();
        $row_number = random_int(0, max(0, ($rows - 1)));
        return $this->createQuery()->setOffset($row_number)->setLimit(1)->execute();
    }

	/**
	 * findByMother2 ersetzen, wegen Schwestern
	 * @param	integer	$mother	Mutter-UID
	 * @param	integer	$child	Aktuelle Kind-UID
	 */
	public function findByMother2($mother, $child)
	{
		$mother = intval($mother);
		$child = intval($child);
		$query = $this->createQuery();
		if ($child > 0) {
			$query->matching(
					$query->logicalAnd(
							$query->equals('mother', $mother),
							$query->logicalNot($query->equals('uid', $child))
					)
			);
		} else {
			$query->matching($query->equals('mother', $mother));
		}
		return $query->execute();
	}
	
	/**
	 * findOneByUid2 ohne Ordner-Berücksichtigung
	 * @param	integer	$uid	UID
	 */
	public function findOneByUid2($uid)
	{
	    $query = $this->createQuery();
	    $query->getQuerySettings()->setRespectStoragePage(FALSE);
	    return $query->matching(
	        $query->equals('uid', $uid)
	    )->execute()->getFirst();
	}
	
	/**
	 * set new sorting
	 * @param	integer	$uid		UID
	 * @param	integer	$sorting	Sorting order
	 */
	public function setNewSorting($uid, $sorting): void
	{
		$table = 'tx_camaliga_domain_model_content';
		$queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable($table);
		$queryBuilder
		->update($table)
		->where(
			$queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter($uid, \TYPO3\CMS\Core\Database\Connection::PARAM_INT))
		)
		->set('sorting', intval($sorting))
		->set('tstamp', time())
		->executeStatement();
	}
	
	/**
	 * Get categories, used by camaliga AND used by storagePids: wird anscheinend nirgends benutzt!?
	 *
	 * @param	array	$pids	Category PIDs
	 * @return	array
	 */
	public function getRelevantCategories($pids = [])
	{
		if (!$pids) {
			$pids = $this->getStoragePids();
		}
		// siehe hier: https://stackoverflow.com/questions/54691047/what-will-be-the-mm-query-in-typo3-version-9
		$table = 'tx_camaliga_domain_model_content';
		$joinTable = 'sys_category_record_mm';
		$queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable($table);
		$queryBuilder
			->select('categoryMM.uid_local')
			->from($table)
			->leftJoin(
				$table,
				$joinTable,
				'categoryMM',
				$queryBuilder->expr()->eq(
					'tx_camaliga_domain_model_content.uid',
					$queryBuilder->quoteIdentifier('categoryMM.uid_foreign')
				)
			)
			->where(
				$queryBuilder->expr()->eq('categoryMM.tablenames', $queryBuilder->createNamedParameter($table)),
				$queryBuilder->expr()->eq('categoryMM.fieldname', $queryBuilder->createNamedParameter('categories')),
				$queryBuilder->expr()->in('tx_camaliga_domain_model_content.pid',	$pids)
			)
			->groupBy('categoryMM.uid_local');
		//debug($queryBuilder->getSQL());
		return $queryBuilder->executeQuery()->fetchAllAssociative();
	}
	
	/**
	 * Get the PIDs with Titles
	 *
	 * @return array
	 */
	public function getStoragePidsData()
	{
		$storagePidsData_tmp = [];
		$pids = $this->getStoragePids();
		$queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('pages');
		$statement = $queryBuilder
			->select('uid','title')
			->from('pages')
			->where(
				$queryBuilder->expr()->in('uid', $pids)
			)
			->executeQuery();
		while ($row = $statement->fetchAssociative()) {
			$uid = $row['uid'];
			$storagePidsData_tmp[$uid] = [];
			$storagePidsData_tmp[$uid]['uid'] = $uid;
			$storagePidsData_tmp[$uid]['title'] = $row['title'];
			$storagePidsData_tmp[$uid]['selected'] = 0;
		}
		return $storagePidsData_tmp;
	}
	
	/**
     * Get the PIDs
     * 
	 * @return array
     */
    public function getStoragePids()
    {
        $query = $this->createQuery();
		return $query->getQuerySettings()->getStoragePageIds();
    }
    
    /**
     * Get the siteroot
     *
     * @return integer
     */
    public function getSiteRoot(): int
    {
    	$uid = 1;
    	$queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('pages');
    	$statement = $queryBuilder
    	->select('uid')
    	->from('pages')
    	->where(
    		$queryBuilder->expr()->eq('is_siteroot', 1)
   		)
   		->setMaxResults(1)
   		->executeQuery();
   		while ($row = $statement->fetchAssociative()) {
   			$uid = $row['uid'];
   		}
   		return $uid;
    }
    
    /**
     * Get the link to a file. Works only with files in the fileadmin-folder!?
     *
     * @param	int	$uid	UID of a file
     * @return string
     */
    public function getFileLink($uid): string
    {
    	$output = '';
    	$queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('sys_file');
    	$statement = $queryBuilder
    	->select('identifier', 'storage')
    	->from('sys_file')
    	->where(
    		$queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter($uid, \TYPO3\CMS\Core\Database\Connection::PARAM_INT))
   		)
   		->setMaxResults(1)
   		->executeQuery();
   		while ($row = $statement->fetchAssociative()) {
   			$output = ($row['storage'] == 1) ? '/fileadmin' . $row['identifier'] : $row['identifier'];
   		}
   		return $output;
    }

    /**
     * Update image information and deleted processed file
     *
     * @param int	$uid   UID of a file
     * @param array $infos Infos to update
     * @return void
     */
    public function updateImageInfos($uid, $infos): void
    {
        $table = 'sys_file';
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable($table);
        $queryBuilder
            ->update($table)
            ->where(
                $queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter($uid, \TYPO3\CMS\Core\Database\Connection::PARAM_INT))
            )
            ->set('size', intval($infos['size']))
            ->executeStatement();
        $table = 'sys_file_metadata';
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable($table);
        $queryBuilder
            ->update($table)
            ->where(
                $queryBuilder->expr()->eq('file', $queryBuilder->createNamedParameter($uid, \TYPO3\CMS\Core\Database\Connection::PARAM_INT))
            )
            ->set('width', intval($infos['width']))
            ->set('height', intval($infos['height']))
            ->executeStatement();
    }
}