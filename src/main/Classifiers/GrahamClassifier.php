<?php
namespace Ryckes\SpamClassifierComparator\Classifiers;

class GrahamClassifier implements Classifier {
    private $numSpam, $numHam, $spamDict, $hamDict;

    const DEFAULT_SPAM_THRESHOLD = 0.8;
    
    private $spamThreshold = self::DEFAULT_SPAM_THRESHOLD;

    public function __construct(array $trainingSet, array $trainingSetLabels) {
        $this->numSpam = 0;
        $this->numHam = 0;
        $this->spamDict = [];
        $this->hamDict = [];

        for ($i = 0; $i < count($trainingSet); $i++) {
            $message = $trainingSet[$i];
            $label = $trainingSetLabels[$i];

            // TODO: Transform $message (symbols, case...)

            foreach (explode(' ', $message) as $word) {
                if (!isset($this->spamDict[$word])) {
                    $this->spamDict[$word] = 0;
                    $this->hamDict[$word] = 0;
                }

                if ($label)
                    $this->spamDict[$word]++;
                else
                    $this->hamDict[$word]++;
            }

            if ($label)
                $this->numSpam++;
            else
                $this->numHam++;
        }
    }

    public function setSpamThreshold($threshold) {
        $this->spamThreshold = $threshold;
    }

    public function classify($message) {
        $probabilities = [];
        foreach (explode(' ', $message) as $token)
            $probabilities[] = $this->tokenProbability($token);

        usort($probabilities, function($a, $b) {
            $distA = abs(0.5 - $a);
            $distB = abs(0.5 - $b);

            if ($distA === $distB) return 0;
            if ($distA > $distB) return -1;
            return 1;
        });

        // Inefficient, use a size 15 maxheap in production
        $probabilities = array_slice($probabilities, 0, 15);

        $className = 'Ryckes\SpamClassifierComparator\Classifiers\GrahamClassifier';
        $product = array_reduce($probabilities, [$className, 'multiply'], 1);

        $reverseProduct = array_reduce(array_map([$className, 'opposite'], $probabilities), [$className, 'multiply'], 1);

        return $product / ($product + $reverseProduct) >= $this->spamThreshold;
    }

    private static function multiply($p1, $p2) {
        return $p1 * ((float) $p2);
    }

    private static function opposite($p) {
        return 1 - $p;
    }

    private function tokenProbability($token) {
        if (isset($this->spamDict[$token])) {
            $spamAppearances = $this->spamDict[$token];
            $hamAppearances = 2 * $this->hamDict[$token];
        }
        else {
            $spamAppearances = 0;
            $hamAppearances = 0;
        }

        if ($spamAppearances + $hamAppearances < 5)
            return 0.5; // Not enough information

        $spamProbability = min(1, $spamAppearances / $this->numSpam);
        $hamProbability = min(1, $hamAppearances / $this->numHam);

        $probability = max(0.1, min(0.99, $spamProbability / ($spamProbability + $hamProbability)));

        return $probability;
    }
}
