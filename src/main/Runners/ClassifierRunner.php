<?php
namespace Ryckes\SpamClassifierComparator\Runners;
use Ryckes\SpamClassifierComparator\Classifiers\Classifier;

interface ClassifierRunner {
    public function __construct(Classifier $classifier);
    public function run(array $testSet, array $testSetLabels);
}
