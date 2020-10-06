function getElementsRecursively(element, level) {
    if (!element || !element[0] || !element.children) {
        console.log(`${level} ${element[0]}`);
    } else {
        var child = element.children;
        console.log(element[0].tagName);
        for (var i = 0; i < child.length; i++) {
            console.log(child[i].tagName);
            getElementsRecursively(child[i], `${level}-`);
        }
    }
}

getElementsRecursively(document.getElementsByTagName("html"), "");
