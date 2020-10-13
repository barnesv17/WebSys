// Part1A commented out as is it has been modified in part 2
// function getElementsRecursively(element, level, ret) {
//     ret = `${level} ${element.tagName}\n`;
//     if (!element.children) {
//         return ret;
//     } else {
//         var child = element.children;
//         for (var i = 0; i < child.length; i++) {
//             ret += getElementsRecursively(child[i], `${level}-`, ret);
//         }
//     }
//     return ret;
// }

// Part1B
function getElementsRecursivelyPartB(element, level, ret) {
    ret = `${level} ${element.tagName}\n`;
    if (!getElementsByClassName(`${level}-`)[0]) {
        return ret;
    } else {
        var child = getElementsByClassName(`${level}-`)[0];
        for (var i = 0; i < child.length; i++) {
            ret += getElementsRecursivelyPartB(child[i], `${level}-`, ret);
        }
    }
    return ret;
}

// Part 2
function getElementsRecursively(element, level, ret) {
    ret = `${level} ${element.tagName}\n`;
    if (!element.children) {
        return ret;
    } else {
        var child = element.children;
        for (var i = 0; i < child.length; i++) {
            if (child[i].tagName == 'BODY') {
                ret += getElementsRecursivelyBody(child[i], `${level}-`, ret);
            } else {
                ret += getElementsRecursively(child[i], `${level}-`, ret);
            }
        }
    }
    return ret;
}

function getElementsRecursivelyBody(element, level, ret) {
    ret = `${level} ${element.tagName}\n`;
    if (!element.children) {
        return ret;
    } else {
        var child = element.children;
        for (var i = 0; i < child.length; i++) {
            child[i].onclick = function () {
                alert(this.tagName);
            }
            ret += getElementsRecursivelyBody(child[i], `${level}-`, ret);
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
        divs[i].addEventListener("mouseover", function () {
            this.style.backgroundImage = "linear-gradient(225deg, #7A88FF, #A0D2EB, #98FFEE, #FF5295)"
            this.style.paddingLeft = "40px";
        }, false);
        divs[i].addEventListener("mouseout", function () {
            this.style.backgroundImage = "";
            this.style.paddingLeft = "30px";
        }, false);
    }
}

// =================================== Main =========================================

/* Call function getElementRecursively after window is loaded
   to avoid NULL returned by getElementById("info").innerHTML.
*/
window.onload = function () {
    document.getElementById("info").innerHTML =
        getElementsRecursively(document.getElementsByTagName("html")[0], "", "", false);
    document.getElementById("part1b").innerHTML =
        getElementsRecursivelyPartB(document.getElementsByClassName("html")[0], "", "", false);
    window.onload = addQuote();
    window.onload = styleManipulation();
}
