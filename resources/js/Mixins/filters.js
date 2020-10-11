import Vue from 'vue';
import {char_limit, nl2br} from "../helpers";

Vue.filter('char_limit', char_limit);

Vue.filter('nl2br', nl2br);
