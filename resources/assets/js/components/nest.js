/**
 * Created by Desktop on 7-8-2016.
 */
import Grid from './grid';
import Pusher from '../mixins/pusher';
import SaveState from '../mixins/save-state';

export default {
    template: `
        <grid :position="grid" modifiers="overflow padded">
            <section class="temperature">
                <div  class="temperature__current">
                    {{{ data.ambient_temperature_c }}}<sup>c</sup>
                </div>
                <div class="temperature__set">
                    {{{ data.target_temperature_c }}}<sup>c</sup>
                </div>
            </section>
        </grid>
    `,

    components: {
        Grid,
    },

    mixins: [Pusher, SaveState],

    props: ['grid'],

    data() {
        return {
            data: '',
        };
    },

    methods: {
        getEventHandlers() {
            return {
                'App\\Components\\Nest\\Events\\ReadNest': response => {
                this.data = response.data;
        }
        };
        },

        getSavedStateId() {
            return 'nest';
        },
    },
};
