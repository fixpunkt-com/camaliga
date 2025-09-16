<?php
namespace Quizpalme\Camaliga\Domain\Repository;

use TYPO3\CMS\Extbase\Persistence\Repository;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Database\ConnectionPool;

class CategoryRepository extends Repository
{

	/**
	 * findAll ersetzen, wegen Sortierung und PIDs
	 *
	 * @param	string	$sortBy		Sort by
	 * @param	string	$sortOrder	Sort order
	 * @param	array	$pids		Storage PIDs
	 */
	public function findAll($sortBy = 'sorting', $sortOrder = 'asc', $pids = []) {
		$order = ($sortOrder == 'desc') ? 'DESC' : 'ASC';
		if (!($sortBy=='sorting' || $sortBy=='tstamp' || $sortBy=='crdate' || $sortBy=='title' || $sortBy=='uid')) {
			$sortBy = 'sorting';
		}
        $table = 'sys_category';
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable($table);
        $queryBuilder
            ->select('*')
            ->from($table);
        if (!empty($pids)) {
            $queryBuilder->where( $queryBuilder->expr()->in('pid', $pids) );
        }
        $queryBuilder->orderBy($sortBy, $sortOrder);
        return $queryBuilder->executeQuery()->fetchAllAssociative();
	}

	/**
	 * getAllCats: all categories in one simple array
	 *
	 * @param	string	$sortBy		Sort by
	 * @param	string	$sortOrder	Sort order
	 * @param	array	$pids		Storage PIDs
	 * @return	array	categories
	 */
	public function getAllCats($sortBy = 'sorting', $sortOrder = 'asc', $pids = []) {
		// Step 0: init
		$all_cats = [];
		// Step 1: get all categories
		$catRows = $this->findAll($sortBy, $sortOrder, $pids);
		// Step 2: select categories, used by this extension AND used by this storagePids: needed for the category-restriction at the bottom
		if ($catRows) {
			$parentUids = [];
			foreach ($catRows as $row) {
				// Die Parents sind für die Options sehr wichtig
				$parent = $row['parent'];
				if (!$parent) {
					continue;
				}
				$parentUids[$parent] = 1;
			}
			for ($i=1; $i<=2; $i++) {
				foreach ($catRows as $row) {
					$uid = $row['uid'];
					if (($i==1 && isset($parentUids[$uid]) && $parentUids[$uid]==1) || ($i==2 && !isset($parentUids[$uid]))) {
						// In Durchgang 1 die Parents aufnehmen und in Durchgang 2 die Childs
						$parent = $row['parent'];
						if (!$parent) {
							continue;		// wer keinen Parent hat, interessiert uns nicht
						}
						$all_cats[$uid] = [];
						$all_cats[$uid]['uid'] = $uid;
						$all_cats[$uid]['parent'] = $parent;
						$all_cats[$uid]['title']  = $row['title'];
						$all_cats[$uid]['description'] = $row['description'];
					}
				}
			}
		}
		return $all_cats;
	}


	/**
	 * getCategoriesAndParents: all categories in a 2D array with parents and childs
	 *
	 * @param	array	$all_cats	All categories
	 * @param	array	$used_cats	Categories of a camaliga entry
     * @param boolean   $verify_empty return no categories if used_cats is empty?
	 * @return	array	categories
	 */
	public function getCategoriesAndParents($all_cats = [], $used_cats = [], $verify_empty = false): array {
		$cats = [];
		if (!empty($all_cats)) {
			$parentUids = [];
			foreach ($all_cats as $row) {
				// Die Parents sind für die Options sehr wichtig
				$parent = $row['parent'];
				if (!$parent) {
					continue;
				}
				$parentUids[$parent] = 1;
			}
			for ($i=1; $i<=2; $i++) {
				foreach ($all_cats as $row) {
					$uid = $row['uid'];
					$parent = $row['parent'];
					if (((count($used_cats)==0) && !$verify_empty) || isset($used_cats[$uid])) {
						if (($i==1 && isset($parentUids[$uid]) && $parentUids[$uid]==1) || ($i==2)) { // && !$parentUids[$uid])) {
							// In Durchgang 1 die Parents aufnehmen und in Durchgang 2 die Childs
							if ($i==1) {
								// nur parents sind dran
								$cats[$uid] = [];
								$cats[$uid]['childs'] = [];
								$cats[$uid]['uid'] = $uid;
								$cats[$uid]['title'] = $row['title'];
								$cats[$uid]['description'] = $row['description'];
								#echo " # parent ".$row['title'];
							} elseif (($i==2) && isset($cats[$parent]) && is_array($cats[$parent]) && isset($cats[$parent]['title'])) {
								// nur childs und tiefer gelegene parents sind dran
								$cats[$parent]['childs'][$uid] = [];
								$cats[$parent]['childs'][$uid]['uid'] = $uid;
								$cats[$parent]['childs'][$uid]['title'] = $row['title'];
								$cats[$parent]['childs'][$uid]['description'] = $row['description'];
								//echo " # child/deeper parent: ".$row['title'].'='.$parentUids[$uid].'/'.$cats[$parent]['title'];
							} elseif ($i==2) {
								//echo " # no child: ".$row['title'];
							}
						}
					}
				}
			}
		}
		return $cats;
	}
}
