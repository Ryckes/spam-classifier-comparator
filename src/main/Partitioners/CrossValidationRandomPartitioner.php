<?php
namespace Ryckes\SpamClassifierComparator\Partitioners;
use Ryckes\SpamClassifierComparator\DataSet;
use Ryckes\SpamClassifierComparator\Partition;

class CrossValidationRandomPartitioner {
    private $data, $labels, $dataSize, $numberOfPartitions, $partitionSize;

    public function __construct(DataSet $wholeSet, $numberOfPartitions, $seed = null) {
        $this->data = $wholeSet->getData();
        $this->dataSize = count($this->data);
        $this->partitionSize = $this->dataSize / $numberOfPartitions;
        $this->labels = $wholeSet->getLabels();
        $this->numberOfPartitions = $numberOfPartitions;

        // null seed: random
        // false seed: no shuffling
        if ($seed !== false) {
            if ($seed !== null)
                mt_srand($seed);
            
            $this->shuffle();
        }
    }

    public function getPartition($partitionIndex) {
        $firstIndex = $partitionIndex * $this->partitionSize;
        $lastIndex = $firstIndex + $this->partitionSize;


        $trainingData = array_merge(array_slice($this->data, 0, $firstIndex),
                                    array_slice($this->data, $lastIndex));
        $trainingLabels = array_merge(array_slice($this->labels, 0, $firstIndex),
                                      array_slice($this->labels, $lastIndex));
        $testData = array_slice($this->data, $firstIndex, $this->partitionSize);
        $testLabels = array_slice($this->labels, $firstIndex, $this->partitionSize);
        
        return new Partition(new DataSet($trainingData, $trainingLabels),
                             new DataSet($testData, $testLabels));
    }

    private function shuffle() {
        $indexes = range(0, $this->dataSize);
        $numElements = $this->dataSize;
        
        // Knuth shuffle
        // Alternative: php's shuffle()
        for ($i = 0; $i < $numElements; $i++) {
            $randIndex = mt_rand($i, $numElements - 1);
            
            $tmp = $indexes[$i];
            $indexes[$i] = $indexes[$randIndex];
            $indexes[$randIndex] = $tmp;
        }

        $newData = [];
        $newLabels = [];
        for ($i = 0; $i < $numElements; $i++) {
            $index = $indexes[$i];
            $newData[] = $this->data[$index];
            $newLabels[] = $this->labels[$index];
        }
        $this->data = $newData;
        $this->labels = $newLabels;
    }
}
