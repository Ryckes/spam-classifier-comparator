<?php
namespace Ryckes\SpamClassifierComparator\Runners;
use Ryckes\SpamClassifierComparator\Classifiers\Classifier;
use Ryckes\SpamClassifierComparator\RunnerResults;

class SampleClassifierRunner implements ClassifierRunner {
    private $classifier;

    public function __construct(Classifier $classifier) {
        $this->classifier = $classifier;
    }

    private function classify(array $testSet) {
        $predictedLabels = [];
        for ($i = 0; $i < count($testSet); $i++) {
            $predictedLabels[] = $this->classifier->classify($testSet[$i]);
        }
        
        return $predictedLabels;
    }

    public function run(array $testSet, array $testSetLabels) {
        $predictedLabels = $this->classify($testSet);
        $results = new RunnerResults($predictedLabels, $testSetLabels, $testSet);
        
        return $results;
    }
}
