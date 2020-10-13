### Part 1b
In Part 1a, our code recursively calls ".children" which returns a list of all of an element's children. In Part 1b, we somewhat mimicked the functionality of ".children" by calling "getElementsByClassName" instead and labeling all children at a given level with the same class name. By calling our function in 1b
recursively as we loop through all children at a given level, our code was able to maintaint the order
of the DOM. In Part1b, each class name is "-"*level, so it was simple to traverse down each level (by adding another "-" to the "getElementsByClassName" call each time).
The return values of 1a and 1b are the same. Both return identical strings.

### Part 2
After finding the body tag, we switch to another recursive function, given that once reaching the body, all other elements found recusively should be within the body. In the new function, we add an onclick function that calls an alert with its own element tag.
