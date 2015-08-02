<?php
namespace Ryckes\SpamClassifierComparator;

class Partition {
    private $trainingData, $testData;
    
    public function __construct(DataSet $trainingData, DataSet $testData) {
        $this->trainingData = $trainingData;
        $this->testData = $testData;
    }

    public function getTrainingData() {
        return $this->trainingData;
    }

    public function getTestData() {
        return $this->testData;
    }
}
