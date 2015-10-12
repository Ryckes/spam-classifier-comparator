
# Spam classifier comparator

In this project I provide a set of interfaces for spam classifiers,
classification runners (normal, k-fold cross validation...), results
formatters, etc. and some implementations for them (random and Graham
classifier, normal and cross-validation runner, default formatter...)
which can be used to test a set of classifiers against the same test
data with the same training data for comparison.

# Why? Why???!!!

I've had spam issues in comments in my blog and I'd like to try a few
different content-based classifiers and see how they perform with my
data. I thought it would be cool to be able to compare a wider range
of messages (some user may want to include additional metadata in the
classifier computations) so I will code it with some degree of
genericity or polymorphism. To do that, I have decided to represent
the result of a given classification with a simple boolean type: true
for positive, false for negative.

My goal is that, if you already have your classes for representing
messages and classifiers, you can build a **simple**
[Adapter](https://en.wikipedia.org/wiki/Adapter_pattern) for your
classifier and plug both along with a pair of training set and test
set and see the numbers pop out. Thus I have to make it simple so you
don't need to modify the internals of the classifier.

The Classifier interface will probably change soon, because with the
current implementation of the Cross-Validation runner it is not
possible to change the default parameters of the classifier under test
(except through inheritance, but it would be unfeasible to create an
inherited class for all the combinations of parameters one may want to
try).

# Interface

Right now it can only be used through scripts like the ones shown in
CVExampleComparator.php and ExampleComparator.php. The
DefaultFormatter class returns a simple representation of the results,
but you can create a formatter that implements the ResultsFormatter
interface (or not) to give the RunnerResults any format.
