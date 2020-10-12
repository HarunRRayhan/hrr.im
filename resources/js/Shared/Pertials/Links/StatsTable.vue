<template>
    <div class="w-full mt-6 md:mt-12">
        <div class="w-full flex items-center mb-4 px-2">
            <h3 class="font-bold text-2xl">Statistics</h3>
            <span
                class="ml-2 text-sm font-bold px-3 py-1 rounded-full"
                :class="{'bg-indigo-200  text-indigo-700': clicks > 0, 'bg-red-200  text-red-700': !clicks}"
            >{{ clicks }} Clicks</span>
        </div>


        <div
            class="bg-white rounded shadow overflow-x-auto"
            v-if="statistics.data">
            <table class="w-full whitespace-no-wrap">
                <tr class="text-left font-bold">
                    <th class="px-6 pt-6 pb-4">Browser</th>
                    <th class="px-6 pt-6 pb-4">Device</th>
                    <th class="px-6 pt-6 pb-4">OS</th>
                    <th class="px-6 pt-6 pb-4">Status</th>
                    <th class="px-6 pt-6 pb-4">IP Address</th>
                    <th class="px-6 pt-6 pb-4">Referrer</th>
                </tr>
                <tr
                    v-for="stat in statistics.data"
                    :key="stat.id"
                    class="hover:bg-gray-100 focus-within:bg-gray-100"
                >
                    <td class="border-t">
                        <span
                            class="flex px-6 py-4"
                            v-if="stat.agent.browser.name"
                        >
                            <span class="flex items-center">
                                <icon
                                    :name="browserIcon(stat.agent.browser.name)"
                                    class="block w-4 h-4 fill-gray-600 mr-1"
                                />
                                {{ stat.agent.browser.name }}
                            </span>
                            <span
                                v-if="stat.agent.browser.version"
                                class="text-xs font-bold bg-green-100 px-3 py-1 rounded-full text-green-600 flex-end"
                            >{{ stat.agent.browser.version }}</span>
                        </span>
                    </td>
                    <td class="border-t">
                        <span class="block px-6 py-4">
                        {{ deviceName(stat.agent.device) }}
                        </span>
                    </td>
                    <td class="border-t">
                        <span
                            class="block px-6 py-4"
                            v-if="stat.agent.platform.name "
                        >
                            <span>{{ stat.agent.platform.name }}</span>

                            <span
                                v-if="stat.agent.platform.version"
                                class="text-xs font-bold bg-red-50 px-3 py-1 rounded-full text-red-500"
                            >{{ stat.agent.platform.version | underscore2dot }}</span>
                        </span>
                    </td>
                    <td class="border-t">
                        <span
                            class="block pl-4 pr-6 py-4"
                        >
                            <span
                                v-if="stat.success"
                                class="text-sm font-bold bg-green-100 px-3 py-1 rounded-full text-green-600"
                            >Success</span>
                            <span
                                v-else
                                class="text-sm font-bold bg-red-100 px-3 py-1 rounded-full text-red-600"
                            >Failed</span>
                        </span>
                    </td>
                    <td class="border-t">
                        <span class="block px-6 py-4">
                        {{ stat.ip_address }}
                        </span>
                    </td>
                    <td class="border-t">
                        <span class="block px-6 py-4">
                        {{ stat.referer }}
                        </span>
                    </td>
                </tr>
            </table>
        </div>
        <pagination

            :links="statistics.links"
        />
    </div>
</template>

<script>
import Pagination from "../../Pagination";
import Icon from "../../Icon";

export default {
    name: "StatsTable",
    components: {
        Pagination,
        Icon,
    },
    props: {
        link: Object,
        statistics: Object,
    },
    computed: {
        clicks() {
            return this.link.statistics_count ? this.link.statistics_count : 0;
        },
    },
    methods: {
        deviceName(device) {
            if (device.name) {
                return device.name;
            } else if ('robot' === device.type) {
                return 'Robot';
            }

            return "Unknown";
        },
        browserIcon(name) {
            name = name.toLowerCase();

            const browsers = [
                'chrome',
                'firefox',
                'safari',
                'opera',
                'edge',
            ]

            for (let i = 0; i < browsers.length; i++) {
                if (name.includes(browsers[i])) return browsers[i];
            }

            return 'unknown-browser';
        }
    }
}
</script>

<style scoped>

</style>
