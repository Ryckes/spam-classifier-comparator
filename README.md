
# Spam classifier comparator

The objective of this project is to provide an interface for spam
classifiers and another interface for systems to observe the
characteristics of a fed spam classifier. Then we can implement a
given system to see the results of applying a given classifier to a
given pair of training set and test set (think false positive rate,
false negative rate, precision...).


# Why? Why???!!!

I've had spam issues in comments in my blog and I'd like to try a few
different content-based classifiers and see how they perform with my
data. I thought it would be cool to be able to compare a wider range
of messages (some user may want to include additional metadata in the
classifier computations) so I will code it with some degree of
genericity or polymorphism. To do that, I will need to represent
somehow the result of a given classification, and I will have to
decide if I will use an Enum-like Positive/Negative type, a boolean
type or an interface to be implemented by objects to be classified in
the style of `Classifiable`. I still have to weigh the pros and cons
of each approach.

My goal is that, if you already have your classes for representing
messages and classifiers, you can build a **simple**
[Adapter](https://en.wikipedia.org/wiki/Adapter_pattern) for your
classifier and plug both along with a pair of training set and test
set and see the numbers pop out. Thus I have to make it simple so you
don't need to modify the internals of the classifier (the Adapter
could transform true/false values of your classifier's methods to
Positive/Negative instances of the enum or simply return their value
in a renamed function like `isPositive()`).

I think the typical classifier will return true or false in a method
named like `classify()` or `isX()` so maybe the second approach is the
simplest. I think that any of the three approaches could be easily
worked into another with an Adapter, so there's nothing to worry
about.


# Interface

Initially it will be used through a CLI, but I will try to make it so
it can be used in a web interface.
