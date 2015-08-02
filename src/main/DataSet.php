<?php
namespace Ryckes\SpamClassifierComparator;

class DataSet {
    private $data, $labels;
    
    public function __construct(array $data, array $labels) {
        $this->data = $data;
        $this->labels = $labels;
    }

    public function getData() {
        return $this->data;
    }

    public function getLabels() {
        return $this->labels;
    }
}
