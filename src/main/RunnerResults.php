<?php
namespace Ryckes\SpamClassifierComparator;
use Ryckes\SpamClassifierComparator\Exceptions\InsufficientTestSetException;

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

    public static function combine(array $resultsList) {
        $n = 0;
        foreach ($resultsList as $results)
            $n += count($results->getActualLabels());

        // Preallocate for better performance
        $predictedLabels = array($n);
        $actualLabels = array($n);
        $testSet = array($n);

        $i = 0;
        foreach ($resultsList as $results) {
            $pl = $results->getPredictedLabels();
            $al = $results->getActualLabels();
            $ts = $results->getTestSet();
            for ($j = 0; $j < count($pl); $j++) {
                $predictedLabels[$i] = $pl[$j];
                $actualLabels[$i] = $al[$j];
                $testSet[$i] = $ts[$j];
                $i++;
            }
        }

        return new RunnerResults($predictedLabels, $actualLabels, $testSet);
    }

    public function getTruePositives() {
        return $this->truePositives;
    }

    public function getTrueNegatives() {
        return $this->trueNegatives;
    }

    public function getFalsePositives() {
        return $this->falsePositives;
    }

    public function getFalseNegatives() {
        return $this->falseNegatives;
    }

    public function getPrecision() {
        if ($this->truePositives + $this->falsePositives === 0)
            throw new InsufficientTestSetException('Precision cannot be computed');

        return $this->truePositives / ((float) $this->truePositives + $this->falsePositives);
    }

    public function getRecall() {
        if ($this->truePositives + $this->falseNegatives === 0)
            throw new InsufficientTestSetException('Recall cannot be computed');

        return $this->truePositives / ((float) $this->truePositives + $this->falseNegatives);
    }

    public function getSpecificity() {
        if ($this->trueNegatives + $this->falsePositives === 0)
            throw new InsufficientTestSetException('Specificity cannot be computed');

        return $this->trueNegatives / ((float) $this->trueNegatives + $this->falsePositives);
    }

    public function getAccuracy() {
        if ($this->truePositives + $this->trueNegatives +
            $this->falsePositives + $this->falseNegatives === 0)
                throw new InsufficientTestSetException('Accuracy cannot be computed');

        return ($this->truePositives + $this->trueNegatives) / ((float) + $this->truePositives + $this->trueNegatives + $this->falsePositives + $this->falseNegatives);
    }

    public function getFMeasure() {
        $denominator = 2 * $this->truePositives + $this->falsePositives + $this->falseNegatives;
        if ($denominator === 0)
            throw new InsufficientTestSetException('F-Measure cannot be computed');

        return 2 * $this->truePositives / ((float) $denominator);
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
