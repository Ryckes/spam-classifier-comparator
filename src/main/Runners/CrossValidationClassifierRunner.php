<?php
namespace Ryckes\SpamClassifierComparator\Runners;
use Ryckes\SpamClassifierComparator\Classifiers\Classifier;
use Ryckes\SpamClassifierComparator\Partitioners\CrossValidationRandomPartitioner;
use Ryckes\SpamClassifierComparator\DataSet;
use Ryckes\SpamClassifierComparator\RunnerResults;

class CrossValidationClassifierRunner implements ClassifierRunner {
    private $classifierClassName, $numberOfPartitions;

    const DEFAULT_NUMBER_OF_PARTITIONS = 10;

    public function __construct(Classifier $classifier) {
        $this->classifierClassName = get_class($classifier);

        $this->numberOfPartitions = self::DEFAULT_NUMBER_OF_PARTITIONS;
    }

    public function setNumberOfPartitions($num) {
        $this->numberOfPartitions = $num;
    }

    private function classify(Classifier $classifier, array $testSet) {
        $predictedLabels = [];
        for ($i = 0; $i < count($testSet); $i++) {
            $predictedLabels[] = $classifier->classify($testSet[$i]);
        }
        
        return $predictedLabels;
    }

    public function run(array $dataSet, array $dataSetLabels) {
        // Generate folds
        $partitioner = new CrossValidationRandomPartitioner(new DataSet($dataSet, $dataSetLabels), $this->numberOfPartitions);

        $resultsList = [];
        for ($i = 0; $i < $this->numberOfPartitions; $i++) {
            // For each fold, train and classify
            $currentPartition = $partitioner->getPartition($i);
            $currentTest = $currentPartition->getTestData();
            $currentTraining = $currentPartition->getTrainingData();

            $classifier = new $this->classifierClassName($currentTraining->getData(), $currentTraining->getLabels());
            $predicted = $this->classify($classifier, $currentTest->getData());
            $resultsList[] = new RunnerResults($predicted, $currentTest->getLabels(), $currentTest->getData());
        }

        return RunnerResults::combine($resultsList);
    }
}
