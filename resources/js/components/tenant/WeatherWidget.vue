<template>
    <el-card class="weather-widget" v-loading="loading" element-loading-background="rgba(255, 255, 255, 0)">
        <template v-if="data">
            <div :class="`owi owi-${data.weather[0].icon}`"></div>
            <div class="content">
                <div class="city">{{ data.name }}</div>
                <div class="temperature">
                    <div>{{ data.main.temp | celsius }}</div>
                    <small>
                        <span>min {{ data.main.temp_min | celsius }}</span>
                        <span>max {{ data.main.temp_max | celsius }}</span>
                    </small>
                </div>
                <div class="description">{{ data.weather[0].description }}</div>
                <table class="extra">
                    <tr>
                        <td class="wind">
                            <small>Wind</small>
                            {{ data.wind.speed }}m/s
                        </td>
                        <td class="cloudiness">
                            <small>Cloudiness</small>
                            {{ data.clouds.all }}%
                        </td>
                        <td class="humidity">
                            <small>Humidity</small>
                            {{ data.main.humidity }}%
                        </td>
                        <td class="pressure">
                            <small>Pressure</small>
                            {{ data.main.pressure }}hPa
                        </td>
                    </tr>
                </table>
            </div>
        </template>
    </el-card>
</template>

<script>
    import axios from '@/axios'
    import Card from 'components/Card'
    import {displaySuccess, displayError} from 'helpers/messages'

    export default {
        components: {
            Card
        },
        data() {
            return {
                loading: false,
                data: null
            }
        },
        filters: {
            celsius(value) {
                return ~~(value - 273.15)
            }
        },
        methods: {
            async get() {
                try {
                    this.loading = true

                    const {data} = await axios.get('news/weather.json')

                    this.data = data
                } catch (err) {
                    displayError(err)
                } finally {
                    this.loading = false
                }
            }
        },
        async mounted() {
            await this.get()
        }
    }
</script>

<style lang="scss" scoped>
    .weather-widget {
        min-height: 173px;
        :global(.el-card__body) {
            display: flex;
            align-items: center;

            .owi {
                font-size: 96px;
            }

            .content {
                flex: auto;
                line-height: 1.56;
                margin-left: 16px;

                .city {
                    font-size: 24px;
                    font-weight: bold;
                }

                .temperature {
                    display: flex;
                    align-items: center;
                    font-size: 32px;
                    font-weight: bold;
                    line-height: 1.0;

                    div {
                        display: flex;

                        &:after {
                            content: '\00b0' + 'C';
                            letter-spacing: -2px;
                        }
                    }

                    small {
                        display: flex;
                        flex-direction: column;
                        margin-left: 8px;
                        font-size: 44%;
                        font-weight: normal;
                        color: darken(#fff, 32%);

                        span:after {
                            content: '\00b0' + 'C';
                            letter-spacing: -2px;
                        }
                    }
                }

                .description {
                    font-weight: bold;
                }

                table.extra {
                    margin: 0 -6px;

                    td {
                        padding: 0 6px;

                        small {
                            font-weight: bold;
                            color: darken(#fff, 24%);
                            display: block;
                        }
                    }
                }
            }

            .el-button {
                position: absolute;
                top: 0;
                right: 0;
                margin: 8px;
            }
        }
    }

    @media only screen and (max-width: 475px) {
        .weather-widget {
            :global(.el-card__body) {
                flex-direction: column;
            }
        }
    }
</style>
