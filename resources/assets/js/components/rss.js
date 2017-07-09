import Grid from './grid';
import Pusher from '../mixins/pusher';
import SaveState from '../mixins/save-state';

export default {

    template: `
        <grid :position="grid" modifiers="overflow padded blue">
            <section class="github-file">
                <h1 class="github-file__title">Groceries</h1>
                <div  class="github-file__content">
                    {{{ contents }}}
                </div>
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
            contents: '',
        };
    },

    methods: {
        getEventHandlers() {
            return {
                'App\\Components\\Trello\\Events\\FileContentFetched': response => {
                    this.contents = response.fileContent;
                },
            };
        },

        getSavedStateId() {
            return `trello`;
        },
    },
};
