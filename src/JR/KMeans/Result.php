<?php

namespace JR\KMeans;

/**
 * Description of Result.
 *
 * @author	RebendaJiri
 * @package JR\KMeans
 */
final class Result
{
	/** @var array */
	private $clusteredData;
	
	/** @var array */
	private $centroids;
	
	public function __construct(array $clusteredData, array $centroids)
	{
		$this->clusteredData = $clusteredData;
		$this->centroids = $centroids;
	}
	
	/**
	 * @return array
	 */
	public function getClusteredData()
	{
		return $this->clusteredData;
	}
	
	/**
	 * @return array
	 */
	public function getCentroids()
	{
		return $this->centroids;
	}
}