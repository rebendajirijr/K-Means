<?php

namespace JR\KMeans;

use Nette;

/**
 * Description of KMeans.
 *
 * @author	RebendaJiri
 * @package JR\KMeans
 */
class KMeans
{
	/** @var array */
	private $data;
	
	public function __construct(array $data)
	{
		$this->data = $data;
	}
	
	/**
	 * @param int $clusterCount >= 2
	 * @return array
	 */
	public function cluster($clusterCount)
	{
		if ($clusterCount < 2) {
			throw new \Exception('Cluster count must be equal or greater to 2.');
		}
		if ($clusterCount > count($data)) {
			throw new \Exception('Cluster count cannot be greater than the number of data points.');
		}
	}
}