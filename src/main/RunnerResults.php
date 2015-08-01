<?php
namespace Ryckes\SpamClassifierComparator;

final class RunnerResults {
    private $truePositives, $trueNegatives, $falsePositives, $falseNegatives, $predictedLabels, $actualLabels, $testSet;

    public function __construct(array $predictedLabels, array $actualLabels, array $testSet) {
        $this->truePositives = 0;
        $this->trueNegatives = 0;
        $this->falsePositives = 0;
        $this->falseNegatives = 0;
        $this->predictedLabels = $predictedLabels;
        $this->actualLabels = $actualLabels;
        $this->testSet = $testSet;
        
        for ($i = 0; $i < count($predictedLabels); $i++) {
            if ($predictedLabels[$i]) {
                if ($actualLabels[$i])
                    $this->truePositives++;
                else
                    $this->falsePositives++;
            }
            else {
                if ($actualLabels[$i])
                    $this->falseNegatives++;
                else
                    $this->trueNegatives++;
            }
        }
    }

    public function getFalsePositives() {
        return $this->falsePositives;
    }

    public function getFalseNegatives() {
        return $this->falseNegatives;
    }

    public function getPrecision() {
        if ($this->truePositives + $this->falsePositives === 0)
            throw new InsufficientTestSetException();
        
        return $this->truePositives / ((float) $this->truePositives + $this->falsePositives);
    }

    public function getRecall() {
        if ($this->truePositives + $this->falseNegatives === 0)
            throw new InsufficientTestSetException();

        return $this->truePositives / ((float) $this->truePositives + $this->falseNegatives);
    }

    public function getSpecificity() {
        if ($this->trueNegatives + $this->falsePositives === 0)
            throw new InsufficientTestSetException();
        
        return $this->trueNegatives / ((float) $this->trueNegatives + $this->falsePositives);
    }

    public function getAccuracy() {
        if ($this->truePositives + $this->trueNegatives +
            $this->falsePositives + $this->falseNegatives === 0)
                throw new InsufficientTestSetException();
        
        return ($this->truePositives + $this->trueNegatives) / ((float) + $this->truePositives + $this->trueNegatives + $this->falsePositives + $this->falseNegatives);
    }

    public function getPredictedLabels() {
        return $this->predictedLabels;
    }

    public function getActualLabels() {
        return $this->actualLabels;
    }

    public function getTestSet() {
        return $this->testSet;
    }
}
