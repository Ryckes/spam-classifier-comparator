<?php
namespace Ryckes\SpamClassifierComparator;

interface ClassifierRunner {
    public function __construct(Classifier $classifier);
    public function run(array $testSet, array $testSetLabels);
}
