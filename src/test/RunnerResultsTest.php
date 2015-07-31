<?php
use Ryckes\SpamClassifierComparator\RunnerResults;

class RunnerResultsTest extends \PHPUnit_Framework_TestCase {

    public function testFalsePositives() {
        // Arrange
        $actual = [true, true, false, false];
        $predicted = [true, false, true, false];
        $testSet = [null, null, null, null];
        $results = new RunnerResults($predicted, $actual, $testSet);
        
        // Act
        $falsePositives = $results->getFalsePositives();
        
        // Assert
        $this->assertEquals(1, $falsePositives);
    }

    public function testFalseNegatives() {
        // Arrange
        $actual = [true, true, false, false];
        $predicted = [true, false, true, false];
        $testSet = [null, null, null, null];
        $results = new RunnerResults($predicted, $actual, $testSet);
        
        // Act
        $falseNegatives = $results->getFalseNegatives();
        
        // Assert
        $this->assertEquals(1, $falseNegatives);
    }

    public function testPrecision() {
        // Arrange
        $actual = [true, true, false, false, true];
        $predicted = [true, false, true, false, false];
        $testSet = [null, null, null, null, null];
        $results = new RunnerResults($predicted, $actual, $testSet);
        
        // Act
        $precision = $results->getPrecision();
        
        // Assert
        $this->assertEquals(1.0 / 2.0, $precision);
    }

    public function testRecall() {
        // Arrange
        $actual = [true, true, false, false, true];
        $predicted = [true, false, true, false, false];
        $testSet = [null, null, null, null, null];
        $results = new RunnerResults($predicted, $actual, $testSet);
        
        // Act
        $recall = $results->getRecall();
        
        // Assert
        $this->assertEquals(1.0 / 3.0, $recall);
    }

    public function testSpecificity() {
        // Arrange
        $actual = [true, true, false, false, true];
        $predicted = [true, false, true, false, false];
        $testSet = [null, null, null, null, null];
        $results = new RunnerResults($predicted, $actual, $testSet);
        
        // Act
        $specificity = $results->getSpecificity();
        
        // Assert
        $this->assertEquals(1.0 / 2.0, $specificity);
    }

    public function testAccuracy() {
        // Arrange
        $actual = [true, true, false, false, true];
        $predicted = [true, false, true, false, false];
        $testSet = [null, null, null, null, null];
        $results = new RunnerResults($predicted, $actual, $testSet);
        
        // Act
        $accuracy = $results->getAccuracy();
        
        // Assert
        $this->assertEquals(2.0 / 5.0, $accuracy);
    }
}
