<?php
namespace Ryckes\SpamClassifierComparator;

class RandomPartitioner {

    public static function partitionTwo(DataSet $wholeSet, $partitionRelation, $seed = null) {
        if (!is_numeric($partitionRelation) ||
            $partitionRelation <= 0 || $partitionRelation >= 1)
                throw new InvalidArgumentException();

        // mt_srand(null) === mt_srand(0)
        if ($seed !== null)
            mt_srand($seed);

        $numElements = count($wholeSet->getData());

        $indexes = range(0, $numElements - 1);
        self::shuffle($indexes);

        $trainingSet = [];
        $trainingSetLabels = [];
        $testSet = [];
        $testSetLabels = [];

        $data = $wholeSet->getData();
        $labels = $wholeSet->getLabels();

        for ($i = 0; $i < $numElements; $i++) {
            $index = $indexes[$i];
            
            if ($i < $partitionRelation * $numElements) {
                $trainingSet[] = $data[$index];
                $trainingSetLabels[] = $labels[$index];
            }
            else {
                $testSet[] = $data[$index];
                $testSetLabels[] = $labels[$index];
            }
        }

        $trainingDataSet = new DataSet($trainingSet, $trainingSetLabels);
        $testDataSet = new DataSet($testSet, $testSetLabels);

        return new Partition($trainingDataSet, $testDataSet);
    }

    private static function shuffle(array &$indexes) {
        $numElements = count($indexes);
        
        // Knuth shuffle
        // Alternative: php's shuffle()
        for ($i = 0; $i < $numElements; $i++) {
            $randIndex = mt_rand($i, $numElements - 1);
            
            $tmp = $indexes[$i];
            $indexes[$i] = $indexes[$randIndex];
            $indexes[$randIndex] = $tmp;
        }
    }
}
