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
	
	/** @var array */
	private $clusteredData = array();
	
	public function __construct(array $data)
	{
		if (count($data) < 2) {
			throw new \Exception('At least two data points needed.');
		}
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
		if ($clusterCount > count($this->data)) {
			throw new \Exception('Cluster count cannot be greater than the number of data points.');
		}
		
		do {
			if (empty($centroids)) {
				$centroids = $this->getInitialCentroids($clusterCount);
			} else {
				$centroids = $this->getCentroids($this->clusteredData);
			}
			
			$newClusteredData = array();
			for ($i = 0; $i < $clusterCount; $i++) {
				$newClusteredData[$i] = array();
			}
			
			foreach ($this->data as $dataPoint) {
				$closestCentroid = $this->getClosestCentroid($dataPoint, $centroids);
				$newClusteredData[$closestCentroid][] = $dataPoint;
			}
		} while ($this->check($this->clusteredData, $newClusteredData) === FALSE);
		
		return $this->clusteredData;
	}
	
	private function check(array $clusteredData, array $newClusteredData)
	{
		if (empty($clusteredData)) {
			$this->clusteredData = $newClusteredData;
			return FALSE;
		}
		
		foreach ($clusteredData as $key => $cluster) {
			foreach ($cluster as $dataPoint) {
				if (!in_array($dataPoint, $newClusteredData[$key])) {
					$this->clusteredData = $newClusteredData;
					return FALSE;
				}
			}
		}
		
		return TRUE;
	}
	
	/**
	 * @return array
	 */
	private function getInitialCentroids($clusterCount)
	{
		$randomKeys = array_flip(array_rand($this->data, $clusterCount));
		$centroids = array_intersect_key($this->data, $randomKeys);
		return array_combine(range(0, $clusterCount - 1), $centroids); // remap array keys
	}
	
	/**
	 * @param array $clusteredData
	 * @return array
	 */
	private function getCentroids(array $clusteredData)
    {
        $centroids = array();
        foreach ($clusteredData as $cluster) {
            $clusterSum = array_fill(0, count(current($cluster)), 0);
            foreach ($cluster as $dataPoint) {
                foreach ($dataPoint as $key => $value) {
                    $clusterSum[$key] += $value;
                }
            }
            $centroid = array_fill(0, count(current($cluster)), 0);
            foreach ($clusterSum as $key => $value) {
                $centroid[$key] = $value / count($cluster);
            }
            array_push($centroids, $centroid);
        }
        return $centroids;
    }
	
	/**
	 * Returns centroid closest to given data point.
	 * 
	 * @param array $dataPoint
	 * @param array $centroids
	 * @return array
	 */
	private function getClosestCentroid(array $dataPoint, array $centroids)
	{
		$closestDistance = NULL;
		$closestCentroid = NULL;
		foreach ($centroids as $centroidKey => $centroid) {
			$tempDistance = $this->getDistance($dataPoint, $centroid);
			if ($closestCentroid === NULL || $tempDistance < $closestDistance) {
				$closestDistance = $tempDistance;
				$closestCentroid = $centroidKey;
			}
		}
		return $closestCentroid;
	}
	
	/**
	 * Returns euclidean distance between two datapoints.
	 * 
	 * @param array $dataPoint1
	 * @param array $dataPoint2
	 * @return float
	 */
	private function getDistance(array $dataPoint1, array $dataPoint2)
	{
		$sumSquares = 0;
		for ($i = 0; $i < count($dataPoint1); $i++) {
			$sumSquares += pow($dataPoint1[$i] - $dataPoint2[$i], 2);
		}
		return sqrt($sumSquares);
	}
}