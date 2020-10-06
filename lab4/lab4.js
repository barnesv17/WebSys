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
document.getElementById("info").innerHTML = getElementsRecursively(document.getElementsByTagName("html")[0], "", "");