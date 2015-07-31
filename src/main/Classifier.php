<?php
namespace Ryckes\SpamClassifierComparator;

interface Classifier {
    public function __construct(array $trainingSet, array $trainingSetLabels);
    public function classify($message);
}
