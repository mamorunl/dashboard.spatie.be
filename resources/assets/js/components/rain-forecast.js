import _ from 'lodash';
import Graph from './graph';
import Grid from './grid';
import moment from 'moment';
import Pusher from '../mixins/pusher';
import SaveState from '../mixins/save-state';

export default {

    template: `
        <grid :position="grid" modifiers="padded">
            <section :class="status | modify-class 'rain-forecast'">
                <h1 class="rain-forecast__title rain-forecast__title--rainy" v-if="status == 'rainy'">30' FORECAST</h1>
                <h1 class="rain-forecast__title rain-forecast__title--rainy" v-if="status == 'wet'">STAY INSIDE</h1>
                <div class="rain-forecast__background"></div>
                <div class="rain-forecast__graph" v-if="status == 'rainy'">
                    <graph
                      :labels="graphLabels"
                      :values="graphData"
                      line-color="rgba(19,134,158, .5)"
                      background-color="rgba(19,134,158, .25)"
                    ></graph>
                </div>     
                <div class="rain-forecast__extra">
                    <div class="rain-forecast__extra-block">{{ wunderground.max_temp }}<sup>c</sup> <small>Max Temp</small></div>                    
                    <div class="rain-forecast__extra-block">{{ wunderground.max_rain }}% <small>Rain</small></div>                    
                    <div class="rain-forecast__extra-block">{{ wunderground.max_snow }}mm <small>Snow</small></div>                   
                    <div class="rain-forecast__extra-block">{{{ getWeatherAt9() }}} <small>@ 09:00</small></div>                   
                    <div class="rain-forecast__extra-block">{{{ getWeatherAt17() }}} <small>@ 17:00</small></div>                   
                </div>
            </section>
        </grid>
    `,

    components: {
        Grid, Graph,
    },

    mixins: [Pusher],

    props: ['grid'],

    computed: {
        status() {

            if (this.noRainPredicted()) {
                return 'dry';
            }

            if (this.nothingButRainPredicted()) {
                return 'wet';
            }

            return 'rainy';
        },

        graphLabels() {
            return _.map(this.forecast, 'minutes');
        },

        graphData() {
            return _.map(this.forecast, 'chanceOfRain');
        },

        graphPeriod() {
            return this.forecast[this.forecast.length-1].minutes;
        },
    },

    data() {
        return {
            forecast: [
            ],
            wunderground: [
            ]
        };
    },

    methods: {
        getEventHandlers() {
            return {
                'App\\Components\\RainForecast\\Events\\ForecastFetched': response => {
                    this.forecast = response.forecast;
                },
                'App\\Components\\Wunderground\\Events\\DataFetched': response => {
                    this.wunderground = response.wunderground
                }
            };
        },

        getSavedStateId() {
            return 'rain-forecast-update';
        },

        noRainPredicted() {
            let rainScore = _.sumBy(this.forecast, foreCastItem => {
                return parseInt(foreCastItem.chanceOfRain);
            });

            return rainScore == 0;
        },

        nothingButRainPredicted() {
            let foreCastItemWithNoRain = _.filter(this.forecast, foreCastItem => {
                return foreCastItem.chanceOfRain < 40;
            }).length;

            return foreCastItemWithNoRain.length == 0;
        },

        getWeatherAt9() {
            return this.getWeatherAt(this.wunderground.data_9);
        },

        getWeatherAt17() {
            return this.getWeatherAt(this.wunderground.data_17);
        },

        getWeatherAt(array_fields) {
            return array_fields['temperature'] + "<sup>c</sup>/" + array_fields['rain'] + "%" + (array_fields['day'] > array_fields['cur_day'] ? " &tau;" : "");
        }
    },
};
