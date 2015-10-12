<?php
namespace Ryckes\SpamClassifierComparator;
use Ryckes\SpamClassifierComparator\Classifiers\GrahamClassifier;
use Ryckes\SpamClassifierComparator\Runners\CrossValidationClassifierRunner;
use Ryckes\SpamClassifierComparator\Formatters\DefaultFormatter;

require __DIR__ . '/../vendor/autoload.php';

$wholeSet = json_decode(file_get_contents('./exampleTestSet.json'));
$wholeSetLabels = json_decode(file_get_contents('./exampleTestSetLabels.json'));

$classifier = new GrahamClassifier([], []); // Will be discarded

$runner = new CrossValidationClassifierRunner($classifier);
$runner->setNumberOfPartitions(9);
$results = $runner->run($wholeSet, $wholeSetLabels);

$formatter = new DefaultFormatter();
$output = $formatter->format($results);

echo $output;
