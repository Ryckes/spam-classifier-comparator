<?php
namespace Ryckes\SpamClassifierComparator\Formatters;
use Ryckes\SpamClassifierComparator\RunnerResults;

class DefaultFormatter implements ResultsFormatter {

    private static $format = <<<FMT
Size of test set: %d

False positives: %d
False negatives: %d
Precision: %f
Recall: %f
Specificity: %f
Accuracy: %f
F-Measure: %f

FMT;
    
    public function format(RunnerResults $results) {
        return sprintf(self::$format, count($results->getTestSet()),
                       $results->getFalsePositives(), $results->getFalseNegatives(),
                       $results->getPrecision(), $results->getRecall(),
                       $results->getSpecificity(), $results->getAccuracy(),
                       $results->getFMeasure());
    }
}
