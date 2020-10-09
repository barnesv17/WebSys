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

// Part3
function addQuote() {
    var temp = document.getElementsByTagName("div")[3];
    var parent = temp.parentElement;
    var clone = temp.cloneNode();
    clone.innerHTML = "<h2>Quote</h2>";
    clone.innerHTML += "Any application that can be written in JavaScript, will eventually be written in JavaScript.<br><strong>Jeff Atwood, 2007</strong>";
    parent.appendChild(clone);
}
function styleManipulation() {
    var divs = document.getElementsByTagName("div");
    for (var i = 0; i < divs.length; i++) {
        divs[i].addEventListener("mouseover", function() {
            this.style.backgroundImage = "linear-gradient(225deg, #7A88FF, #A0D2EB, #98FFEE, #FF5295)"
            this.style.paddingLeft = "40px";
        }, false);
        divs[i].addEventListener("mouseout", function() {
            this.style.backgroundImage = "";
            this.style.paddingLeft = "30px";
        }, false);
    }
}

// =================================== Main =========================================

/* Call function getElementRecursively after window is loaded
   to avoid NULL returned by getElementById("info").innerHTML.
*/
window.onload = function() {
    document.getElementById("info").innerHTML = 
        getElementsRecursively(document.getElementsByTagName("html")[0], "", "");
window.onload = addQuote();
window.onload = styleManipulation();
}
