### Part 1a
We begin part1a by calling
```
window.onload = function () {
    document.getElementById("info").innerHTML =
        getElementsRecursively(document.getElementsByTagName("html")[0], "", "", false);
```
This call replaces the innerHTML of the element id'ed as `info` with the return value of
the function `getElementsRecursively` after the Lab4 page loads. We call the recursive function
after the page loads so the each element that the function is trying to look for exists on the page.

Taking a closer look at `getElementsRecursively`, we see it takes 3 arguments: element, level,
ret. Element is the current node in the DOM that the function is at. Level is a string of dashes
that represents the level the current node in the DOM is at. ret is a string that will display
in the innerHTML of the `info` element.

`getElementsRecursively` checks if the current node in the DOM has any children. If there are
no children, then we have reached the last nested node in the DOM and can end the recursive call.
If there are children, then the function recursively calls `getElementsRecursively` on each child.

We want to use the DOM in our web development to implement interactive operations. HTML is
mostly "set in stone" once loaded, but we can use the DOM and JavaScript to modify a page after
the HTML is already loaded.

### Part 1b
For part1b, our team changed the initial call to the recursive function from using getElementsByTagName
to using getElementsByClassName. Then, elements were recursed on the same way as in part1a using
element.children and keeping track of the depth.
The return value of the two functions are the same. Both are identical strings.

### Part 2
After finding the body tag, we switch to another recursive function, given that once reaching the body, all other elements found recusively should be within the body. In the new function, we add an onclick function that calls an alert with its own element tag.

### Part 3
By creating a clone of the third div element and finding its parent, I changed the innerHTML of the cloned "div" node to desired quote. Then by appending the cloned node with parent.appendChild(clonedNode), the clone is added as a new child.

By obtaining div elements as an array in the document, I looped through all div tags, for each, a "mouseover" and a "mouseout" event listener is added to change the style (reverse linear-gradient direction and one base color and increase padding on left by 10px) and to change back to default when mouse out is triggered.

### Worklog
Derek:
– Part 1a functionality
- Part 1a README
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
