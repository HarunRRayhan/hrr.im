export function char_limit(value, size) {
    value = value.toString();
    if (!value) return '';

    if (value.length <= size) {
        return value;
    }
    return value.substr(0, size) + '...';
}

export function nl2br(str, isXhtml = false) {
    // Some latest browsers when str is null return and unexpected null value
    if (typeof str === 'undefined' || str === null) {
        return ''
    }

    // Adjust comment to avoid issue on locutus.io display
    var breakTag = (isXhtml || typeof isXhtml === 'undefined') ? '<br ' + '/>' : '<br>'

    return (str + '')
        .replace(/(\r\n|\n\r|\r|\n)/g, breakTag + '$1')
}
