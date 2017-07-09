/**
 * Created by Desktop on 7-8-2016.
 */
import Grid from './grid';

export default {
    template: `
        <grid :position="grid" modifiers="overflow padded blue">
            <section class="cleaning-schedule">
                <h1 class="cleaning-schedule__title">{{ fileName | capitalize }}</h1>
                <div  class="cleaning-schedule__content">
                    {{{ contents }}}
                </div>
            </section>
        </grid>
    `,

    components: {
        Grid,
    },

    props: ['fileName', 'grid'],

    data() {
        return {
            contents: 'CLEAN',
        };
    }
};
