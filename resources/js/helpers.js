export function char_limit(value, size) {
    value = value.toString();
    if (!value) return '';

    if (value.length <= size) {
        return value;
    }
    return value.substr(0, size) + '...';
}

export function nl2br(str, isXhtml = false) {
    if (typeof str === 'undefined' || str === null) {
        return ''
    }

    let breakTag = (isXhtml || typeof isXhtml === 'undefined') ? '<br ' + '/>' : '<br>'

    return (str + '')
        .replace(/(\r\n|\n\r|\r|\n)/g, breakTag + '$1')
}

export function underscore2dot(str) {
    return str.replaceAll('_', '.');
}
