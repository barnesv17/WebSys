### Part 1a
We begin part1a by calling
```
window.onload = function () {
    document.getElementById("info").innerHTML =
        getElementsRecursively(document.getElementsByTagName("html")[0], "", "", false);
```
This call replaces the innerHTML of the element id'ed as `info` with the return value of
the function `getElementsRecursively` on Lab4 page load.
Taking a closer look at `getElementsRecursively`, we see it takes 3 arguments: element, level,
ret. Element is the current node in the DOM that the function is at. Level is a string of dashes
that represents the level the current node in the DOM is at. ret is a string that will display
in the innerHTML of the `info` element.
`getElementsRecursively` checks if the current node in the DOM has any children. If there are
no children, then we have reached the last node in the DOM and can end the recursive call.
If there are children, then the function recursively calls `getElementsRecursively` on each child.

We want to use the DOM in our web development to implement interactive  operations. HTML is
mostly "set in stone" once loaded, but we can use the DOM and JavaScript to modify a page after
the HTML is already loaded.

### Part 1b
In Part 1a, our code recursively calls ".children" which returns a list of all of an element's children. In Part 1b, we somewhat mimicked the functionality of ".children" by calling "getElementsByClassName" instead and labeling all children at a given level with the same class name. By calling our function in 1b
recursively as we loop through all children at a given level, our code was able to maintain the order
of the DOM. In Part1b, each class name is "-"*level, so it was simple to traverse down each level (by adding another "-" to the "getElementsByClassName" call each time).
The return values of 1a and 1b are the same. Both return identical strings.

### Part 2
After finding the body tag, we switch to another recursive function, given that once reaching the body, all other elements found recusively should be within the body. In the new function, we add an onclick function that calls an alert with its own element tag.

### Part 3
By creating a clone of the third div element and finding its parent, I changed the innerHTML of the cloned "div" node to desired quote. Then by appending the cloned node with parent.appendChild(clonedNode), the clone is added as a new child.

By obtaining div elements as an array in the document, I looped through all div tags, for each, a "mouseover" and a "mouseout" event listener is added to change the style (reverse linear-gradient direction and one base color and increase padding on left by 10px) and to change back to default when mouse out is triggered.

### Worklog
Derek:
– Part 1a functionality
Virginia:
- Part 1b functionality
- Part 1a README
- Part 1b README
Gabe
- Part 2 functionality
- Part 2 README
Kyle:
- Part 3 functionality
- Part 3 README