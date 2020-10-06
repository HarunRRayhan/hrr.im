import Vue from 'vue';

Vue.filter('char_limit', function (value, size) {
    value = value.toString();
    if (!value) return '';

    if (value.length <= size) {
        return value;
    }
    return value.substr(0, size) + '...';
});
