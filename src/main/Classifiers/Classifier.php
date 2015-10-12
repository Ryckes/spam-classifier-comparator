<?php
namespace Ryckes\SpamClassifierComparator\Classifiers;

interface Classifier {
    public function __construct(array $trainingSet, array $trainingSetLabels);

    /**
     * @return bool True if $message is classified as spam.
     */
    public function classify($message);
}
