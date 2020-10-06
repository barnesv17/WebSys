// Part1 A
function getElementsRecursively(element, level, ret) {
    ret = `${level} ${element.tagName}\n`;
    if (!element || !element.children) {
        return ret;
    } else {
        var child = element.children;
        for (var i = 0; i < child.length; i++) {
            ret += getElementsRecursively(child[i], `${level}-`, ret);
        }
    }
    return ret;
}


// =================================== Main =========================================

/* Call function getElementRecursively after window is loaded
   to avoid NULL returned by getElementById("info").innerHTML.
*/
window.onload = function() {
    document.getElementById("info").innerHTML = 
        getElementsRecursively(document.getElementsByTagName("html")[0], "", "");
}
