import Grid from './grid';
import Pusher from '../mixins/pusher';
import SaveState from '../mixins/save-state';

export default {

    template: `
        <grid :position="grid" modifiers="overflow padded blue">
                <section class="google-calendar">
                    <h1>Latest News</h1>
                    <ul class="google-calendar__events cycle-slideshow" data-cycle-fx="scrollVert" data-cycle-speed="500" data-timeout="8000" data-cycle-slides="> li">
                        <li v-for="item in items"  class="google-calendar__event">
                            <h2 class="google-calendar__event__title">{{ item.title }}</h2>
                            <div class="google-calendar__event__date">{{ item.intro }}</div>
                        </li>
                    </ul>
                </section>
             </grid>
    `,

    components: {
        Grid,
    },

    mixins: [Pusher, SaveState],

    props: ['boardId', 'grid'],

    data() {
        return {
            items: [],
        };
    },

    methods: {
        getEventHandlers() {
            return {
                'App\\Components\\RSS\\Events\\FileContentFetched': response => {
                    this.items = response.items;
                },
            };
        },

        getSavedStateId() {
            return `rss`;
        },
    },
};
