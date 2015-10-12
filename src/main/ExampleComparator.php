<?php
namespace Ryckes\SpamClassifierComparator;
use Ryckes\SpamClassifierComparator\Classifiers\GrahamClassifier;
use Ryckes\SpamClassifierComparator\Partitioners\RandomPartitioner;
use Ryckes\SpamClassifierComparator\Runners\SampleClassifierRunner;
use Ryckes\SpamClassifierComparator\Formatters\DefaultFormatter;

require __DIR__ . '/../vendor/autoload.php';

$wholeSet = json_decode(file_get_contents('./exampleTestSet.json'));
$wholeSetLabels = json_decode(file_get_contents('./exampleTestSetLabels.json'));

$trainingToTestSizeRelation = 0.7;

$partition = RandomPartitioner::partitionTwo(new DataSet($wholeSet, $wholeSetLabels), $trainingToTestSizeRelation);
$trainingDataSet = $partition->getTrainingData();
$testDataSet = $partition->getTestData();

$classifier = new GrahamClassifier($trainingDataSet->getData(), $trainingDataSet->getLabels());
$classifier->setSpamThreshold(0.8);

$runner = new SampleClassifierRunner($classifier);

$results = $runner->run($testDataSet->getData(), $testDataSet->getLabels());
$formatter = new DefaultFormatter();
$output = $formatter->format($results);

echo $output;
