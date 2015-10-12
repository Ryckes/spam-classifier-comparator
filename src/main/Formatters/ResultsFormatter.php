<?php
namespace Ryckes\SpamClassifierComparator\Formatters;
use Ryckes\SpamClassifierComparator\RunnerResults;

interface ResultsFormatter {
    public function format(RunnerResults $results);
}
