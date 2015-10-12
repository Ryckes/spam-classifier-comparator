<?php
namespace Ryckes\SpamClassifierComparator\Classifiers;
use Ryckes\SpamClassifierComparator\Classifier;

class RandomClassifier implements Classifier {

    private $spamPrior;
    
    public function __construct(array $trainingSet, array $trainingSetLabels) {
        $numSpam = 0;
        for ($i = 0; $i < count($trainingSet); $i++) {
            if ($trainingSetLabels[$i])
                $numSpam++;
        }
        $this->spamPrior = ((float) $numSpam) / count($trainingSet);
    }

    public function classify($message) {
        return rand(1, 10000) < $this->spamPrior * 10000;
    }
}
