<?php
use Ryckes\SpamClassifierComparator\Partitioners\CrossValidationRandomPartitioner;
use Ryckes\SpamClassifierComparator\DataSet;

class CrossValidationRandomPartitionerTest extends \PHPUnit_Framework_TestCase {

    public function testPartitions() {
        // Arrange
        $data = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
        $labels = [false, false, true, false, false, true, false, false, true, true];
        $set = new DataSet($data, $labels);
        $numberOfPartitions = 5;

        $expectedTestData = [[1, 2],
                             [3, 4],
                             [5, 6],
                             [7, 8],
                             [9, 10]];
        $expectedTrainingData = [[3, 4, 5, 6, 7, 8, 9, 10],
                                 [1, 2, 5, 6, 7, 8, 9, 10],
                                 [1, 2, 3, 4, 7, 8, 9, 10],
                                 [1, 2, 3, 4, 5, 6, 9, 10],
                                 [1, 2, 3, 4, 5, 6, 7, 8]];
        $expectedTestLabels = [[false, false],
                               [true, false],
                               [false, true],
                               [false, false],
                               [true, true]];
        $expectedTrainingLabels = [[true, false, false, true, false, false, true, true],
                                   [false, false, false, true, false, false, true, true],
                                   [false, false, true, false, false, false, true, true],
                                   [false, false, true, false, false, true, true, true],
                                   [false, false, true, false, false, true, false, false]];


        // Act
        // false means no shuffling
        $partitioner = new CrossValidationRandomPartitioner($set, $numberOfPartitions, false);
        
        // Assert
        for ($i = 0; $i < $numberOfPartitions; $i++) {
            $currentPartition = $partitioner->getPartition($i);
            $currentTest = $currentPartition->getTestData();
            $currentTraining = $currentPartition->getTrainingData();
            $this->assertEquals($expectedTestData[$i], $currentTest->getData());
            $this->assertEquals($expectedTestLabels[$i], $currentTest->getLabels());
            $this->assertEquals($expectedTrainingData[$i], $currentTraining->getData());
            $this->assertEquals($expectedTrainingLabels[$i], $currentTraining->getLabels());
        }
        
    }
}
