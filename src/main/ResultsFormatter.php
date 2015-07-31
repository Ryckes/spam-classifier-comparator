<?php
namespace Ryckes\SpamClassifierComparator;

interface ResultsFormatter {
    public function format(RunnerResults $results);
}
